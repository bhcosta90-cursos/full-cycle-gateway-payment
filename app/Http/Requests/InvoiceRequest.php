<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'account_id' => ['required', 'exists:accounts'],
            'status' => ['required', 'integer'],
            'description' => ['required'],
            'type' => ['required'],
            'card_last_digits' => ['required'],
            'amount' => ['required', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
