<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'maiden_name' => $this->maiden_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,

            // Status
            'status' => $this->status,
            'terms' => $this->terms,

            // Business Info
            'business_name' => $this->business_name,
            'business_logo' => $this->business_logo,
            'industry' => $this->industry,
            'years_in_business' => $this->years_in_business,
            'registration_number' => $this->registration_number,
            'business_type' => $this->business_type,
            'business_phone' => $this->business_phone,

            // Location
            'address' => $this->address,
            'lga' => $this->lga,
            'state' => $this->state,
            'country' => $this->country,
            'years_at_location' => $this->years_at_location,

            // Documents
            'tin' => $this->tin,

            // Login info
            'last_login_ip' => $this->last_login_ip,
            'last_login_location' => $this->last_login_location,
            'last_login_device' => $this->last_login_device,
            'last_login_at' => $this->last_login_at,
            'last_logout_at' => $this->last_logout_at,

            // Lock info
            'login_attempts' => $this->login_attempts,
            'is_locked' => $this->is_locked,
            'lock_reason' => $this->lock_reason,

            // Registration info
            'registration_ip' => $this->registration_ip,
            'registration_location' => $this->registration_location,
            'registration_device' => $this->registration_device,

            // Timestamps
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
