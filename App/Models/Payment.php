<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    protected string $table = 'payments';

    protected array $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'paid_at',
        'currency',
        'result_code',
        'message',
    ];
}
