<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class InvoiceRequest extends FormRequest
{
    public function rules()
    {
        return [
            'description'        => ['required', 'max:100'],
            'amount'             => ['required', 'integer', 'min:0'],
            'credit_card.number' => ['required', 'string', 'max:20'],
            'credit_card.cvv'    => ['required', 'string', 'max:5'],
            'credit_card.name'   => ['required', 'string', 'max:100'],
            'credit_card.month'  => ['required', 'date_format:m'],
            'credit_card.year'   => ['required', 'date_format:Y'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
