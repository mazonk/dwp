<?php

class CloudinaryRepository
{
    public function __construct() {
        $this->db = $db;
    }

    public function uploadImage($image) {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => 'your-cloud-name',
                'api_key'    => 'your-api-key',
                'api_secret' => 'your-api-secret',
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }
}