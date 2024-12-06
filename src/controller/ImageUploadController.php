<?php

class ImageController {
    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $imageService = new ImageService();

            try {
                $result = $imageService->uploadImage($_FILES['image']);
                // Respond with JSON containing the uploaded image URL
                echo json_encode(['url' => $result['url']]);
            } catch (\Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'No file uploaded.']);
        }
    }
}
