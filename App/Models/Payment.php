<?php

namespace App\Models;

use App\Core\Model;

/** Model Payment - Bảng payments. CRUD: getAll, findById, create, update, delete. */
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
