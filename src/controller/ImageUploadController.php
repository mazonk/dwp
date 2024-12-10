<?php

class ImageUploadController {
    public function uploadImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ensure a directory for uploads exists
            $uploadPath = $_POST['upload_path'] ?? 'uploads';
            $uploadDir = __DIR__ . '/../assets/' . $uploadPath;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Check if a file was uploaded
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                $fileName = time() . '-' . basename($file['name']);
                $targetFile = $uploadDir . '/' . $fileName;

                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'errorMessage' => 'Invalid file type. Only JPG, PNG, and GIF are allowed.']);
                    return;
                }

                // Save the file
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    echo json_encode(['success' => true, 'filePath' => "src/assets/$uploadPath/$fileName"]);
                } else {
                    echo json_encode(['success' => false, 'errorMessage' => 'Error uploading the file.']);
                }
            } else {
                echo json_encode(['success' => false, 'errorMessage' => 'No file uploaded or an error occurred.']);
            }
        } else {
            echo json_encode(['success' => false, 'errorMessage' => 'Invalid request method.']);
        }
    }
}
