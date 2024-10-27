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
    
}