<?php 
require_once 'src/model/services/UserService.php';

class UserController {
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function getUserById($id) {
        $user = $this->userService->getUserById($id);
        if (is_array($user) && isset($user['error']) && $user['error']) {
            return ['errorMessage' => $user['message']];
        }
        return $user;
    }

    public function getUserByEmail($email) {
        $user = $this->userService->getUserByEmail($email);
        if (is_array($user) && isset($user['error']) && $user['error']) {
            return ['errorMessage' => $user['message']];
        }
        return $user;
    }

    public function createGuestUser(array $formData): int|array {
        $result = $this->userService->createGuestUser($formData);

        // Error while creating the guest user
        if (is_array($result) && isset($result['error']) && $result['error']) {
            $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $result['message']];
            $_SESSION['guestFormData'] = $formData;
            return ['errorMessage' => true];
        } 
        // Validation error
        else if (is_array($result)) {
            $_SESSION['guestErrors'] = $result;
            $_SESSION['guestFormData'] = $formData;
            return ['validationError' => true];
        }
        return $result; // Return the user ID
    }

    public function doesAccountExistByEmail(string $email): bool|array {
        $user = $this->userService->doesAccountExistByEmail($email);
        if (is_array($user) && isset($user['error']) && $user['error']) {
            return ['errorMessage' => $user['message']];
        }
        return $user;
    }

    public function doesGuestExistByEmail(string $email, string $role): int|array {
        $guest = $this->userService->doesGuestExistByEmail($email, $role);
        if (is_array($guest) && isset($guest['error']) && $guest['error']) {
            return ['errorMessage' => $guest['message']];
        }
        return $guest;
    }

    public function updateGuestInfo(array $formData, int $userId): int|array {
        $result = $this->userService->updateGuestInfo($formData, $userId);

        // Error while creating the guest user
        if (is_array($result) && isset($result['error']) && $result['error']) {
            $_SESSION['guestErrors'] = ['general' => 'An error occurred. ' . $result['message']];
            $_SESSION['guestFormData'] = $formData;
            return ['errorMessage' => true];
        }
        // Validation error
        else if (is_array($result)) {
            $_SESSION['guestErrors'] = $result;
            $_SESSION['guestFormData'] = $formData;
            return ['validationError' => true];
        }
        return $result;
    }

    public function updateProfileInfo($userId, $newProfileInfo): array|User {
        $user = $this->userService->updateProfileInfo($userId, $newProfileInfo);
        if (is_array($user) && isset($user['error']) && $user['error']) {
            return ['errorMessage'=> $user['message']];
        }
        return $user;
    }
}