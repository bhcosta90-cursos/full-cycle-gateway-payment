<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

final class Account extends User
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'email',
        'api_key',
        'balance',
    ];
}
