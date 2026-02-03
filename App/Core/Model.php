<?php

namespace App\Core;

use PDO;
use PDOException;


abstract class Model
{
    protected PDO $pdo;

    /** Tên bảng (bắt buộc khai báo ở model con) */
    protected string $table = '';

    /** Khóa chính, mặc định 'id' */
    protected string $primaryKey = 'id';

    /** Các cột được phép gán hàng loạt (create/update) */
    protected array $fillable = [];

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }


    public function getAll(): array
    {
        $sql = "SELECT * FROM `{$this->table}`";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function findById($id): ?array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }


    public function create(array $data)
    {
        $data = $this->filterFillable($data);
        if (empty($data)) {
            return false;
        }
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        $sql = sprintf(
            'INSERT INTO `%s` (`%s`) VALUES (%s)',
            $this->table,
            implode('`, `', $columns),
            implode(', ', $placeholders)
        );
        $stmt = $this->pdo->prepare($sql);
        $ok = $stmt->execute(array_values($data));
        return $ok ? (int) $this->pdo->lastInsertId() : false;
    }


    public function update($id, array $data): bool
    {
        $data = $this->filterFillable($data);
        if (empty($data)) {
            return false;
        }
        $set = [];
        foreach (array_keys($data) as $col) {
            $set[] = "`{$col}` = ?";
        }
        $sql = sprintf(
            'UPDATE `%s` SET %s WHERE `%s` = ?',
            $this->table,
            implode(', ', $set),
            $this->primaryKey
        );
        $stmt = $this->pdo->prepare($sql);
        $params = array_values($data);
        $params[] = $id;
        return $stmt->execute($params);
    }


    public function delete($id): bool
    {
        $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


    protected function filterFillable(array $data): array
    {
        if (empty($this->fillable)) {
            return $data;
        }
        return array_intersect_key($data, array_flip($this->fillable));
    }
}
