<?php
class PaymentMethod {
  private int $methodId;
  private string $name;

  public function __construct(int $methodId, string $name) {
    $this->methodId = $methodId;
    $this->name = $name;
  }

  public function getMethodId(): int {
    return $this->methodId;
  }

  public function getName(): string {
    return $this->name;
  }

  public function setMethodId(int $methodId): void {
    $this->methodId = $methodId;
  }

  public function setName(string $name): void {
    $this->name = $name;
  }
}
?>