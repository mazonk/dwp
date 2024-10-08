<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Local development - load from credentials.php
    require("credentials.php");
} else {
    // Production environment - credentials from environment variables
    $db_dbname = "mysql:dbname=" . getenv('DB_NAME');
    $db_host = "host=" . getenv('DB_HOST');
    $db_charset = "charset=utf8";

    define("DSN", "$db_dbname; $db_host; $db_charset");
    define("DB_USER", getenv('DB_USER'));
    define("DB_PASS", getenv('DB_PASS'));
}

try {
    $db = new PDO(DSN, DB_USER, DB_PASS);
} catch (PDOException $e) {
    echo "Failed to establish a database connection: " . $e->getMessage();
}
