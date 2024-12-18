<?php
require_once 'src/model/database/dbcon/DatabaseConnection.php';
require_once "src/model/entity/Showing.php";
class ShowingRepository {
    private PDO $db;

    public function __construct($dbCon) {
        $this->db = $dbCon;
    }

    public function getShowingById(int $showingId): array {
        $query = $this->db->prepare("SELECT * FROM Showing as s WHERE s.showingId = :showingId");
        try {
            $query->execute(array(":showingId" => $showingId));
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showing found!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showing!");
        }

        return $result;
    }

    public function getShowingsForMovie(int $movieId, int $selectedVenueId): array {
        $this->db->exec("SET SQL_BIG_SELECTS=1");
        $query = $this->db->prepare("SELECT * FROM Showing as s JOIN VenueShowing as vs ON s.showingId = vs.showingId WHERE vs.venueId = :venueId 
        AND s.movieId = :movieId ORDER BY s.showingDate, s.showingTime ASC");
        try {
            $query->execute(array(":movieId" => $movieId, ":venueId" => $selectedVenueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for this movie!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }

    public function getShowingsForMovieAdmin(int $movieId): array {
        $this->db->exec("SET SQL_BIG_SELECTS=1");
        $query = $this->db->prepare("SELECT * FROM ShowingsWithDetails as swd WHERE swd.movieId = :movieId ORDER BY swd.showingDate, swd.showingTime ASC");
        try {
            $query->execute(array(":movieId" => $movieId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for this movie!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }

    public function getUnavailableTimeslotsForMovie(int $venueId, int $movieId, string $showingDate): array {
        $query = $this->db->prepare("SELECT s.showingTime FROM Showing as s
        JOIN VenueShowing as vs ON s.showingId = vs.showingId
        WHERE vs.venueId = :venueId 
        AND s.movieId = :movieId
        AND s.showingDate = :showingDate");
        try {
            $query->execute(array(":venueId" => $venueId, ":movieId" => $movieId, ":showingDate" => $showingDate));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for this movie in this venue for this date!");
        }
    }

    public function getUnavailableRoomsForAVenueAndDay(int $venueId, string $showingDate): array {
        $query = $this->db->prepare("SELECT s.roomId, s.showingTime, m.duration FROM Showing as s
        JOIN VenueShowing as vs ON s.showingId = vs.showingId
        JOIN Movie as m ON s.movieId = m.movieId
        WHERE vs.venueId = :venueId 
        AND s.showingDate = :showingDate");
        try {
            $query->execute(array(":venueId" => $venueId, ":showingDate" => $showingDate));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for this movie in this venue for this date!");
        }
    }

    /**
     * Gets the movies playing today for the given venue.
     *
     * @param int $venueId The ID of the venue to get the movies for.
     *
     * @return array An array of movie IDs that are playing today at the given venue.
     */
    public function getMoviesPlayingToday(int $venueId): array {
        $today = date('Y-m-d');
        try {
            $showingIds = $this->getShowingIdsForVenue($venueId);
            $showingIdsList = [];
            foreach ($showingIds as $showing) {
                array_push($showingIdsList, $showing['showingId']);
            }
    
            if (empty($showingIdsList)) {
                throw new Exception("No showings found for this Venue!");
            }
        } catch (PDOException $e) {
            throw $e;
        }
        try {
            // Join array elements with a separator string, it'll look sg like this: (1,2,3,4)
            $placeholders = implode(',', array_fill(0, count($showingIdsList), '?'));
            $query = $this->db->prepare(
                "SELECT DISTINCT s.movieId 
            FROM Showing as s 
            WHERE s.showingId IN ($placeholders) 
            AND s.showingDate = ?"
            );

            // Merge the showing IDs and today's date
            $query->execute(array_merge($showingIdsList, [$today]));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                throw new Exception("No showings found for today!");
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch movies playing today!");
        }

        return $result;
    }

    private function getShowingIdsForVenue(int $venueId): array {
        $query = $this->db->prepare("SELECT * FROM VenueShowing as vs WHERE vs.venueId = :venueId");
        try {
            $query->execute(array(":venueId" => $venueId));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            if (empty($result)) {
                return [];
            }
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }

        return $result;
    }

    public function getRelevantShowingsForMovie(int $movieId): array {
        $this->db->exec("SET SQL_BIG_SELECTS=1");
        $query = $this->db->prepare("SELECT * FROM Showing as s
        JOIN VenueShowing as vs ON s.showingId = vs.showingId
        JOIN Room as r ON s.roomId = r.roomId
        AND s.movieId = :movieId
        AND s.showingDate >= :today
        ORDER BY s.showingDate, s.showingTime ASC");
        try {
            $query->execute(array(":movieId" => $movieId, ":today" => date('Y-m-d')));
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception("Unable to fetch showings for venue!");
        }
    }

    public function addShowing(array $showingData): void {
        $showingQuery = $this->db->prepare("INSERT INTO Showing (showingDate, showingTime, movieId, roomId, archived) VALUES (:showingDate, :showingTime, :movieId, :roomId, :archived)");
        $venueShowingQuery = $this->db->prepare("INSERT INTO VenueShowing (venueId, showingId) VALUES (:venueId, :showingId)");
        try {
            $this->db->beginTransaction();
            $showingQuery->execute(array(
                ":showingDate" => $showingData['showingDate'],
                ":showingTime" => $showingData['showingTime'],
                ":movieId" => $showingData['movieId'],
                ":roomId" => $showingData['roomId'],
                ":archived" => 0
            ));
            $showingId = $this->db->lastInsertId(); // Get the ID of the last inserted showing
            $venueShowingQuery->execute(array(":venueId" => $showingData['venueId'], ":showingId" => $showingId));
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new PDOException("Failed to add showing!");
        }
    }

    public function editShowing(array $showingData): void {
        $showingQuery = $this->db->prepare("UPDATE Showing SET showingDate = :showingDate, showingTime = :showingTime, movieId = :movieId, roomId = :roomId 
        WHERE showingId = :showingId");
        $venueShowingQuery = $this->db->prepare("UPDATE VenueShowing SET venueId = :venueId WHERE showingId = :showingId");
        
        try {
            $this->db->beginTransaction();
            $showingQuery->execute(array(
                ":showingDate" => $showingData['showingDate'],
                ":showingTime" => $showingData['showingTime'],
                ":movieId" => $showingData['movieId'],
                ":roomId" => $showingData['roomId'],
                ":showingId" => $showingData['showingId']
            ));
            $venueShowingQuery->execute(array(":venueId" => $showingData['venueId'], ":showingId" => $showingData['showingId']));
            $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw new PDOException("Failed to add showing!");
        }
    }

    public function archiveShowing (int $showingId): void {
        $query = $this->db->prepare("UPDATE Showing SET archived = 1 WHERE showingId = :showingId");
        try {
            $query->execute(array(":showingId" => $showingId));
        } catch (PDOException $e) {
            throw new PDOException("Unable to archive showing!");
        }

    }

    public function restoreShowing (int $showingId):void {
        $query = $this->db->prepare("UPDATE Showing SET archived = 0 WHERE showingId = :showingId");
        try {
            $query->execute(array(":showingId" => $showingId));
        } catch (PDOException $e) {
            throw new PDOException("Unable to restore showing!");
        }
    }
}
