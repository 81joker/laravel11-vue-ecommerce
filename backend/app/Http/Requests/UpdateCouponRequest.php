<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|unique:coupons,name," . $this->coupon->id . "|max:20",
            "discount" => "required|numeric|min:1|max:100",
            "valid_until" => "required|date|after:today"
        ];
    }

    public function messages(): array
    {
        return [
            "valid_until.required" => "The coupon validity is required",
        ];
    }
}
