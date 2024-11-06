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

    
}