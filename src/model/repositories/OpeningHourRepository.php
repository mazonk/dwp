<?php
inlude "src/model/entity/OpeningHour.php";

class OpeningHourRepository {
  private function getdb() {
    require_once 'src/model/database/dbcon/DatabaseConnection.php';
    return DatabaseConnection::getInstance(); // singleton
  }
}