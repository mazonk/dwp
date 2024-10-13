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
     * Creates a new user and inserts it into the database
     * @param User $user The user to create
     * @return User|null The created user, or null if something went wrong
     */
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

    /**
     * Creates a new user if there is already an existing user with the email
     * address, but the passwordHash is null (i.e. the user was inserted into the db
     * during ticket purchase, as an anonyumous user). Updates the existing user with
     * the given information.
     * @param User $user The user to create
     * @return User|null The created user, or null if something went wrong
     */
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

    /**
     * Returns a User object from the database given an email address.
     * @param string $email The email address to search for
     * @return User|null The User object if found, null otherwise
     */
    public function getUserByEmail(string $email): ?User {
        $db = $this->getdb();
        
        // Modify the query to join the UserRole (or Role) table
        $query = $db->prepare("SELECT u.*, ur.type
            FROM User u
            JOIN UserRole ur ON u.roleId = ur.roleId
            WHERE u.email = :email");
        
        try {
            $query->execute(array(":email" => $email));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if (empty($result)) {
                return null;
            } else {
                // Create the User object and pass both roleId and roleType to UserRole constructor
                return new User(
                    $result['id'],
                    $result['firstName'],
                    $result['lastName'],
                    new DateTime($result['DoB']),
                    $result['email'],
                    $result['passwordHash'],
                    new UserRole($result['roleId'], $result['type'])
                );
            }
        } catch (PDOException $e) {
            return null;
        }
    }
    
    
    /**
     * Checks if the given email exists in the database
     * @param string $email the email to check
     * @return bool true if the email exists, false otherwise
     */
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
    
    /**
     * Checks if the given email exists in the database and the password is not null (meaning there's an account with the given email)
     * @param string $email the email to check
     * @return bool true if the email exists and the password is not null, false otherwise
     */
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