<?php
// Load the configuration file
$config = parse_ini_file('ftp.config');

// Check if the config was loaded successfully
if ($config === false) {
    die('Error loading configuration file.');
}

// Accessing the values
$host = $config['host'] ?? null;
$username = $config['username'] ?? null;
$password = $config['password'] ?? null;
$port = $config['port'] ?? null;
$secure = $config['secure'] ?? null;

// Example usage
echo "Host: $host\n";
echo "Username: $username\n";
echo "Port: $port\n";
echo "Secure: " . ($secure ? 'Yes' : 'No') . "\n";

// Note: Be careful with echoing sensitive data like passwords in production.
?>
