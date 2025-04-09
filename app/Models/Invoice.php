<?php

declare(strict_types = 1);

namespace App\Models;

use App\Core\Enum\Invoice\InvoiceStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'account_id',
        'status',
        'description',
        'type',
        'card_last_digits',
        'amount',
    ];

    protected $casts = [
        'status' => InvoiceStatusEnum::class,
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeByAccountId(Builder $builder, string $accountId): void
    {
        $builder->where('account_id', $accountId);
    }
}
