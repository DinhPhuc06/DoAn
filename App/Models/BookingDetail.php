<?php

namespace App\Models;

use App\Core\Model;


class BookingDetail extends Model
{
    protected string $table = 'booking_details';

    protected array $fillable = [
        'booking_id',
        'room_id',
        'price',
    ];
}
