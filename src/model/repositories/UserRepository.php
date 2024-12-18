<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';

class UserRepository {

    /**
     * Gets the PDO database connection singleton
     * @return PDO The database connection
     */
    private function getdb(): PDO {
        return DatabaseConnection::getInstance(); // singleton
    }

    /**
     * Returns a User object from the database given an email address.
     * @param string $email The email address to search for
     */
    public function getUserByEmail(string $email): array {
        $db = $this->getdb();
        // Modify the query to join the UserRole (or Role) table
        $query = $db->prepare("SELECT u.*, ur.type
            FROM User u
            JOIN UserRole ur ON u.roleId = ur.roleId
            WHERE u.email = :email");
        try {
            $query->execute(array(":email" => htmlspecialchars($email)));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("User not found!");
            } 
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch user by email!");
        }
    }


    /**
     * Returns a User object from the database given a user ID.
     * @param int $id The ID of the user to search for
     * @return array A User object with its associated role
     * @throws Exception If the user is not found
     * @throws PDOException If there was a problem fetching the user
     */
    public function getUserById(int $id) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT u.*, ur.*
            FROM User u
            JOIN UserRole ur ON u.roleId = ur.roleId
            WHERE u.userId = :id");
        try {
            $query->execute(array(":id" => $id));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("User not found!");
            } 
            return $result;
        } catch (PDOException $e) {
            throw new PDOException("Unable to fetch user!");
        }
    }

    public function doesAccountExistByEmail(string $email): bool {
        $db = $this->getdb();
        $query = $db->prepare("SELECT COUNT(*) FROM User WHERE email = :email AND passwordHash IS NOT NULL LIMIT 1");
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetchColumn();
            return $result > 0;
        } catch (PDOException $e) {
            throw new PDOException("Unable to check if user exists by email!");
        }
    }

    public function doesGuestExistByEmail(string $email, string $role): int {
        $db = $this->getdb();
        // Modify the query to return the user id
        $query = $db->prepare("SELECT u.userId FROM User u
            JOIN UserRole ur ON u.roleId = ur.roleId
            WHERE u.email = :email
            AND ur.type = :role 
            AND u.passwordHash IS NULL");
        try {
            $query->execute(array(":email" => $email, ":role" => $role));
            $result = $query->fetchColumn();
            if ($result === false) {
                return 0;
            } else {
                return $result;
            }
        } catch (PDOException $e) {
            throw new PDOException("Unable to check if guest exists by email!");
        }
    }

    public function createGuestUser(array $formData, int $roleId): int {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO User (firstName, lastName, email, dob, roleId) VALUES (:firstName, :lastName, :email, :dob, :roleId)");
        try {
            $query->execute(array(
                ":firstName" => $formData['firstName'],
                ":lastName" => $formData['lastName'],
                ":email" => $formData['email'],
                ":dob" => $formData['dob'],
                ":roleId" => $roleId
            ));
            return $db->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Unable to create guest user!");
        }
    }

    public function updateGuestInfo(array $formData, int $userId): void {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE User SET firstName = :firstName, lastName = :lastName, dob = :dob WHERE userId = :userId");
        try {
            $query->execute(array(
                ":firstName" => $formData['firstName'],
                ":lastName" => $formData['lastName'],
                ":dob" => $formData['dob'],
                ":userId" => $userId
            ));
        } catch (PDOException $e) {
            throw new PDOException("Unable to update guest info!");
        }
    }

    public function updateProfileInfo(int $userId, array $newProfileInfo): bool {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE User SET firstName = :firstName, lastName = :lastName, email = :email, dob = :dob WHERE userId = :userId");
        try {
            $wasUpdated = $query->execute(array(
                ":firstName" => $newProfileInfo['firstName'],
                ":lastName" => $newProfileInfo['lastName'],
                ":email" => $newProfileInfo['email'],
                ":dob" => $newProfileInfo['dob'],
                ":userId" => $userId
            ));
            return $wasUpdated;
        } catch (PDOException $e) {
            throw new PDOException("Unable to update user profile info!");
        }
    }
}