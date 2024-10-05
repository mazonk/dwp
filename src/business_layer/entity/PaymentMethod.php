<?php
class PaymentMethod {
  private int $methodId;
  private string $methodName;

  public function __construct(int $methodId, string $methodName) {
    $this->methodId = $methodId;
    $this->methodName = $methodName;
  }

  public function getMethodId(): int {
    return $this->methodId;
  }

  public function getMethodName(): string {
    return $this->methodName;
  }

  public function setMethodId(int $methodId): void {
    $this->methodId = $methodId;
  }

  public function setMethodName(string $methodName): void {
    $this->methodName = $methodName;
}
?>