<?php
require_once 'src/model/entity/Image.php';
use Cloudinary\Api\Upload\UploadApi;

class ImageController {
    private $imageModel;

    public function __construct($pdo) {
        $this->imageModel = new Image($pdo);
    }

    public function upload($file) {
        $targetDir = $_ENV['UPLOAD_FOLDER'];
        $targetFile = $targetDir . basename($file['name']);

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => 'Invalid file type.'];
        }

        // Move file to uploads folder
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            return ['error' => 'Failed to move uploaded file.'];
        }

        // Upload to Cloudinary
        try {
            $upload = new UploadApi();
            $response = $upload->upload($targetFile);

            // Save to database
            $this->imageModel->save($response['secure_url'], $file['name']);
            return ['success' => true, 'url' => $response['secure_url']];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        } finally {
            unlink($targetFile); // Clean up
        }
    }
}
