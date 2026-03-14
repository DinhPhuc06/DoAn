<?php

$success = isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == "00";

$amount = ($_GET['vnp_Amount'] ?? 0) / 100;
$transaction = $_GET['vnp_TransactionNo'] ?? '';
$order = $_GET['vnp_TxnRef'] ?? '';

?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Kết quả thanh toán</title>
<link rel="stylesheet" href="/doan/public/assets/css/style.css">

</head>

<body class="payment-body">

<div class="payment-card">

<?php if($success): ?>

<div class="payment-icon success-icon">✔</div>
<div class="payment-title">Thanh toán thành công</div>

<div class="payment-desc">
Giao dịch của bạn đã được xử lý thành công.
</div>

<?php else: ?>

<div class="payment-icon fail-icon">✕</div>
<div class="payment-title">Thanh toán thất bại</div>

<div class="payment-desc">
Giao dịch không thành công. Vui lòng thử lại hoặc liên hệ hỗ trợ.
</div>

<?php endif; ?>


<div class="payment-box">

<div class="payment-row">
<span>Mã đơn hàng:</span>
<span>#<?= $order ?></span>
</div>

<div class="payment-row">
<span>Số tiền:</span>
<span class="payment-money"><?= number_format($amount) ?> VND</span>
</div>

<div class="payment-row">
<span>Mã giao dịch:</span>
<span><?= $transaction ?></span>
</div>

</div>


<button class="payment-btn btn-home"
onclick="window.location.href='/doan/public'">
 Quay về trang chủ
</button>

<?php if(!$success): ?>

<button class="payment-btn btn-retry"
onclick="history.back()">
Thử lại
</button>

<?php endif; ?>

</div>

</body>
</html>