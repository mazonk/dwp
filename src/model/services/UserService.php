<?php 
include_once "src/model/repositories/UserRepository.php";
include_once "src/model/services/UserRoleService.php";

class UserService {
    private UserRepository $userRepository;
    private UserRoleService $userRoleService;

    public function __construct() {
        $this->userRepository = new UserRepository();
        $this->userRoleService = new UserRoleService();
    }

    public function getUserByEmail(string $email): array|User {
        try {
            $user = $this->userRepository->getUserByEmail($email);
            $userRole = $this->userRoleService->getUserRoleById($user['roleId']);
            return new User($user['userId'], $user['firstName'], $user['lastName'], 
                            $user['DoB'], $user['email'], $user['passwordHash'], $userRole);
        } catch (Exception $e) {
            return ["error"=> true, "message"=> $e->getMessage()];
        }
    }
}