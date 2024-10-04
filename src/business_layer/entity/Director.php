<?php
class Director extends Person {
    public function __construct(int $directorId, string $firstName, string $lastName) {
        parent::__construct($directorId, $firstName, $lastName);
    }

    public function getDirectorId(): int {
        return $this->getId(); // Accessing the parent method to get ID
    }
}
?>
