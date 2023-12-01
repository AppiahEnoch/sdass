<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    if (isset($_FILES['update_completed_registration_list_file']) && $_FILES['update_completed_registration_list_file']['error'] == 0) {
        $inputFileName = $_FILES['update_completed_registration_list_file']['tmp_name'];

        // Load the Excel file
        $spreadsheet = IOFactory::load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        // Prepare the insert on duplicate update statement with conditional check
        $sql = "INSERT INTO enrollment_code (index_number, code, is_verified) VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                code = IF(is_verified != 1, VALUES(code), code), 
                is_verified = IF(is_verified != 1, VALUES(is_verified), is_verified)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        // Start a transaction
        $conn->begin_transaction();

        // Set the batch size
        $batchSize = 200;
        $batchCount = 0;
        for ($row = 2; $row <= $highestRow; $row++) {
            // Read data from the Excel file
            $index_number = $worksheet->getCell('A' . $row)->getValue();
            $code = $worksheet->getCell('B' . $row)->getValue();
            $isVerified = (int) $worksheet->getCell('C' . $row)->getValue();

            // Bind parameters and execute the statement
            $stmt->bind_param("ssi", $index_number, $code, $isVerified);
            $stmt->execute();

            // Commit the transaction after processing a batch
            $batchCount++;
            if ($batchCount % $batchSize == 0) {
                $conn->commit();
                $conn->begin_transaction();
            }
        }

        // Commit the remaining transaction
        $conn->commit();

        // Close the statement
        $stmt->close();

        $conn->close();

        echo "Successfully imported " . $highestRow . " rows";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
