<?php
include_once "src/model/entity/Room.php";
include_once "src/model/entity/Venue.php";

class RoomRepository {
    private function getdb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function getRoomById(int $roomId) {
        $db = $this->getdb();
        $query = $db->prepare("SELECT * FROM Room as r WHERE r.roomId = :roomId");
        try{
        $query->execute(array(":roomId" => $roomId));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return null;
        }
        } catch (PDOException $e) {
            echo "Couldn't fetch room: " . $e->getMessage();
        }
        return $result;
    }
}
