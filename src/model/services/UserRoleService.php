<?php 
require_once "src/model/repositories/UserRoleRepository.php";
require_once "src/model/entity/UserRole.php";

class UserRoleService {
    private UserRoleRepository $userRoleRepository;

    public function __construct() {
        $this->userRoleRepository = new UserRoleRepository();
    }

    public function getAllUserRoles(): array {
        try {
            $result = $this->userRoleRepository->getAllUserRoles();
            $userRoles = [];
            foreach ($result as $row) {
                $userRoles[] = new UserRole($row['roleId'], $row['type']);
            }
            return $userRoles;
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    public function getUserRoleByType(string $roleType): array|UserRole {
        try {
            $result = $this->userRoleRepository->getUserRoleByType($roleType);
            return new UserRole($result['roleId'], $result['type']);
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}