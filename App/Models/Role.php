<?php

namespace App\Models;

use App\Core\Model;

/** Model Role - Bảng roles. CRUD: getAll, findById, create, update, delete. */
class Role extends Model
{
    protected string $table = 'roles';

    protected array $fillable = ['name'];
}
