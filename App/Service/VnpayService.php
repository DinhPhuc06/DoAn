<?php

namespace App\Service;

class VnpayService
{
    public static function createPayment($amount, $orderId)
    {
        // 1. Đảm bảo TmnCode và HashSecret lấy từ Email mới nhất
        $vnp_TmnCode = "ZR2DIOV1"; 
        $vnp_HashSecret = "FL58OYC4XPHTHXPORCSC2HA0761M4SEW";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/doan/public/payment-return";

        $data = [
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => (int)$amount * 100, // Ép kiểu số nguyên
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $orderId,
            "vnp_OrderInfo" => "Thanh toan dat phong",
            "vnp_OrderType" => "billpayment",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR']
        ];

        ksort($data);
        
        // Fix IP localhost nếu là ::1
        if ($data['vnp_IpAddr'] == '::1') {
            $data['vnp_IpAddr'] = '127.0.0.1';
        }

        $i = 0;
        $hashdata = "";
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        // Tạo chữ ký (Dùng chuỗi đã encode đồng nhất)
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        
        // Tạo Query string cho URL
        $vnp_Url .= "?" . http_build_query($data) . "&vnp_SecureHash=" . $vnpSecureHash;

        return $vnp_Url;
    }
}