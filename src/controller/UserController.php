<?php
require_once 'src/model/entity/User.php';
require_once 'src/model/entity/UserRole.php';
require_once 'src/model/repositories/UserRepository.php';
require_once 'src/model/repositories/UserRoleRepository.php';

if (isset($_GET['action']) && $_GET['action'] === 'register') {
    $userController = new UserController();
    $userController->register();
}

class UserController {
    private UserRepository $userRepository;
    private UserRoleRepository $userRoleRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();
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

            // Validations
            $this->validateRegisterInputs($formData, $errors);

            if (empty($errors)) {
                // Hash the password
                $iterations = ['cost' => 10];
                $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT, $iterations);
                
                // Get UserRole: customer
                try {
                    $userRole = $this->userRoleRepository->getUserRole('Customer');
                } catch (Exception $e) {
                    $errors[] = "Registration failed. Please try again.";
                }
                
                $user = new User(null, $formData['firstName'], $formData['lastName'], new DateTime($formData['dob']), $formData['email'], $hashedPassword, $userRole);

                // Try to insert the new user into the database
                try {
                    $newUser = $this->userRepository->createUser($user);
                    
                    if ($newUser) {
                        // If registration was successful, redirect to login page
                        header("Location: /dwp/login");
                        exit;
                    } else {
                        $errors[] = "Registration failed. Please try again.";
                    }
                } catch (Exception $e) {
                    $errors[] = "Registration failed. Please try again.";
                }
            }
        }

        // Include the registration page with errors
        include 'src/view/pages/RegisterPage.php';
    }

    private function validateRegisterInputs(array $formData, array &$errors): void {
        // Define regexes for validation
        $nameRegex = "/^[a-zA-ZáéíóöúüűæøåÆØÅ\s\-']+$/";
        $dobRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $containsCapital = "/[A-Z]/";
        $containsNumber = "/[0-9]/";

        // Perform checks
        if (!preg_match($nameRegex, $formData['firstName'])) {
            $errors['name'] = "Name must only contain letters and spaces.";
        }
        if (!preg_match($nameRegex, $formData['lastName'])) {
            $errors['name'] = "Name must only contain letters and spaces.";
        if ($formData['firstName'] < 2) {
            $errors['name'] = "Name must be at least 2 characters long.";
        }
        if ($formData['lastName'] < 2) {
            $errors['name'] = "Name must be at least 2 characters long.";
        }
        if (!preg_match($dobRegex, $formData['dob'])) {
            $errors['dob'] = "Invalid date format. Please use the format YYYY-MM-DD.";
        }
        if (!preg_match($emailRegex, $formData['email'])) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['dob']) || empty($formData['email']) || empty($formData['password']) || empty($formData['confirmPassword'])) {
            $errors['general'] = "All fields are required.";
        }
        if ($formData['password'] !== $formData['confirmPassword']) {
            $errors['password'] = "Passwords do not match.";
        }
        if (strlen($formData['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters long.";
        }
        if (!preg_match($containsCapital, $formData['password'])) {
            $errors['password'] = "Password must contain at least one capital letter.";
        }
        if (!preg_match($containsNumber, $formData['password'])) {
            $errors['password'] = "Password must contain at least one number.";
        }
        if ($this->userRepository->emailExists($formData['email'])) {
            $errors['email'] = "Email is already in use."; //TODO: Rework this in a way that if email already exists register user to that entry
        }
    }
}
}