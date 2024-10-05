<?php 
class Role {
  private int $roleId;
  private string $role;

  public function __construct(int $roleId, string $role) {
    $this->roleId = $roleId;
    $this->role = $role;
  }

  public function getRoleId(): int {
    return $this->roleId;
  }

  public function getRole(): string {
    return $this->role;
  }

  public function setRoleId(int $roleId): void {
    $this->roleId = $roleId;
  }

  public function setRole(string $role): void {
    $this->role = $role;
  }
}
?>