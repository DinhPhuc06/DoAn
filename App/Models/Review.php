<?php

namespace App\Models;

use App\Core\Model;

/** Model Review - Bảng reviews. CRUD: getAll, findById, create, update, delete. */
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
