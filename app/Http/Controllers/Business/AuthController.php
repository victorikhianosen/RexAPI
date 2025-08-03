<?php

namespace App\Http\Controllers\Business;

use App\Models\Business;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Services\Business\BusinessAuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    use HttpResponses;

    public $authService;

    public function __construct(BusinessAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function verifyEmail(Request $request)
    {
        return $this->authService->verifyEmail($request);
    }

    public function resendOtp(Request $request)
    {
        return $this->authService->resendOtp($request);
    }

    public function stepThree(Request $request)
    {
        return $this->authService->stepThree($request);
    }

    public function stepFour(Request $request)
    {
        return $this->authService->stepFour($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
}
