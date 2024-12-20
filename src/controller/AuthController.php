<?php require_once "session_config.php";
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

            // Validate form data (e.g., check for empty fields before proceeding)
            if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['email']) || empty($formData['password'])) {
                $errors['general'] = "All fields are required.";
            } else {
                $errors = $this->authService->register($formData);
            }

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

            // Set session variables
            $_SESSION['loggedInUser']['userId'] = $user->getId();
            $_SESSION['loggedInUser']['userEmail'] = htmlspecialchars($user->getEmail());
            $_SESSION['loggedInUser']['firstName'] = htmlspecialchars($user->getFirstName());
            $_SESSION['loggedInUser']['lastName'] = htmlspecialchars($user->getLastName());
            $_SESSION['loggedInUser']['roleType'] = htmlspecialchars($user->getUserRole()->getType());
            $_SESSION['lastGeneration'] = time();

            // Check if a redirect URL was provided
            $redirectUrl = $_GET['redirect'] ?? $_SESSION['baseRoute'] . "home";

            header("Location: " . $redirectUrl);
            exit();
        }
    }

    public function logout(): void {
        header("Location: " . $_SESSION['baseRoute'] . "login");
        $this->authService->logout();
        exit;
    }
}