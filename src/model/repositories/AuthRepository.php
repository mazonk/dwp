<?php 
class AuthRepository {

    /**
     * Gets the PDO database connection singleton
     * @return PDO The database connection
     */
    private function getdb(): PDO {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    /**
     * Creates a new user in the database
     * @param User $user The user to create
     * @return int The ID of the newly created user
     * @throws Exception If there was a problem creating the user
     */
    public function createUser(User $user): int {
        $db = $this->getdb();
        $query = $db->prepare("INSERT INTO User (firstName, lastName, DoB, email, passwordHash, roleId) VALUES (:firstName, :lastName, :DoB, :email, :passwordHash, :roleId)");
        try {
            $result = $query->execute(array(
                ":firstName" => $user->getFirstName(),
                ":lastName" => $user->getLastName(),
                ":DoB" => $user->getDoB()->format('Y-m-d'), // Convert DateTime to string
                ":email" => $user->getEmail(),
                ":passwordHash" => $user->getPasswordHash(),
                ":roleId" => $user->getUserRole()->getRoleId()
            ));
            if ($result === 0) { //bool - false indicates no rows were affected
                throw new Exception("Error creating user!");
            }

            return $this->getdb()->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Couldn't insert user!");
        }
    }

    /**
     * Updates an existing user in the database to have a password hash
     * @param User $user The user to update
     * @return int The ID of the newly created user
     * @throws Exception If there was a problem creating the user
     */
    public function createUserToExistingEmail(User $user): int {
        $db = $this->getdb();
        $query = $db->prepare("UPDATE User 
            SET firstName = :firstName, lastName = :lastName, DoB = :DoB, passwordHash = :passwordHash, roleId = :roleId 
            WHERE email = :email
            AND passwordHash IS NULL"); // Correct the NULL check
    
        try {
    
            $result = $query->execute([
                ":firstName" => $user->getFirstName(),
                ":lastName" => $user->getLastName(),
                ":DoB" => $user->getDoB()->format('Y-m-d'),
                ":passwordHash" => $user->getPasswordHash(),
                ":roleId" => $user->getUserRole()->getRoleId(),
                ":email" => $user->getEmail()
            ]);

            if ($result === 0) { // bool - false indicates no rows were affected
                throw new Exception("Couldn't create user to this email!");
            }
    
            return $this->getdb()->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Couldn't insert user!");
        }
    }

    /**
     * Checks if the given email exists in the database.
     * @param string $email the email to check
     * @return bool true if the email exists, false otherwise
     * @throws Exception If there was a problem checking for email
     */
    public function emailExists(string $email): bool {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM User WHERE email = :email");
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Return true if the result is not empty (MEANING EMAIL EXISTS)
        } catch (PDOException $e) {
            throw new PDOException(message: "Error checking email existence!");
        }
    }
    

    /**
     * Checks if the given email exists in the database for a user with a set password.
     * @param string $email the email to check
     * @return bool true if the email exists for a user with a password, false otherwise
     * @throws Exception If there was a problem checking for user
     */
    public function userExists(string $email): bool {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM User WHERE email = :email AND passwordHash IS NOT NULL");
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return !empty($result); // Return true if the result is not empty (MEANING USER EXISTS)
        } catch (PDOException $e) {
            throw new PDOException("Error checking user existence!");
        }
    }
}
