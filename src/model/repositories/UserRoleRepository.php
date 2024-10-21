<?php
include_once "src/model/entity/UserRole.php";
class UserRoleRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAll(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            }
            return $result;
        } catch (PDOException $e) {
            echo 'unable to fetch user roles: '. $e;
            throw new Exception("User roles not found");
        }
    }

    public function getUserRole(string $roleType) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole ur WHERE ur.type = :type");
        try {
            $query->execute(array(":type" => $roleType));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("User role not found");
            }
            return $result;
        } catch (PDOException $e) {
            echo 'unable to fetch user role: '. $e;
            throw new Exception("User role not found");
        }
    }
}