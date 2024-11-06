<?php

enum Status
{
    case pending;
    case confirmed;
    case cancelled;
}

class Booking {
    private int $reservationId;
    private User $user;
    private Status $status;

    private array $tickets;

    public function __construct(int $reservationId, User $user, Status $status, array $tickets) {
        $this->reservationId = $reservationId;
        $this->user = $user;
        $this->status = $status;
        $this->tickets = $tickets;
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

    public function getTickets(): array {
        return $this->tickets;
    }

    public function setReservationId(int $reservationId): void {
        $this->reservationId = $reservationId;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
    } 

    public function setTickets(array $tickets): void {
        $this->tickets = $tickets;
    }
}
?>


