<?php

namespace App\Models;

use App\Core\Model;

class Review extends Model
{
    protected string $table = 'reviews';

    protected array $fillable = [
        'user_id',
        'room_id',
        'rating',
        'comment',
    ];
}
