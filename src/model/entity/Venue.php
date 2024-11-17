<?php
<<<<<<< HEAD
include_once "src/model/entity/Address.php";
=======
>>>>>>> main

class Venue {
    private int $venueId;
    private string $name;
    private string $phoneNr;
    private string $contactEmail;
    private Address $address;

    public function __construct(int $venueId, string $name, string $phoneNr, string $contactEmail, Address $address) {
        $this->venueId = $venueId;
        $this->name = $name;
        $this->phoneNr = $phoneNr;
        $this->contactEmail = $contactEmail;
        $this->address = $address;
    }

    public function getVenueId(): int {
        return $this->venueId;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPhoneNr(): string {
        return $this->phoneNr;
    }    

    public function getContactEmail(): string {
        return $this->contactEmail;
    }

    public function getAddress(): Address {
        return $this->address;
    }

    public function setVenueId(int $venueId): void {
        $this->venueId = $venueId;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }    

    public function setPhoneNr(string $phoneNr): void {
        $this->phoneNr = $phoneNr;
    }

    public function setContactEmail(string $contactEmail): void {        
        $this->contactEmail = $contactEmail;
    }

    public function setAddress(Address $address): void {
        $this->address = $address;
    }
}
?>