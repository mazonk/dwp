<?php
// If you are using namespaces, include the appropriate declaration
// namespace YourNamespace;

include "src/model/entity/Showing.php";
include "src/model/entity/Movie.php";
include "src/model/entity/Room.php";
include "src/model/entity/Venue.php";

class ShowingRepository {
    private function getdb() {
        require 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getAllShowings(): array {
        $db = $this->getdb();
        
        try {
            $query = $db->prepare("SELECT * FROM Showing");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            
            $retArray = [];
            foreach ($result as $row) {
                $retArray[] = new Showing(
                    $row['showingId'], 
                    $row['movieId'], 
                    $row['roomId'], 
                    $row['venueId'], 
                    $row['startTime'], 
                    $row['endTime']
                );
            }
            return $retArray;
        } catch (PDOException $e) {
            // Handle error, maybe log it or return an empty array
            // error_log($e->getMessage()); // Example logging
            return [];
        }
    }
}
