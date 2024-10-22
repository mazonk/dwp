<?php
require_once "src/model/services/AuthService.php";

class AuthController {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function register(): void {
        $errors = [];
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize input
            $formData['firstName'] = htmlspecialchars(trim($_POST['firstName']));
            $formData['lastName'] = htmlspecialchars(trim($_POST['lastName']));
            $formData['dob'] = htmlspecialchars(trim($_POST['dob']));
            $formData['email'] = htmlspecialchars(trim($_POST['email']));
            $formData['password'] = $_POST['password'];
            $formData['confirmPassword'] = $_POST['confirmPassword'];

            $errors = $this->authService->register($formData);

            if (count($errors) == 0) {
                // Registration successful, redirect to login
                header("Location: " . $_SESSION['baseRoute'] . "login");
                exit;
            } else {
                // Handle errors (session-based error handling, redirect back)
                $_SESSION['errors'] = $errors;
                $_SESSION['formData'] = $formData;
                header("Location: " . $_SESSION['baseRoute'] . "register");
                exit;
            }
        }
    }

    public function login(): void {
        $errors = [];
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize input
            $formData['email'] = htmlspecialchars(trim($_POST['email']));
            $formData['password'] = $_POST['password'];

            $result = $this->authService->login($formData);

            if (is_array($result) && isset($result['errors'])) {
                // If there are errors, handle them (e.g., set error messages)
                $_SESSION['errors'] = $result['errors'];
                $_SESSION['formData'] = $formData;
                header("Location: " . $_SESSION['baseRoute'] . "login");
                exit();
            }

            // Session handling and redirection logic
            $user = $result['user'];
            require_once "session_config.php";
            $newSessionId = session_create_id();
            $sessionId = $newSessionId . "_" . $user->getId(); // append session id with user id
            session_id($sessionId);
            session_start();

            // Set session variables
            $_SESSION['userId'] = $user->getId();
            $_SESSION['userEmail'] = htmlspecialchars($user->getEmail());
            $_SESSION['firstName'] = htmlspecialchars($user->getFirstName());
            $_SESSION['lastName'] = htmlspecialchars($user->getLastName());
            $_SESSION['lastGeneration'] = time();

            // Redirect to homepage after successful login
            header("Location: " . $_SESSION['baseRoute'] . "home");
            exit();
        }
    }

    public function logout(): void {
        $this->authService->logout();

        header("Location: " . $_SESSION['baseRoute'] . "login");
        exit;
    }
}