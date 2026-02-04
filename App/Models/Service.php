<?php

namespace App\Models;

use App\Core\Model;
use PDO;

/** Model Service - Bảng services. */
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

    /**
     * Dịch vụ addon (đi kèm loại phòng khi hiển thị)
     */
    public function getAddons(): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `type` = 'addon' AND (`is_active` = 1 OR `is_active` IS NULL)";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
