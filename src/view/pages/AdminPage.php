<?php
require_once 'session_config.php';

if (!isLoggedIn()) {
    header("Location: /dwp/login");
    exit;
}