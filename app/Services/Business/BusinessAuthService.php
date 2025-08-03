<?php

namespace App\Services\Business;

use App\Models\Account;
use App\Models\Business;
use App\Traits\HttpResponses;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\Business\BusinessRegisterMail;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Business\BusinessResource;
use App\Services\Business\BusinessAccountService;

class BusinessAuthService
{
    use HttpResponses;

    public $accountService;
    public function __construct(BusinessAccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function login($request)
    {
        $data = $request->validate([
            'email' => 'required|exists:businesses,email',
            'password' => 'required'
        ]);

        $business = Business::where('email', $data['email'])->first();
        if (!$business) {
            return $this->error('Invalid credentials');
        }
        if ($business->is_locked) {
            return $this->error('Account is locked');
        }
        if ($business->status !== 'active') {
            return $this->error('Account is inactive');
        }
        if (!Hash::check($data['password'], $business->password)) {
            DB::table('businesses')
                ->where('id', $business->id)
                ->increment('login_attempts');
            // Get fresh instance from database
            $business = Business::find($business->id);
            if ($business->login_attempts >= 3) {
                $updated = DB::table('businesses')
                    ->where('id', $business->id)
                    ->update([
                        'is_locked' => true,
                        'lock_reason' => 'Exceeded 3 failed login attempts',
                        'updated_at' => now()
                    ]);
                return $this->error('Account is locked due to multiple failed login attempts');
            }

            return $this->error('Invalid credentials');
        }

        // Success - reset attempts and login
        $business->update([
            'login_attempts' => 0,
            'is_locked' => false,
            'lock_reason' => null,
            'last_login_ip' => $request->ip(),
            'last_login_device' => $request->header('User-Agent'),
            'last_login_device_type' => $this->detectDevice($request->header('User-Agent')),
            'last_login_at' => now(),
        ]);

        $token = $business->createToken($data['email'])->plainTextToken;

        return $this->success('Login successful', [
            'user' => new BusinessResource($business),
            'access_token' => $token,
        ]);
    }



    public function register($request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('businesses', 'email')],
            'phone_number' => ['required', 'string', 'digits:11', Rule::unique('businesses', 'phone_number')],
            'password' => ['required', 'string', 'min:8'],
            'terms' => ['required', 'boolean', 'accepted'],
        ]);


        $otp = rand(100000, 999999);
        $otpExpiredAt = now()->addMinutes(10);

        $device = $request->header('User-Agent');
        $ip = $request->header('X-Forwarded-For', $request->ip());
        $location = $this->getFullLocationFromIp($ip);

        $business = Business::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'terms' => $validated['terms'],
            'otp' => $otp,
            'otp_expired_at' => $otpExpiredAt,
            'country' => Session::get('registration.country'),
            'registration_ip' => $ip,
            'registration_location' => $location,
            'registration_device' => $device
        ]);


        $this->accountService->createSavingsAccount($business->id);

        Mail::to($validated['email'])->send(new BusinessRegisterMail($validated['first_name'], $otp));

        return $this->success('Account Saved', ['email' => $business->email]);
    }


    private function getFullLocationFromIp(string $ip): ?array
    {

        $response = Http::get("http://ip-api.com/json/{$ip}?fields=61439")->json();

        if ($response['status'] === 'success') {
            return $response;
        }


        return null;
    }


    private function detectDevice($userAgent): string
    {
        $userAgent = strtolower($userAgent);

        if (str_contains($userAgent, 'mobile')) {
            return 'mobile';
        } elseif (str_contains($userAgent, 'tablet')) {
            return 'tablet';
        } elseif (str_contains($userAgent, 'windows') || str_contains($userAgent, 'macintosh') || str_contains($userAgent, 'linux')) {
            return 'desktop';
        }

        return 'unknown';
    }



    public function verifyEmail($request)
    {
        $validated = $request->validate([
            'otp' => 'required|digits:6',
            'email' => 'required'

        ]);

        $business = Business::where('email', $request['email'])->first();

        if (!$business) {
            return $this->error('Business not found.');
        }

        if ($business->email_verified_at) {
            return $this->success('Your account has already been verified.');
        }

        if ($business->otp !== $validated['otp']) {
            return $this->error('Invalid OTP');
        }

        if (now()->greaterThan($business->otp_expired_at)) {
            return $this->error('The OTP has expired. Please resend OTP.');
        }

        $business->update([
            'otp_verified_at' => now(),
            'email_verified_at' => now(),
            'status' => 'active',
            'is_locked' => true

        ]);

        return $this->success('Your OTP has been successfully verified');
    }

    public function resendOtp($request)
    {
        $email = $request->email;
        $otp = rand(100000, 999999);
        $otpExpiredAt = now()->addMinutes(1);
        $business = Business::where('email', $email)->first();
        if ($business) {
            $business->update([
                'otp' => $otp,
                'otp_expired_at' => $otpExpiredAt,
                'email_verified_at' => '',

            ]);
            Mail::to($email)->send(new BusinessRegisterMail($business->first_name, $otp));
            return $this->success('OTP has being resent');
        }
        return $this->error('Invalid credentials');
    }




    public function stepThree($request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:businesses,email',
            'business_name' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'years_in_business' => 'required|numeric',
            'business_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $business = Business::where('email', $validated['email'])->first();

        if ($request->hasFile('business_logo')) {
            $path = $request->file('business_logo')->store('uploads/business/profile', 'public');
            $business->business_logo = $path;
        }

        $business->update([
            'business_name' => $validated['business_name'],
            'industry' => $validated['industry'],
            'years_in_business' => $validated['years_in_business'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Business details updated successfully',
            'data' => $business
        ]);
    }


    public function logout($request)
    {
        $user = Auth::guard('business')->user();
        $user->currentAccessToken()->delete();
        return $this->success('Logged out successfully');
    }









    public function stepFour($request)
    {
        $validated =  $request->validate([
            'email' => 'required',
            'registration_number' => 'required|string|max:255',
            'business_type' => 'required|string',
            'business_phone' => 'required',
            'address' => 'required|string',
            'state' => 'required|string',
        ]);

        $business = Business::where('email', $validated['email'])->first();

        if (!$business) {
            return $this->error('Business record not found');
        }
        $business->registration_number = $request->registration_number;
        $business->business_type = $request->business_type;
        $business->business_phone = $request->business_phone;
        $business->address = $request->address;
        $business->state = $request->state;
        $business->save();

        return $this->success('Business details saved successfully');
    }
}
