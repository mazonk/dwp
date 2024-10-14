<?php
    session_start();

    if (isset($_SESSION['userId'])) { //the user is logged in
        if (!isset($_SESSION['lastRegeneration'])) {
            regenerate_session_id_loggedin();
        } else {
            $interval = 60 * 30; // 30 minutes
            if (time() - $_SESSION['lastRegeneration'] >= $interval) {
                regenerate_session_id_loggedin();
            }
        } 
    } else { //the user is not logged in
        if (!isset($_SESSION['lastRegeneration'])) {
            regenerate_session_id();
        } else {
            $interval = 60 * 30; // 30 minutes
            if (time() - $_SESSION['lastRegeneration'] >= $interval) {
                regenerate_session_id();
            }
        }
    }


    //functions
    function isLoggedIn() {
        return isset($_SESSION['userId']);
    }

    function confirm_logged_in() {
        if (!isLoggedIn()) {
            header("Location: /dwp/login");
            exit;
        }
    }

    function regenerate_session_id() {
        session_regenerate_id(true);
        $_SESSION['lastRegeneration'] = time();
    }

    function regenerate_session_id_loggedin() {
        session_regenerate_id(true);

        $userId = $_SESSION['userId'];
        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $userId;
        session_id($sessionId);

        $_SESSION['lastRegeneration'] = time();
    }




