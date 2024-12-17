<?php
require_once 'src/model/services/ImageUploadService.php';

class ImageUploadController {
    private ImageUploadService $imageUploadService;

    public function __construct() {
        $this->imageUploadService = new ImageUploadService();
    }
    public function uploadImage($file) {
       return $this->imageUploadService->uploadImage($file);
    }
}
