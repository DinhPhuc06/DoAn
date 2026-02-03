<?php

namespace App\Models;

use App\Core\Model;


class RoomType extends Model
{
    protected string $table = 'room_types';

    protected array $fillable = [
        'name',
        'capacity',
        'base_price',
    ];


    public function getAllForDisplay(): array
    {
        return $this->getAll();
    }
}
