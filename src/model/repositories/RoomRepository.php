<?php
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Venue.php";

class RoomRepository {
    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    private function getRoomById(int $roomId): Room {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Room WHERE roomId = ? JOIN Venue ON Room.venueId = Venue.venueId WHERE roomId = ?");
        try{
        $query->execute([$roomId]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            return null;
        }
        $room = new Room($row['roomId'], $row['roomNumber'], new Venue($row['venueId']));
        } catch (PDOException $e) {
            echo "Couldn't fetch room: " . $e->getMessage();
        }
        return $room;
    }
}
