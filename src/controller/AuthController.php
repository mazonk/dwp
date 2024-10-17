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
                header("Location: /dwp/login");
                exit;
            } else {
                // Handle errors (session-based error handling, redirect back)
                $_SESSION['errors'] = $errors;
                $_SESSION['formData'] = $formData;
                header("Location: /dwp/register");
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

            // Validations
            $this->validateLoginInputs($formData, $errors);

            if (count($errors) == 0) {
                // Check if user with this email exists
                if (!$this->userRepository->userExists($formData['email'])) {
                    $errors['email'] = "User with this email does not exist.";
                    $_SESSION['errors'] = $errors;
                    $_SESSION['formData'] = $formData;
                    header("Location: /dwp/login");
                    exit;
                }

                // Check if password is correct
                $user = $this->userRepository->getUserByEmail($formData['email']);

                // TODO: Handle admin login somewhere here!!
                
                if (!password_verify($formData['password'], $user->getPasswordHash())) {
                    $errors['password'] = "Incorrect password.";
                    $_SESSION['errors'] = $errors;
                    $_SESSION['formData'] = $formData;
                    header("Location: /dwp/login");
                    exit;
                }

                require_once "session_config.php";
                $newSessionId = session_create_id();
                $sessionId = $newSessionId . "_" . $user->getId(); //append session id with user id
                session_id($sessionId);

                // If login was successful, redirect to homepage
                $_SESSION['userId'] = $user->getId();
                $_SESSION['userEmail'] = htmlspecialchars($user->getEmail());
                $_SESSION['firstName'] = htmlspecialchars($user->getFirstName());
                $_SESSION['lastName'] = htmlspecialchars($user->getLastName());
                $_SESSION['lastGeneration'] = time();

                header("Location: /dwp/home");
                exit;
            }
        }
    }

    public function logout(): void {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /dwp/login");
        exit;
    }

    private function validateLoginInputs(array $formData, array &$errors): void {
        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if (!preg_match($emailRegex, $formData['email'])) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($formData['email']) || empty($formData['password'])) {
            $errors['general'] = "All fields are required.";
        }
        if (count($errors) > 0) {
            // If there are errors, redirect to login page with errors
            $_SESSION['formData'] = $formData;
            $_SESSION['errors'] = $errors;
            header("Location: /dwp/login");
            exit;
        }
    }
}