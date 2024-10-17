<?php
require_once 'session_config.php';
require_once 'src/model/entity/User.php';
require_once 'src/model/repositories/UserRepository.php';
require_once 'src/controller/UserRoleController.php';

class AuthService {
    private UserRepository $userRepository;
    private UserRoleRepository $userRoleRepository;

    public function __construct(){
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();
    }

    public function register(array $formData): array {
        $errors = [];

        // Validations
        $this->validateRegisterInputs($formData, $errors);

        if (count($errors) == 0) {
            // Hash password
            $iterations = ['cost' => 10];
            $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT, $iterations);
            
            // Check if user with this email exists already
            if ($this->userRepository->userExists($formData['email'])) {
                $errors['email'] = "User with this email already exists.";
                return $errors;
            }

            // Get UserRole: customer
            try {
                $userRole = $this->userRoleRepository->getUserRole('Customer');
            } catch (Exception $e) {
                $errors[] = "Registration failed. Please try again.";
                return $errors;
            }
            
            $userToBeInserted = new User(
                null,
                $formData['firstName'],
                $formData['lastName'], 
                new DateTime($formData['dob']), 
                $formData['email'], 
                $hashedPassword, 
                $userRole
            );

            // Try to insert the new user into the database
            try {
                if ($this->userRepository->emailExists($formData['email'])) {
                    $newUser = $this->userRepository->createUserToExistingEmail($userToBeInserted);
                }  else {
                    $newUser = $this->userRepository->createUser($userToBeInserted);
                }
                if (!$newUser) {
                    // If registration was noy successful
                    $errors['general'] = "Registration failed. Please try again.";
                    return $errors;
                }
            } catch (Exception $e) {
                $errors['general'] = "Registration failed. Please try again.";
            }
        } 
        return $errors;
    }

    public function login(array $formData): array {
        $errors = [];

        // Validate login inputs
        $this->validateLoginInputs($formData, $errors);

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        // Check if the user with this email exists
        if (!$this->userRepository->userExists($formData['email'])) {
            $errors['email'] = "User with this email does not exist.";
            return ['errors' => $errors];
        }

        // Fetch user from repository
        $user = $this->userRepository->getUserByEmail($formData['email']);

        // TODO: Handle admin login here if needed

        // Verify the password
        if (!password_verify($formData['password'], $user->getPasswordHash())) {
            $errors['password'] = "Incorrect password.";
            return ['errors' => $errors];
        }

        // Return the user object on successful login
        return ['user' => $user];
    }

    public function logout(): void {
        // Unset session and destroy it
        session_unset();
        session_destroy();
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
    }

    private function validateLoginInputs(array $formData, array &$errors): void {
        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if (!preg_match($emailRegex, $formData['email'])) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($formData['email']) || empty($formData['password'])) {
            $errors['general'] = "All fields are required.";
        }
    }
}