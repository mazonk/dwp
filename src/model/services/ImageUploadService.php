<?php
class ImageService
{
    public function uploadImage($image)
    {
        // Validate the file
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("File upload error: " . $image['error']);
        }

        $filePath = $image['tmp_name'];
    $uploadResult = (new UploadApi())->upload($filePath, ['folder' => 'my_uploads/']);

    // Save to database
    $repository = new ImageRepository(new PDO('mysql:host=localhost;dbname=your_db', 'user', 'password'));
    $repository->saveImage($uploadResult['secure_url'], $image['name']);

    return ['url' => $uploadResult['secure_url']];
}
}
?>