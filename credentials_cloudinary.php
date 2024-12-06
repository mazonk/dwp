<?php
require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dg8cledsa',
        'api_key'    => '642418928429522',
        'api_secret' => 'udiCrFMfX9amfqowT2i1PUK2u3c',
    ],
    'url' => [
        'secure' => true, // Ensure HTTPS
    ],
]);
