<?php
require_once 'session_config.php';

if (!isLoggedIn()) {
    header("Location: " . $_SESSION['baseRoute'] . "login");
    exit;
}