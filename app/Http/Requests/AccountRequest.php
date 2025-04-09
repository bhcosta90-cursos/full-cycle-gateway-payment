<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => ['required'],
            'email' => ['required', 'email:rfc,filter', 'max:254'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
