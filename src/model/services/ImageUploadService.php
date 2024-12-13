<?php
include_once "src/model/repositories/ImageUploadRepository.php";

class ImageUploadService {
        public function uploadImage($file): array {
        try {
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
            return ['errorMessage' => $e->getMessage()];
        }
    }
}
