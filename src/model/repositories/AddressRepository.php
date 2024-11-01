<?php
class AddressRepository {
  private PDO $db;

  public function __construct($dbCon) {
    $this->db = $dbCon;
  }

  /* Get all addresses */
  public function getAllAddresses(): array {
    $addressQuery = $this->db->prepare("SELECT *  FROM `Address`");
    // Get all addresses
    try {
      $addressQuery->execute();
      $addressResult = $addressQuery->fetchAll(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("No addresses found");
      }
      else {
        $postalCodeQuery = $this->db->prepare("SELECT * FROM PostalCode");
        // Get all postal codes
        try {
          $postalCodeQuery->execute();
          $postalCodeResult = $postalCodeQuery->fetchAll(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("No postal codes found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal codes");
        }
      }
    } catch (PDOException $e) {
        throw new Exception("Unable to fetch addresses");
    }
  }

  /* Get address by id */
  public function getAddressById(int $addressId): array { 
    $query = $this->db->prepare("SELECT * FROM `Address` WHERE addressId = :addressId");
    // Get address by id
    try {
      $query->execute(['addressId' => htmlspecialchars($addressId)]);
      $addressResult = $query->fetch(PDO::FETCH_ASSOC);
      if (empty($addressResult)) {
        throw new Exception("Address not found");
      }
      else {
        $postalCodeQuery = $this->db->prepare("SELECT * FROM PostalCode WHERE postalCodeId = :postalCodeId");
        // Get postal code by postal code
        try {
          $postalCodeQuery->execute(['postalCodeId' => htmlspecialchars($addressResult['postalCodeId'])]);
          $postalCodeResult = $postalCodeQuery->fetch(PDO::FETCH_ASSOC);
          if (empty($postalCodeResult)) {
            throw new Exception("Postal code not found");
          }
          // Return both address and postal code results in an associative array
          return [
            'addressResult' => $addressResult,
            'postalCodeResult' => $postalCodeResult
          ];
        }
        catch (PDOException $e) {
          throw new Exception("Unable to fetch postal code");
        }
      }
    } catch (PDOException $e) {
      throw new Exception("Unable to fetch address");
    }
  }

  /* Update address */
public function updateAddress(int $addressId, string $street, string $streetNr, int $postalCodeId, int $postalCode, string $city): void {
  $this->db->beginTransaction();
  try {
    $addressQuery = $this->db->prepare("UPDATE `Address` SET street = :street, streetNr = :streetNr WHERE addressId = :addressId");
    $addressQuery->execute([
      'street' => htmlspecialchars($street),
      'streetNr' => htmlspecialchars($streetNr),
      'addressId' => $addressId,
    ]);
    if ($addressQuery->rowCount() === 0) {
      throw new Exception("Address update failed or no changes made");
    }
    $postalCodeQuery = $this->db->prepare("UPDATE `PostalCode` SET postalCode = :postalCode, city = :city WHERE postalCodeId = :postalCodeId");
    $postalCodeQuery->execute([
      'postalCode' => htmlspecialchars($postalCode),
      'city' => htmlspecialchars($city),
      'postalCodeId' => htmlspecialchars($postalCodeId)
    ]);
    if ($postalCodeQuery->rowCount() === 0) {
      throw new Exception("Postal code update failed or no changes made");
    }
    $this->db->commit();
  } catch (PDOException $e) {
    $this->db->rollBack();
    throw new PDOException("Unable to update address and postal code!");
  }
}

}