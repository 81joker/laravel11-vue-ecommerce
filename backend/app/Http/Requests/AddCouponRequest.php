<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCouponRequest extends FormRequest
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
            "name" => "required|unique:coupons,name|max:20",
            "discount" => "required|numeric|min:1|max:100",
            "valid_until" => "required|date|after:today"
        ];
    }

    public function messages(): array
    {
        return [
            "valid_until.required" => "The coupon validity is required",
            // "name.required" => "Coupon name is required",
            // "name.unique" => "Coupon name must be unique",
            // "name.max" => "Coupon name must not exceed 20 characters",
            // "discount.required" => "Discount value is required",
            // "discount.numeric" => "Discount value must be a number",
            // "discount.min" => "Discount value must be at least 1%",
            // "discount.max" => "Discount value must not exceed 100%",
            // "valid_until.required" => "Valid until date is required",
            // "valid_until.date" => "Valid until must be a valid date",
            // "valid_until.after" => "Valid until date must be a future date"
        ];
    }
}
