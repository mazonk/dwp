<?php
class TicketType {
  private int $ticketTypeId;
  private string $name;
  private float $price;
  private ?string $description;

  public function __construct(int $ticketTypeId, string $name, float $price, string $description = null) {
    $this->ticketTypeId = $ticketTypeId;
    $this->name = $name;
    $this->price = $price;
    $this->description = $description;
  }

  public function getTicketTypeId(): int {
    return $this->ticketTypeId;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getPrice(): float {
    return $this->price;
  }

  public function getDescription(): string {
    return $this->description;
  }

  public function setTicketTypeId(int $ticketTypeId): void {
    $this->ticketTypeId = $ticketTypeId;
  }

  public function setName(string $name): void {
    $this->name = $name;
  }

  public function setPrice(float $price): void {
    $this->price = $price;
  }

  public function setDescription(string $description): void {
    $this->description = $description;
  }
}