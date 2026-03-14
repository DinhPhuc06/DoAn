<<<<<<< HEAD
<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    protected string $table = 'payments';

    public function create($data)
    {
        $sql = "INSERT INTO payments
        (booking_id, method, amount, status, currency, created_at)
        VALUES
        (:booking_id, :method, :amount, :status, :currency, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function updateStatus($booking_id, $status)
    {
        $sql = "UPDATE payments 
                SET status = :status, paid_at = NOW()
                WHERE booking_id = :booking_id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'status' => $status,
            'booking_id' => $booking_id
        ]);
    }
    public function all()
    {
        $sql = "SELECT * FROM payments ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
=======
<?php

namespace App\Models;

use App\Core\Model;

/** Model Payment - Bảng payments. CRUD: getAll, findById, create, update, delete. */
class Payment extends Model
{
    protected string $table = 'payments';

    protected array $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
        'paid_at',
        'currency',
        'result_code',
        'message',
    ];
}
>>>>>>> 3765e4ac47ec4b4985a25b4abc601d651c2889a3
