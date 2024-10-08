<?php
include "src/model/entity/UserRole.php";
class UserRoleRepository {
    private function getdb(): PDO {
        include_once "src/model/database/dbcon/dbcon.php";
        return $db;
    }
    public function getAll(): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $retArray =  [];
        foreach ($result as $row) {
            $retArray[] = new UserRole($row['id'], type: $row['type']);
        }
        return $retArray;
    }

    public function getUserRole(string $roleType): UserRole {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM UserRole ur WHERE ur.type = :type");
        $query->execute(array(":type" => $roleType));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return new UserRole($result['id'], type: $result['type']);
    }
}