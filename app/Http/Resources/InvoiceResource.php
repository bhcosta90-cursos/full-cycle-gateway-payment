<?php

declare(strict_types = 1);

namespace App\Http\Resources;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Invoice */
final class InvoiceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id'               => $this->id,
            'status'           => $this->status,
            'description'      => $this->description,
            'type'             => $this->type,
            'card_last_digits' => $this->card_last_digits,
            'amount'           => $this->amount,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,

            'account_id' => $this->account_id,

            'account' => new AccountResource($this->whenLoaded('account')),
        ];
    }
}
