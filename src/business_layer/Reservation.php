<?php

enum Status
{
    case pending;
    case confirmed;
    case cancelled;
}

class Resevation {
    private int $reservationId;
    private int $userId;
    private Status $status;

    public function __construct(int $reservationId, int $userId, Status $status) {
        $this->reservationId = $reservationId;
        $this->userId = $userId;
        $this->status = $status;
    }

    public function getReservationId(): int {
        return $this->reservationId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
    }

    public function setStatus(string $status): void { 
          
}


