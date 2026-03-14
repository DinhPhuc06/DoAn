<?php

namespace App\Service;

class CloudinaryService
{
    private string $cloudName;
    private string $apiKey;
    private string $apiSecret;

    public function __construct()
    {
        $config = require BASE_PATH . '/Config/cloudinary.php';
        $this->cloudName = $config['cloud_name'];
        $this->apiKey = $config['api_key'];
        $this->apiSecret = $config['api_secret'];
    }

    /**
     * Upload an image to Cloudinary
     * 
     * @param string $filePath Full path to the local file
     * @param string $folder Folder in Cloudinary
     * @return string|null URL of the uploaded image or null on failure
     */
    public function upload(string $filePath, string $folder = 'room_types'): ?string
    {
        if (!file_exists($filePath)) {
            return null;
        }

        $timestamp = time();
        $signatureData = "folder=$folder&timestamp=$timestamp" . $this->apiSecret;
        $signature = sha1($signatureData);

        $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";

        $data = [
            'file' => new \CURLFile($filePath),
            'timestamp' => $timestamp,
            'api_key' => $this->apiKey,
            'signature' => $signature,
            'folder' => $folder,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        if ($error) {
            return null;
        }

        $result = json_decode($response, true);
        return $result['secure_url'] ?? null;
    }
}
