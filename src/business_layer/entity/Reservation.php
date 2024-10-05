<?php

enum Status
{
    case pending;
    case confirmed;
    case cancelled;
}

class Resevation {
    private int $reservationId;
    private User $user;
    private Status $status;

    public function __construct(int $reservationId, User $user, Status $status) {
        $this->reservationId = $reservationId;
        $this->user = $user;
        $this->status = $status;
    }

    public function getReservationId(): int {
        return $this->reservationId;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function setReservationId(int $reservationId): void {
        $this->reservationId = $reservationId;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
    }   
}
?>


