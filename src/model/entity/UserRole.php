<?php 
class Role {
  private int $roleId;
  private string $type;

  public function __construct(int $roleId, string $type) {
    $this->roleId = $roleId;
    $this->type = $type;
  }

  public function getRoleId(): int {
    return $this->roleId;
  }

  public function getType(): string {
    return $this->type;
  }

  public function setRoleId(int $roleId): void {
    $this->roleId = $roleId;
  }

  public function setType(string $type): void {
    $this->type = $type;
  }
}
?>