<?php
require_once '../models/User.php';
require_once '../models/UserRole.php';
require_once '../repository/UserRepository.php';

class UserController {
    private $userRepository;
    private $message = '';

    public function __construct() {
        $this->userRepository = new UserRepository();
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

            // Validation
            if (empty($firstName) || empty($lastName) || empty($dob) || empty($email) || empty($password) || empty($confirmPassword)) {
                $this->message = "All fields are required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->message = "Invalid email format.";
            } elseif ($password !== $confirmPassword) {
                $this->message = "Passwords do not match.";
            } elseif ($this->userRepository->emailExists($email)) {
                // TODO modify that we register the user under that email what we found in the database (sg like repo->registerToExistingUser())
                $this->message = "Email is already in use.";
            } else {
                // Hash the password
                $iterations = ['cost' => 10];
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $iterations);
                
                // Create User object
                $userRole = new UserRole(); // Adjust as needed
                $user = new User(null, $firstName, $lastName, new DateTime($dob), $email, $hashedPassword, $userRole);

                // Ask to insert the new user into the database
                $newUser = $this->userRepository->createUser($user);
                if ($newUser) {
                    // Redirect to login page
                    header("Location: /dwp/login");
                    exit;
                } else {
                    $this->message = "Registration failed. Please try again.";
                }
            }
        }
        return $newUser;
    }

    public function getMessage(): string {
        return $this->message;
    }
}

// Check if action is set and create the UserController
if (isset($_GET['action']) && $_GET['action'] === 'register') {
    $userController = new UserController();
    $userController->register();
}