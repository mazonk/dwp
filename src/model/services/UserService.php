<?php 
include_once "src/model/repositories/UserRepository.php";
include_once "src/model/services/UserRoleService.php";
include_once "src/model/entity/User.php";

class UserService {
    private UserRepository $userRepository;
    private UserRoleService $userRoleService;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->userRoleService = new UserRoleService();
    }

    public function getUserByEmail(string $email): array|User {
        try {
            $user = $this->userRepository->getUserByEmail($email); //join table with userrole, so we get user's role type
            $userRole = $this->userRoleService->getUserRoleByType($user['type']);
            if (is_array($userRole) && isset($userRole['error']) && $userRole['error']) {
                return ["error"=> true, "message"=> $userRole['message']];
            }
            return new User($user['userId'], $user['firstName'], $user['lastName'], 
                            new Datetime($user['DoB']), $user['email'], $user['passwordHash'], $userRole);
        } catch (Exception $e) {
            return ["error"=> true, "message"=> $e->getMessage()];
        }
    }

    public function getUserById(int $id): array|User {
        try {
            $user = $this->userRepository->getUserById($id); //join table with userrole, so we get user's role type
            $userRole = $this->userRoleService->getUserRoleByType($user['type']);
            if (is_array($userRole) && isset($userRole['error']) && $userRole['error']) {
                return ["error"=> true, "message"=> $userRole['message']];
            }
            return new User($user['userId'], $user['firstName'], $user['lastName'], 
                            new Datetime($user['DoB']), $user['email'], $user['passwordHash'], $userRole);
        } catch (Exception $e) {
            return ["error"=> true, "message"=> $e->getMessage()];
        }
    }

    public function updateProfileInfo(int $userId, array $newProfileInfo): array {
        try {
            $errors = [];
            $this->validateProfileInfoInputs($newProfileInfo, $errors);
            if (count($errors) > 0) {
                return ["error"=> true, "message"=> $errors];
            }
            $this->userRepository->updateProfileInfo($userId, $newProfileInfo);
            return $this->getUserById($userId);
        } catch (Exception $e) {
            return ["error"=> true, "message"=> $e->getMessage()];
        }
    }

    private function validateProfileInfoInputs(array $formData, array &$errors): void {
        // Define regexes for validation
        $nameRegex = "/^[a-zA-ZáéíóöúüűæøåÆØÅ\s\-']+$/";
        $dobRegex = "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

        // Perform checks
        if (empty($formData['firstName']) || empty($formData['lastName']) || empty($formData['dob']) || empty($formData['email'])) {
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
        if (!preg_match($emailRegex, $formData['email']) || strlen($formData['email']) > 100) {
            $errors['email'] = "Invalid email format or email is too long.";
        }
    }
}