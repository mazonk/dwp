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
        } catch (PDOException $e) {
            echo 'unable to fetch user roles: '. $e;
        }
        $retArray = [];
        foreach ($result as $row) {
            $retArray[] = new UserRole($row['id'], type: $row['type']);
        }
        return $retArray;
    }

    public function getUserRole(string $roleType): UserRole {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole ur WHERE ur.type = :type");
        try {
            $query->execute(array(":type" => $roleType));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'unable to fetch user role: '. $e;
        }
        return new UserRole($result['roleId'], type: $result['type']);
    }
}