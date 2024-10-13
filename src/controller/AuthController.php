<?php
session_start();
require_once 'src/model/entity/User.php';
require_once 'src/model/entity/UserRole.php';
require_once 'src/model/repositories/AuthRepository.php';
require_once 'src/controller/UserRoleController.php';

class AuthController {
    private AuthRepository $authRepository;
    private UserRoleController $userRoleController;

    public function __construct() {
        $this->authRepository = new AuthRepository();
        $this->userRoleController = new UserRoleController();
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

            if (count($errors) == 0) {
                // Hash the password
                $iterations = ['cost' => 10];
                $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT, $iterations);
                
                // Check if user with this email exists already
                if ($this->authRepository->userExists($formData['email'])) {
                    $errors['email'] = "User with this email already exists.";
                    $_SESSION['errors'] = $errors;
                    $_SESSION['formData'] = $formData;
                    header("Location: /dwp/register");
                    exit;
                }

                // Get UserRole: customer
                try {
                    $userRole = $this->userRoleController->getUserRole('Customer');
                } catch (Exception $e) {
                    $errors[] = "Registration failed. Please try again.";
                }
                
                $user = new User(null, $formData['firstName'], $formData['lastName'], new DateTime($formData['dob']), $formData['email'], $hashedPassword, $userRole);

                // Try to insert the new user into the database
                try {
                    if ($this->authRepository->emailExists($formData['email'])) {
                        $newUser = $this->authRepository->createUserToExistingEmail($user);
                    }  else {
                        $newUser = $this->authRepository->createUser($user);
                    }
                    if ($newUser) {
                        // If registration was successful, redirect to login page
                        header("Location: /dwp/login");
                        exit;
                    } else {
                        $errors['general'] = "Registration failed. Please try again.";
                    }
                } catch (Exception $e) {
                    $errors['general'] = "Registration failed. Please try again.";
                }
            }
        }
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
            $errors['firstName'] = "Name must only contain letters and spaces.";
        }
        if (!preg_match($nameRegex, $formData['lastName'])) {
            $errors['lastName'] = "Name must only contain letters and spaces.";
        }
        if (strlen($formData['firstName']) < 2) {
            $errors['firstName'] = "Name must be at least 2 characters long.";
        }
        if (strlen($formData['lastName']) < 2) {
            $errors['lastName'] = "Name must be at least 2 characters long.";
        }
        if (!preg_match($dobRegex, $formData['dob'])) {
            $errors['dob'] = "Invalid date format. Please use the format YYYY-MM-DD.";
        }
        $dob = new DateTime($formData['dob']);
        $today = new DateTime();
        $age = $today->diff($dob)->y; // Get the difference in years

        // Check if the user is at least 6 years old
        if ($age < 6) {
            $errors['dob'] = "You must be at least 6 years old.";
        }
        if (!preg_match($emailRegex, $formData['email'])) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['dob']) || empty($formData['email']) || empty($formData['password']) || empty($formData['confirmPassword'])) {
            $errors['general'] = "All fields are required.";
        }
        if (strlen($formData['password']) < 8) {
            $errors['password'] = "Password must be at least 8 characters long.";
            $errors['confirmPassword'] = "Password must be at least 8 characters long.";
        }
        if (!preg_match($containsCapital, $formData['password'])) {
            $errors['password'] = "Password must contain at least one capital letter.";
            $errors['confirmPassword'] = "Password must contain at least one capital letter.";
        }
        if (!preg_match($containsNumber, $formData['password'])) {
            $errors['password'] = "Password must contain at least one number.";
            $errors['confirmPassword'] = "Password must contain at least one number.";
        }
        if ($formData['password'] !== $formData['confirmPassword']) {
            $errors['password'] = "Passwords do not match.";
            $errors['confirmPassword'] = "Passwords do not match.";
        }

        if (count($errors) > 0) {
            // If there are errors, redirect to registration page with errors
            $_SESSION['formData'] = $formData;
            $_SESSION['errors'] = $errors;
            header("Location: /dwp/register");
            exit;
        }
    }
}