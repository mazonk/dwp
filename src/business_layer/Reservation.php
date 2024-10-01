<?php

class Resevation {
    private int $reservationId;
    private int $userId;
    private enum $status;

    public function __construct(int $reservationId, int $userId, string $status) {
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

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void { 
          
}

enum status
{
    case pending;
    case confirmed;
    case cancelled;
}

