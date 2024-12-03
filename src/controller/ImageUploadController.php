<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];

    // Validate the image
    if ($image['size'] > 5000000) {
        // Error: file too large
        exit("File size is too large.");
    }

    // Save the image temporarily (for now, you may store it locally)
    $tempImagePath = 'uploads/' . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $tempImagePath)) {
        // The image is now uploaded temporarily on the server.
        $cloudinaryResponse = uploadToCloudinary($tempImagePath);
    } else {
        exit("Image upload failed.");
    }
}



?>