<?php
require_once 'src/model/services/UserRoleService.php';

class UserRoleController {
    private $userRoleService;

    public function __construct() {
        $this->userRoleService = new UserRoleService();
    }

    public function getUserRoles(): array {
        $userRoles = $this->userRoleService->getAllUserRoles();
        if (isset($userRoles['error']) && $userRoles['error']) {
            return ['errorMessage' => $userRoles['message']];
        }
        return $userRoles;
    }

    public function getUserRoleByType(string $roleType): array|UserRole {
        $userRole = $this->userRoleService->getUserRoleByType($roleType);
        if (is_array($userRole) && isset($userRole['error']) && $userRole['error']) {
            return ['errorMessage' => $userRole['message']];
        }
        return $userRole;
    }

}
?>
