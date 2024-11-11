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
}