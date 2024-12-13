<?php

enum Status: string {
    case CONFIRMED = 'confirmed';
    case PENDING = 'pending';
    case FAILED = 'failed';
}

class Booking {
    private int $bookingId;
    private ?User $user;
    private Status $status;

    public function __construct(int $bookingId, User $user = null, Status $status) {
        $this->bookingId = $bookingId;
        $this->user = $user;
        $this->status = $status;
    }

    public function getBookingId(): int {
        return $this->bookingId;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getStatus(): Status {
        return $this->status;
    }

    public function setBookingId(int $bookingId): void {
        $this->bookingId = $bookingId;
    }

    public function setUser(User $user): void {
        $this->user = $user;
    }

    public function setStatus(Status $status): void {
        $this->status = $status;
    }
}
?>