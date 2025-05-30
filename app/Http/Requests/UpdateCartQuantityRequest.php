<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CartItem;

class UpdateCartQuantityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:1',
                'max:99',
                function ($attribute, $value, $fail) {
                    $cartItem = CartItem::find($this->route('id'));
                    
                    if (!$cartItem) {
                        $fail('Cart item not found.');
                        return;
                    }

                    if (!$cartItem->product->hasEnoughStock($value)) {
                        $fail('Not enough stock available.');
                    }

                    if ($value < $cartItem->product->min_order_quantity) {
                        $fail('Minimum order quantity is ' . $cartItem->product->min_order_quantity);
                    }

                    if ($value > $cartItem->product->max_order_quantity) {
                        $fail('Maximum order quantity is ' . $cartItem->product->max_order_quantity);
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'quantity.required' => 'Please specify the quantity.',
            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',
            'quantity.max' => 'Quantity cannot exceed 99.',
        ];
    }
} 