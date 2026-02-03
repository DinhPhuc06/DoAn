<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Service extends Model
{
    protected string $table = 'services';

    protected array $fillable = [
        'name',
        'price',
        'description',
        'type',
        'is_active',
    ];


    public function getAddons(): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `type` = 'addon' AND (`is_active` = 1 OR `is_active` IS NULL)";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
