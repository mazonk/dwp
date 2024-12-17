<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/entity/UserRole.php";
class UserRoleRepository {
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllUserRoles(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole");
        try {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No user roles found!");
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Couldn't fetch user role!");
        }
    }

    public function getUserRoleByType(string $roleType): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole ur WHERE ur.type = :type");
        try {
            $query->execute(array(":type" => htmlspecialchars($roleType)));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("User role not found!");
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Couldn't fetch user role!");
        }
    }
}