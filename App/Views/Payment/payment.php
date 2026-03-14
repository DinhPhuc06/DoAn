<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h4>Thanh toán đặt phòng</h4>
</div>

<div class="card-body">

<table class="table">

<tr>
<th>Mã đặt phòng</th>
<td><?= $booking['id'] ?></td>
</tr>

<tr>
<th>Số tiền</th>
<td class="text-danger fw-bold">
<?= number_format($booking['total_price']) ?> VND
</td>
</tr>

<tr>
<th>Phương thức</th>
<td>VNPay</td>
</tr>

</table>

<form method="POST" action="<?= \App\Core\url('/payment/vnpay') ?>">

<input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
<input type="hidden" name="amount" value="<?= $booking['total_price'] ?>">

<button class="btn btn-success">
Thanh toán VNPay
</button>

</form>

</div>
</div>
</div>

</body>
</html>