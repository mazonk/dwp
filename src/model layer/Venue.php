<?php

class Venue {
    private int $venueId;
    private string $name;
    private string $phoneNr;
    private string $contactEmail;
    private int $addressId;

    public function __construct(int $venueId, string $name, string $phoneNr, string $contactEmail, int $addressId) {
        $this->venueId = $venueId;
        $this->name = $name;
        $this->phoneNr = $phoneNr;
        $this->contactEmail = $contactEmail;
        $this->addressId = $addressId;
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

    public function getAddressId(): int {
        return $this->addressId;
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
}
?>