<?php

class DatabaseConnection {
    private static ?PDO $instance = null;

    private function __construct() {
        // private constructor to prevent external instantiation!!
    }

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                require("credentials.php"); // Load local credentials
            } else {
                // Load from environment variables for production
                $db_dbname = "mysql:dbname=" . getenv('DB_NAME');
                $db_host = "host=" . getenv('DB_HOST');
                $db_charset = "charset=utf8";

                define("DSN", "$db_dbname; $db_host; $db_charset");
                define("DB_USER", getenv('DB_USER'));
                define("DB_PASS", getenv('DB_PASS'));
            }

            try {
                self::$instance = new PDO(DSN, DB_USER, DB_PASS);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Failed to establish a database connection: " . $e->getMessage();
                exit;
            }
        }

        return self::$instance;
    }
}
