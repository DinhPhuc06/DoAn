<?php

namespace App\Models;

use App\Core\Model;
use PDO;
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

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
