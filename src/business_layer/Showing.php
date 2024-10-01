<?php

class Showing {
    private int $showingId;
    private int $movieId;
    private int $roomId;
    private DateTime $showingDate;
    private DateTime $showingTime;

    public function __construct(int $showingId, int $movieId, int $roomId, DateTime $showingDate, DateTime $showingTime) {
        $this->showingId = $showingId;
        $this->movieId = $movieId;
        $this->roomId = $roomId;
        $this->showingDate = $showingDate;
        $this->showingTime = $showingTime;
    }

    public function getShowingId(): int {
        return $this->showingId;
    }

    public function getMovieId(): int {
        return $this->movieId;
    }

    public function getRoomId(): int {
        return $this->roomId;
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

    public function setMovieId(int $movieId): void {
        $this->movieId = $movieId;
    }

   public function setRoomId(int $roomId): void {
        $this->roomId = $roomId;
    }

    public function setShowingDate(DateTime $showingDate): void {
        $this->showingDate = $showingDate;
    }

    public function setShowingTime(DateTime $showingTime): void {
        $this->showingTime = $showingTime;
    }
}
?>
