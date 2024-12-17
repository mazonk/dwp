<?php
function loadEnv() {
  // Check if the file exists
  if(!file_exists(__DIR__ . '/.env')) {
    throw new Exception(".env file not found");
  }

  // Read the file into an array
  $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

  // Loop through each line
  foreach($lines as $line) {
    if(strpos(trim($line), '#') === 0) {
      continue; // Skip comments
    }

    list($key, $value) = explode('=', $line, 2); // Split the lines into key/value pairs
    putenv(trim($key) . '=' . trim($value)); // Set the environment variable
  }
}