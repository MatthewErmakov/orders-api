<?php

namespace App\Http\Requests\Orders;

use App\Enums\OrderStatus;
use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOrder extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string'],
            'amount'       => ['required', 'integer', 'min:1'], // the amount must be in cents so we use integer
            'status'       => ['required', new Enum(OrderStatus::class)], // accept only predefined values in enum
        ];
    }
}
