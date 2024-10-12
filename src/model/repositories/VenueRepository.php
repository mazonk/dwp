<?php¨
include "src/model/entity/Venue.php";

class VenueRepository {
  include_once "src/model/database/dbcon/dbcon.php";
  return $db;

  public function getAllVenues(): array {
    $db = $this->getdb();
    $query = $db->prepare("SELECT * FROM Venue");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $retArray = [];
    
    foreach($result as $row) {
      $retArray[] = new Venue($row['venueId'], $row['name'], $row['phoneNr'], $row['contactEmail'], $row['address']);
    }
    return $retArray;
  }

}