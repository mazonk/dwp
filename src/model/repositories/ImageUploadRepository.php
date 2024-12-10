<?php

class ImageUploadRepository {
    private function getDb() {
        require_once 'src/model/database/dbcon/DatabaseConnection.php';
        return DatabaseConnection::getInstance(); // singleton
    }

    public function saveImageMetadata(string $fileName, string $filePath, string $uploadPath): bool {
        $db = $this->getDb();
        $query = $db->prepare("INSERT INTO Images (fileName, filePath, uploadPath, uploadedAt) VALUES (:fileName, :filePath, :uploadPath, NOW())");
        try {
            $query->execute([
                ':fileName' => htmlspecialchars($fileName),
                ':filePath' => htmlspecialchars($filePath),
                ':uploadPath' => htmlspecialchars($uploadPath)
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Unable to save image metadata: " . $e->getMessage());
        }
    }
}
