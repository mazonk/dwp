<?php
class User extends Person {
  private DateTime $dob;
  private string $email;
  private string $passwordHash;

  public function __construct(int $userId, string $firstName, string $lastName, DateTime $dob, string $email, string $passwordHash) {
    parent::__construct($userId, $firstName, $lastName);
    $this->dob = $dob;
    $this->email = $email;
    $this->passwordHash = $passwordHash;
  }

  public function getDob(): DateTime {
    return $this->dob;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getPasswordHash(): string {
    return $this->passwordHash;
  }

  public function setDob(DateTime $dob): void {
    $this->dob = $dob;
  }

  public function setEmail(string $email): void {
    $this->email = $email;
  }

  public function setPasswordHash(string $passwordHash): void {
    $this->passwordHash = $passwordHash;
  }
}

?>