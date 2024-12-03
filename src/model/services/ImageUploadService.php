<?php
use Cloudinary\Cloudinary;
use Cloudinary\Api\Upload\UploadApi;

function uploadToCloudinary($imagePath) {
    $cloudinary = new Cloudinary([
        'cloud' => [
            'cloud_name' => getenv('CLOUDINARY_CLOUD_NAME'),
            'api_key'    => getenv('CLOUDINARY_API_KEY'),
            'api_secret' => getenv('CLOUDINARY_API_SECRET')
        ]
    ]);

    try {
        // Upload the image to Cloudinary
        $uploadResponse = $cloudinary->uploadApi()->upload($imagePath);
        // The image is now uploaded to Cloudinary
        return $uploadResponse;
    } catch (Exception $e) {
        exit('Cloudinary upload failed: ' . $e->getMessage());
    }
}

?>