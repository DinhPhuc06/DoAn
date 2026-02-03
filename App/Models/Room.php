<?php

namespace App\Models;

use App\Core\Model;


class Room extends Model
{
    protected string $table = 'room_details';

    protected array $fillable = [
        'room_type_id',
        'room_number',
        'status',
    ];
}
