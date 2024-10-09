<?php

class UserRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
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
                $user->setId($this->getdb()->lastInsertId());
            }

            return $user;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function emailExists(string $email): bool {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM User WHERE email = :email");
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Return true if the result is not empty (MEANING EMAIL EXISTS)
        } catch (PDOException $e) {
            return false;
        }
    }
}