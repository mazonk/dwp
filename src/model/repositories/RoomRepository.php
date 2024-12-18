<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/entity/Room.php";
require_once "src/model/entity/Venue.php";

class RoomRepository {
    private function getdb() {
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getRoomById(int $roomId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Room as r WHERE r.roomId = :roomId");
        try{
            $query->execute(array(":roomId" => htmlspecialchars($roomId)));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No room found!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch room!");
        }
        
        return $result;
    }

    public function getRoomsByVenueId(int $venueId): array {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Room WHERE venueId = :venueId");
        try{
            $query->execute(array(":venueId" => $venueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No rooms found!");
            }
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch rooms!");
        }
    }
}
