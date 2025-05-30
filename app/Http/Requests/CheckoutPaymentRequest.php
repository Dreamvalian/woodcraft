<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_address_id' => 'nullable|exists:addresses,id',
            'payment_method' => 'required|string|in:credit_card,bank_transfer,e_wallet',
            'shipping_method' => 'required|string|in:standard,express,overnight',
            'shipping_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'shipping_address_id.required' => 'Please select a shipping address.',
            'shipping_address_id.exists' => 'The selected shipping address is invalid.',
            'billing_address_id.exists' => 'The selected billing address is invalid.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'The selected payment method is invalid.',
            'shipping_method.required' => 'Please select a shipping method.',
            'shipping_method.in' => 'The selected shipping method is invalid.',
            'shipping_cost.required' => 'Shipping cost is required.',
            'shipping_cost.numeric' => 'Shipping cost must be a number.',
            'shipping_cost.min' => 'Shipping cost cannot be negative.',
        ];
    }
} 