<?php
require_once "src/model/entity/Person.php";
class Director extends Person {
    public function __construct(int $directorId, string $firstName, string $lastName) {
        parent::__construct($directorId, $firstName, $lastName);
    }
}