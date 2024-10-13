<?php

class AuthRepository {
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function createUser(User $user): ?User {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO User (firstName, lastName, DoB, email, passwordHash, roleId) VALUES (:firstName, :lastName, :DoB, :email, :passwordHash, :roleId)");
        try {
            $wasInserted = $query->execute(array(
                ":firstName" => $user->getFirstName(),
                ":lastName" => $user->getLastName(),
                ":DoB" => $user->getDoB()->format('Y-m-d'), // Convert DateTime to string
                ":email" => $user->getEmail(),
                ":passwordHash" => $user->getPasswordHash(),
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

    public function createUserToExistingEmail(User $user): ?User {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE User 
            SET firstName = :firstName, lastName = :lastName, DoB = :DoB, passwordHash = :passwordHash, roleId = :roleId 
            WHERE email = :email
            AND passwordHash IS NULL"); // Correct the NULL check
    
        try {
            // Begin transaction
            $db->beginTransaction();
    
            $wasUpdated = $query->execute([
                ":firstName" => $user->getFirstName(),
                ":lastName" => $user->getLastName(),
                ":DoB" => $user->getDoB()->format('Y-m-d'),
                ":passwordHash" => $user->getPasswordHash(),
                ":roleId" => $user->getUserRole()->getRoleId(),
                ":email" => $user->getEmail()
            ]);
    
            // Commit transaction
            $db->commit();
    
            if (!$wasUpdated) {
                return null;
            }
    
            return $user;
    
        } catch (PDOException $e) {
            // Rollback in case of error
            $db->rollBack();
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

    public function userExists(string $email): bool {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM User WHERE email = :email AND passwordHash IS NOT NULL");
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Return true if the result is not empty (MEANING USER EXISTS)
        } catch (PDOException $e) {
            return false;
        }
    }
}