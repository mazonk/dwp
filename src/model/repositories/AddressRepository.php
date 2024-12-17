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
    try {
      $addressQuery = $this->db->prepare("UPDATE `Address` SET street = :street, streetNr = :streetNr WHERE addressId = :addressId");
      $addressQuery->execute([
        'street' => htmlspecialchars($street),
        'streetNr' => htmlspecialchars($streetNr),
        'addressId' => htmlspecialchars($addressId),
      ]);
      $postalCodeQuery = $this->db->prepare("UPDATE `PostalCode` SET postalCode = :postalCode, city = :city WHERE postalCodeId = :postalCodeId");
      $postalCodeQuery->execute([
        'postalCode' => htmlspecialchars($postalCode),
        'city' => htmlspecialchars($city),
        'postalCodeId' => htmlspecialchars($postalCodeId)
      ]);
    } catch (PDOException $e) {
      throw new PDOException("Unable to update address and postal code!");
    }
  }

  public function doesAddressExist(array $addressFormData, int $postalCodeId): int {
    $query = $this->db->prepare("SELECT addressId FROM `Address`
    WHERE street = :street
    AND streetNr = :streetNr
    AND postalCodeId = :postalCodeId");
    try {
      $query->execute(array(
        ":street" => $addressFormData['street'],
        ":streetNr" => $addressFormData['streetNr'],
        ":postalCodeId" => $postalCodeId
      ));
      $result = $query->fetchColumn();
      if ($result === false) {
          return 0;
      } else {
          return $result;
      }
    } catch (PDOException $e) {
      throw new PDOException("Unable to check if address exists!");
    }
  }

  public function createAddress(array $addressFormData, int $postalCodeId): int {
    $query = $this->db->prepare("INSERT INTO `Address` (street, streetNr, postalCodeId) VALUES (:street, :streetNr, :postalCodeId)");
    try {
      $query->execute([
        'street' => $addressFormData['street'],
        'streetNr' => $addressFormData['streetNr'],
        'postalCodeId' => $postalCodeId
      ]);
      return $this->db->lastInsertId();
    } catch (PDOException $e) {
      throw new PDOException("Unable to create address and postal code!");
    }
  }
}