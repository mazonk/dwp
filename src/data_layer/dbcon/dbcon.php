<?php
require("credentials.php");
try {
    $db = new PDO(DSN,DB_USER,DB_PASS);
} catch (PDOException $e) {
    echo "Failed to establish a database connection: ". $e->getMessage() ."";
}