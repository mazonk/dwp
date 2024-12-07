<?php

require 'src/model/repositoriesImageUploadRepository.php'; // Assuming you have a repository class for database operations
require 'vendor/autoload.php'; // For Cloudinary's UploadApi

use Cloudinary\Api\Upload\UploadApi;

class ImageService
{
    private ImageUploadRepository $repository;
    private $uploadDir;

    public function __construct($pdo, $uploadDir = __DIR__ . '/src/assets/')
    {
        $this->repository = new ImageUploadRepository($pdo);
        $this->uploadDir = $uploadDir;

        // Ensure the upload directory exists (if local fallback is needed)
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    public function uploadImage($image)
    {
        // Validate the uploaded file
        $this->validateFile($image);

        // Use Cloudinary for the upload
        $filePath = $image['tmp_name'];
        $uploadApi = new UploadApi();

        try {
            // Upload the file to Cloudinary
            $uploadResult = $uploadApi->upload($filePath, ['folder' => 'my_uploads/']);
            $imageUrl = $uploadResult['secure_url'];

            // Save the image metadata to the database
            $this->repository->saveImage($imageUrl, $image['name']);

            return ['url' => $imageUrl];
        } catch (\Exception $e) {
            throw new \Exception("Failed to upload to Cloudinary: " . $e->getMessage());
        }
    }

    private function validateFile($image)
    {
        // Check for upload errors
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("File upload error: " . $image['error']);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($image['type'], $allowedTypes)) {
            throw new \Exception("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
        }

        // Validate file size (5MB limit)
        if ($image['size'] > 5 * 1024 * 1024) {
            throw new \Exception("File size exceeds the maximum allowed limit of 5MB.");
        }
    }
}
