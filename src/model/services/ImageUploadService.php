<?php
include_once "src/model/repositories/ImageUploadRepository.php";

class ImageUploadService {
    private ImageUploadRepository $imageRepository;

    public function __construct() {
        $this->imageRepository = new ImageUploadRepository();
    }

    public function uploadImage(array $file, string $uploadPath): array {
        try {
            // Validate upload path
            if (empty($uploadPath)) {
                throw new Exception("Upload path is not defined.");
            }

            $baseDir = __DIR__ . "/../../assets/";
            $uploadDir = $baseDir . $uploadPath;

            // Ensure directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Validate the file
            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new Exception("File upload error.");
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception("Invalid file type. Allowed: JPG, PNG, GIF.");
            }

            // Save the file
            $fileName = time() . '-' . basename($file['name']);
            $targetPath = $uploadDir . '/' . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Save metadata to database
                $this->imageRepository->saveImageMetadata($fileName, "src/assets/$uploadPath/$fileName", $uploadPath);

                return ['success' => true, 'filePath' => "src/assets/$uploadPath/$fileName"];
            } else {
                throw new Exception("Failed to save the uploaded file.");
            }
        } catch (Exception $e) {
            return ['success' => false, 'errorMessage' => $e->getMessage()];
        }
    }
}
