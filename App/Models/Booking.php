<?php

namespace App\Models;

use App\Core\Model;

class Booking extends Model
{
    protected string $table = 'bookings';

    protected array $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'type',
        'event_type',
        'payment_menthod',
        'payment_at',
    ];
}
