<?php

// Parent class
class Person {
    protected int $id; // Common property for both Director and Actor
    protected string $firstName;
    protected string $lastName;

    public function __construct(int $id = null, string $firstName, string $lastName) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }
}
?>
