<?php require_once 'session_config.php';
require_once 'src/model/entity/User.php';
include_once 'src/model/repositories/AuthRepository.php';
require_once 'src/model/services/UserService.php';
require_once 'src/model/services/UserRoleService.php';

class AuthService {
    private AuthRepository $authRepository;
    private UserService $userService;
    private UserRoleService $userRoleService;

    public function __construct(){
        $this->userRoleService = new UserRoleService();
        $this->userService = new UserService();
        $this->authRepository = new AuthRepository();
    }

    public function register(array $formData): array {
        $errors = [];
    
        // Validate inputs
        $this->validateRegisterInputs($formData, $errors);
    
        if (count($errors) == 0) {
            try {
                // Hash the password
                $hashedPassword = password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 10]);
    
                // Check if a user with this email already exists
                if ($this->authRepository->userExists($formData['email'])) {
                    $errors['email'] = "User with this email already exists.";
                    return $errors;
                }
    
                // Fetch the 'User' user role
                $userRole = $this->userRoleService->getUserRoleByType('User');
                if (is_array($userRole) && isset($userRole['error']) && $userRole['error']) {
                    $errors['general'] = "Registration failed. Couldn't register you as a user.";
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
    
                // Insert the new user into the database
                if ($this->authRepository->emailExists($formData['email'])) {
                    $newUserId = $this->authRepository->createUserToExistingEmail($userToBeInserted); //update the existing user
                } else {
                    $newUserId = $this->authRepository->createUser($userToBeInserted); //new user
                }
    
                if (!$newUserId) {
                    throw new Exception("Failed to register the user.");
                }
    
            } catch (Exception $e) {
                // Log the actual exception for internal tracking
                error_log($e->getMessage());
    
                // Provide a generic error message to the user
                $errors['general'] = "Registration failed. Please try again.";
            }
        }
    
        return $errors;
    }
    

    public function login(array $formData): array {
        $errors = [];
    
        // Validate inputs
        $this->validateLoginInputs($formData, $errors);
    
        if (!empty($errors)) {
            return ['errors' => $errors];
        }
    
        try {
            // Check if the user exists
            if (!$this->authRepository->userExists($formData['email'])) {
                $errors['email'] = "User with this email does not exist.";
                return ['errors' => $errors];
            }
    
            // Fetch user by email
            $user = $this->userService->getUserByEmail($formData['email']);
            if (is_array($user) && isset($user['error']) && $user['error']) {
                $errors['email'] = "Couldn't find user!";
                return ['errors' => $errors];
            }
    
            // Verify password
            if (!password_verify($formData['password'], $user->getPasswordHash())) {
                $errors['password'] = "Incorrect password.";
                return ['errors' => $errors];
            }
    
            return ['user' => $user];
    
        } catch (Exception $e) {
            error_log($e->getMessage());
            $errors['general'] = "Login failed. Please try again.";
        }
    
        return ['errors' => $errors];
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
        if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['dob']) || empty($formData['email']) || empty($formData['password']) || empty($formData['confirmPassword'])) {
            $errors['general'] = "All fields are required.";
        }
        if (!preg_match($nameRegex, $formData['firstName'])) {
            $errors['firstName'] = "Name must only contain letters and spaces.";
        }
        if (!preg_match($nameRegex, $formData['lastName'])) {
            $errors['lastName'] = "Name must only contain letters and spaces.";
        }
        if (strlen($formData['firstName']) < 2 || strlen($formData['firstName']) > 50) {
            $errors['firstName'] = "First name must be between 2 and 50 characters long.";
        }
        if (strlen($formData['lastName']) < 2 || strlen($formData['lastName']) > 50) {
            $errors['lastName'] = "Last name must be between 2 and 50 characters long.";
        }
        if (strlen($formData['email']) > 100) {
            $errors['email'] = "Email must be less than 100 characters long.";
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