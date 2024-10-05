<?php
class Actor extends Person {
  private $character;

  public function __construct(int $actorId, string $firstName, string $lastName, string $character) {
    parent::__construct($actorId, $firstName, $lastName);
    $this->character = $character;
  }

  public function getCharacter(): string {
    return $this->character;
  }

  public function setCharacter(string $character): void {
    $this->character = $character;
  }
}
?>