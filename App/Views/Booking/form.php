<?php
$room = $room ?? null;
$roomType = $roomType ?? null;
$checkIn = $checkIn ?? '';
$checkOut = $checkOut ?? '';
$addons = $addons ?? [];
$error = $_GET['error'] ?? '';
if (!$room) {
    echo 'Không tìm thấy phòng.';
    return;
}
$baseUrl = rtrim(APP_URL ?? '', '/');
$nights = 1;
if ($checkIn && $checkOut) {
    $nights = max(1, (strtotime($checkOut) - strtotime($checkIn)) / 86400);
}
$pricePerNight = (float) ($roomType['base_price'] ?? 0);
$roomTotalPrice = $pricePerNight * $nights;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt phòng - Booking Hotel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #f59e0b;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .nav a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        h1 {
            color: #1e293b;
            margin-bottom: 8px;
        }

        .room-info {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        input[type="date"] {
            padding: 12px;
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="date"]:focus {
            border-color: var(--primary);
            outline: none;
        }

        .error {
            color: #dc2626;
            background: #fef2f2;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            border: 1px solid #fee2e2;
        }

        .btn {
            padding: 14px 28px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }



        .addons-section h3 {
            margin: 0 0 16px 0;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .addon-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 10px;
            border: 2px solid #e5e7eb;
            transition: all 0.2s;
        }

        .addon-item:hover {
            border-color: var(--primary);
        }

        .addon-item.selected {
            border-color: var(--primary);
            background: #eff6ff;
        }

        .addon-checkbox {
            width: 22px;
            height: 22px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .addon-info {
            flex: 1;
        }

        .addon-name {
            font-weight: 600;
            color: #1e293b;
        }

        .addon-desc {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 2px;
        }

        .addon-price {
            font-weight: 700;
            color: var(--secondary);
            white-space: nowrap;
        }

        .addon-qty {
            width: 60px;
            padding: 8px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
        }

        .addon-qty:focus {
            border-color: var(--primary);
            outline: none;
        }


        .summary {
            margin: 24px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border-radius: 12px;
            border: 2px solid #86efac;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #374151;
        }

        .summary-row.total {
            border-top: 2px solid #86efac;
            margin-top: 12px;
            padding-top: 16px;
            font-size: 1.3rem;
            font-weight: 800;
            color: #059669;
        }

        .summary-row .label {
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nav" style="margin-bottom:16px">
            <a href="<?= $baseUrl ?>/rooms/search"><i class="fa-solid fa-arrow-left"></i> Quay lại tìm phòng</a>
        </div>
        <h1><i class="fa-solid fa-bed" style="color: var(--primary);"></i> Đặt phòng</h1>
        <div class="room-info">
            <strong style="font-size: 1.2rem;"><?= htmlspecialchars($room['room_number'] ?? '') ?></strong> -
            <?= htmlspecialchars($roomType['name'] ?? '') ?>
            <div style="margin-top: 6px; opacity: 0.9; font-size: 0.95rem;">
                <i class="fa-solid fa-money-bill-wave"></i> <?= number_format($pricePerNight) ?> VND / đêm
            </div>
        </div>

        <?php if ($error === 'missing'): ?>
            <p class="error"><i class="fa-solid fa-exclamation-circle"></i> Vui lòng nhập đầy đủ ngày check-in và check-out.
            </p><?php endif; ?>
        <?php if ($error === 'dates'): ?>
            <p class="error"><i class="fa-solid fa-exclamation-circle"></i> Ngày check-out phải sau check-in.</p>
        <?php endif; ?>
        <?php if ($error === 'unavailable'): ?>
            <p class="error"><i class="fa-solid fa-exclamation-circle"></i> Phòng không còn trống trong khoảng thời gian
                này. Vui lòng chọn ngày khác.</p><?php endif; ?>
        <?php if ($error === 'room_not_found'): ?>
            <p class="error"><i class="fa-solid fa-exclamation-circle"></i> Không tìm thấy phòng.</p><?php endif; ?>
        <?php if ($error === 'create_failed'): ?>
            <p class="error"><i class="fa-solid fa-exclamation-circle"></i> Không thể tạo đặt phòng. Vui lòng thử lại.</p>
        <?php endif; ?>

        <form method="post" action="<?= $baseUrl ?>/booking/store" id="booking-form">
            <input type="hidden" name="room_id" value="<?= (int) ($room['id'] ?? 0) ?>">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label><i class="fa-solid fa-calendar-check" style="color: var(--primary);"></i> Check-in</label>
                    <input type="date" name="check_in" id="check_in" value="<?= htmlspecialchars($checkIn) ?>" required>
                </div>
                <div>
                    <label><i class="fa-solid fa-calendar-xmark" style="color: #dc2626;"></i> Check-out</label>
                    <input type="date" name="check_out" id="check_out" value="<?= htmlspecialchars($checkOut) ?>"
                        required>
                </div>
            </div>


            <?php if (!empty($addons)): ?>
                <div class="addons-section">
                    <h3><i class="fa-solid fa-concierge-bell" style="color: var(--secondary);"></i> Dịch vụ thêm</h3>
                    <?php foreach ($addons as $addon): ?>
                        <div class="addon-item" id="addon-item-<?= $addon['id'] ?>">
                            <input type="checkbox" class="addon-checkbox" name="addons[<?= $addon['id'] ?>][selected]" value="1"
                                data-price="<?= (float) $addon['price'] ?>" data-id="<?= $addon['id'] ?>"
                                onchange="toggleAddon(<?= $addon['id'] ?>)">
                            <div class="addon-info">
                                <div class="addon-name"><?= htmlspecialchars($addon['name']) ?></div>
                                <?php if (!empty($addon['description'])): ?>
                                    <div class="addon-desc"><?= htmlspecialchars($addon['description']) ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="addon-price"><?= number_format($addon['price']) ?> VND</div>
                            <input type="number" class="addon-qty" name="addons[<?= $addon['id'] ?>][qty]" value="1" min="1"
                                max="10" data-id="<?= $addon['id'] ?>" onchange="updateTotal()" disabled>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="summary" id="summary">
                <div class="summary-row">
                    <span class="label"><i class="fa-solid fa-bed"></i> Tiền phòng</span>
                    <span><span id="nights"><?= $nights ?></span> đêm × <?= number_format($pricePerNight) ?> VND =
                        <strong id="room-total"><?= number_format($roomTotalPrice) ?></strong> VND</span>
                </div>
                <div class="summary-row" id="addon-summary" style="display: none;">
                    <span class="label"><i class="fa-solid fa-concierge-bell"></i> Dịch vụ thêm</span>
                    <span><strong id="addon-total">0</strong> VND</span>
                </div>
                <div class="summary-row total">
                    <span class="label"><i class="fa-solid fa-receipt"></i> Tổng cộng</span>
                    <span id="grand-total"><?= number_format($roomTotalPrice) ?> VND</span>
                </div>
            </div>

            <button type="submit" class="btn" style="width: 100%;">
                <i class="fa-solid fa-check-circle"></i> Xác nhận đặt phòng
            </button>
        </form>
        <p style="color:#64748b; font-size:14px; margin-top: 16px; text-align: center;">
            <i class="fa-solid fa-info-circle"></i> Bạn cần đăng nhập để đặt phòng. Sau khi tạo, đặt phòng ở trạng thái
            <strong>Chờ thanh toán</strong>.
        </p>
    </div>

    <script>
        const pricePerNight = <?= $pricePerNight ?>;

        function toggleAddon(id) {
            const checkbox = document.querySelector(`input[data-id="${id}"].addon-checkbox`);
            const qtyInput = document.querySelector(`input[data-id="${id}"].addon-qty`);
            const item = document.getElementById(`addon-item-${id}`);

            if (checkbox.checked) {
                qtyInput.disabled = false;
                item.classList.add('selected');
            } else {
                qtyInput.disabled = true;
                qtyInput.value = 1;
                item.classList.remove('selected');
            }
            updateTotal();
        }

        function updateTotal() {

            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            let nights = 1;
            if (checkIn && checkOut) {
                const diff = (new Date(checkOut) - new Date(checkIn)) / (1000 * 60 * 60 * 24);
                nights = Math.max(1, diff);
            }
            document.getElementById('nights').textContent = nights;


            const roomTotal = pricePerNight * nights;
            document.getElementById('room-total').textContent = formatNumber(roomTotal);


            let addonTotal = 0;
            document.querySelectorAll('.addon-checkbox:checked').forEach(checkbox => {
                const id = checkbox.dataset.id;
                const price = parseFloat(checkbox.dataset.price);
                const qty = parseInt(document.querySelector(`input[data-id="${id}"].addon-qty`).value) || 1;
                addonTotal += price * qty;
            });

            const addonSummary = document.getElementById('addon-summary');
            if (addonTotal > 0) {
                addonSummary.style.display = 'flex';
                document.getElementById('addon-total').textContent = formatNumber(addonTotal);
            } else {
                addonSummary.style.display = 'none';
            }


            const grandTotal = roomTotal + addonTotal;
            document.getElementById('grand-total').textContent = formatNumber(grandTotal) + ' VND';
        }

        function formatNumber(num) {
            return new Intl.NumberFormat('vi-VN').format(num);
        }


        document.getElementById('check_in').addEventListener('change', updateTotal);
        document.getElementById('check_out').addEventListener('change', updateTotal);
    </script>
</body>

</html>