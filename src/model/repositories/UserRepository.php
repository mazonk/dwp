<?php

class UserRepository {

    /**
     * Gets the PDO database connection singleton
     * @return PDO The database connection
     */
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
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

    public function updateProfileInfo(int $userId, array $newProfileInfo): void {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE User SET firstName = :firstName, lastName = :lastName, email = :email, dob = :dob WHERE userId = :userId");
        try {
            $query->execute(array(
                ":firstName" => $newProfileInfo['firstName'],
                ":lastName" => $newProfileInfo['lastName'],
                ":email" => $newProfileInfo['email'],
                ":dob" => $newProfileInfo['dob'],
                ":userId" => $userId
            ));
        } catch (PDOException $e) {
            throw new PDOException("Unable to update user profile info!");
        }
    }
}