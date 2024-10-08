<?php

class UserRepository {
    private function getdb(): PDO {
        include_once "src/model/database/dbcon/dbcon.php";
        return $db;
    }

    public function createUser(User $user): User | null {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO User (firstName, lastName, DoB, email, roleId) VALUES (:firstName, :lastName, :DoB, :email, :roleId)");
        try {
            $wasInserted = $query->execute(array(
                ":firstName" => $user->getFirstName(),
                ":lastName" => $user->getLastName(),
                ":DoB" => $user->getDoB(),
                ":email" => $user->getEmail(),
                ":roleId" => $user->getUserRole()->getRoleId()
            ));

            if (!$wasInserted) {
                return null;
            } else {
                $user->setId($db->lastInsertId());
            }

            return $user;
        } catch (PDOException $e) {
            return null;
        }
    }
}