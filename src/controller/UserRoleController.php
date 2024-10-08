<?php
require_once 'src/model/repositories/UserRoleRepository.php';

class UserRoleController {
    private $userRoleRepository;
    private $message;

    public function __construct() {
        $this->userRoleRepository = new UserRoleRepository();
        $this->message = '';
    }

    public function getUserRoles(): array {
        try {
            return $this->userRoleRepository->getAll();
        } catch (Exception $e) {
            $this->message = $e->getMessage();
            return [];
        }
    }

    public function getMessage(): string {
        return $this->message;
    }
}
?>
