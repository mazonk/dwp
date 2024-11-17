<?php
<<<<<<< HEAD
include_once "src/model/entity/Movie.php";
include_once "src/model/entity/Room.php";
=======
>>>>>>> main

class Showing {
    private int $showingId;
    private Movie $movie;
    private Room $room;
    private DateTime $showingDate;
    private DateTime $showingTime;

    public function __construct(int $showingId, Movie $movie, Room $room, DateTime $showingDate, DateTime $showingTime) {
        $this->showingId = $showingId;
        $this->movie = $movie;
        $this->room = $room;
        $this->showingDate = $showingDate;
        $this->showingTime = $showingTime;
    }

    public function getShowingId(): int {
        return $this->showingId;
    }

    public function getMovie(): Movie {
        return $this->movie;
    }

    public function getRoom(): Room {
        return $this->room;
    }

    public function getShowingDate(): DateTime {
        return $this->showingDate;
    }

    public function getShowingTime(): DateTime {
        return $this->showingTime;
    }

    public function setShowingId(int $showingId): void {
        $this->showingId = $showingId;
    }

    public function setMovie(Movie $movie): void {
        $this->movie = $movie;
    }

    public function setRoom(Room $room): void {
        $this->room = $room;
    }

    public function setShowingDate(DateTime $showingDate): void {
        $this->showingDate = $showingDate;
    }

    public function setShowingTime(DateTime $showingTime): void {
        $this->showingTime = $showingTime;
    }
}
?>
