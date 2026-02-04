<?php

namespace App\Models;

use App\Core\Model;

/** Model User - Bảng users. CRUD: getAll, findById, create, update, delete. */
class User extends Model
{
    protected string $table = 'users';

    protected array $fillable = [
        'role_id',
        'full_name',
        'email',
        'password',
        'phone',
        'status',
    ];
}
