<?php
include_once "src/model/repositories/ImageUploadRepository.php";

class ImageUploadService {
    private ImageUploadRepository $imageRepository;

    public function __construct() {
        $this->imageRepository = new ImageUploadRepository();
    }

    public function uploadImage($file): array {
        try {
            error_log("File Type: " . $file['type']);
            error_log("File Size: " . $file['size']);

            // Validate file type and size
            if (in_array($file['type'], ["image/jpeg", "image/pjpeg", "image/png", "image/jpg"]) && 
                $file['size'] < 3000000) {
                
                $filename = basename($file['name']);
                $destination = "src/assets/" . $filename;

                // Check if the file already exists
                if (file_exists($destination)) {
                    return ['errorMessage' => "File already exists"];
                }

                // Move uploaded file to the destination
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    return ['successMessage' => "File uploaded successfully"];
                } else {
                    return ['errorMessage' => "Failed to upload the file"];
                }
            } else {
                return ['errorMessage' => "Invalid file type or size"];
            }
        } catch (Exception $e) {
            error_log("Upload Error: " . $e->getMessage());
            return ['errorMessage' => $e->getMessage()];
        }
    }
}
