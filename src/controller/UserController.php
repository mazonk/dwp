<?php
require_once 'src/model/entity/User.php';
require_once 'src/model/entity/UserRole.php';
require_once 'src/model/repositories/UserRepository.php';
require_once 'src/model/repositories/UserRoleRepository.php';

// Check if action is set and create the UserController

//THIS HAS TO BE CHANGED LATER WHEN WE WANT TO ADD MORE ACTIONS
if (isset($_GET['action']) && $_GET['action'] === 'register') {
    $userController = new UserController();
    $userController->register();
}

class UserController {
    private UserRepository $userRepository;
    private UserRoleRepository $userRoleRepository;
    private $message;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();
        $this->message = '';
    }

    public function register(): User {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize input
            $firstName = htmlspecialchars(trim($_POST['firstName']));
            $lastName = htmlspecialchars(trim($_POST['lastName']));
            $dob = htmlspecialchars(trim($_POST['dob']));
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];

            // Validations
            $this->validateRegisterInputs($firstName, $lastName, $dob, $email, $password, $confirmPassword);

            if ($this->message) {
                // Handle message display on the registration page
                include 'src/view/pages/RegisterPage.php';
                die; // Stop further processing
            }

            // Hash the password
            $iterations = ['cost' => 10];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $iterations);
            
            // Get UserRole: customer
            try {
                $userRole = $this->userRoleRepository->getUserRole('Customer');
            } catch (Exception $e) {
                $this->message = "Registration failed. Please try again.";
            }
            
            $user = new User(null, $firstName, $lastName, new DateTime($dob), $email, $hashedPassword, $userRole);

            // Try to insert the new user into the database
            try {
                $newUser = $this->userRepository->createUser($user);
                
                if ($newUser) {
                    // If registration was successful, redirect to login page
                    header("Location: /dwp/login");
                    exit;
                } else {
                    $this->message = "Registration failed. Please try again.";
                }
            } catch (Exception $e) {
                $this->message = "Registration failed. Please try again.";
            }
        } else { // Fallback to invalid request
            $this->message = "Invalid request.";
        }
        return $newUser;
    }

    // Register to an existing user

    // Register anonymus user

    // Login

    // Logout

    // Change password

    // Forgot password

    // Reset password
    
    private function validateRegisterInputs($firstName, $lastName, $dob, $email, $password, $confirmPassword): bool {
        $isValid = false;

        // Define regexes for validation
        $nameRegex = "/^[a-zA-ZáéíóöúüűæøåÆØÅ\s\-']+$/";
        $dobRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        // Perform checks
        if (!preg_match($nameRegex, $firstName) || !preg_match($nameRegex, $lastName)) {
            $this->message = "Name must only contain letters and spaces.";
        } elseif (!preg_match($dobRegex, $dob)) {
            $this->message = "Invalid date format. Please use the format YYYY-MM-DD.";
        } elseif (!preg_match($emailRegex, $email)) {
            $this->message = "Invalid email format.";
        } elseif (empty($firstName) || empty($lastName) || empty($dob) || empty($email) || empty($password) || empty($confirmPassword)) {
            $this->message = "All fields are required.";
        } elseif ($password !== $confirmPassword) {
            $this->message = "Passwords do not match.";
        } elseif ($this->userRepository->emailExists($email)) {
            $this->message = "Email is already in use.";
        } else {
            $isValid = true;
        }

        return $isValid;
    }
    
    public function getMessage(): string {
        return $this->message;
    }
}