<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['admission_number_list_excel_file']) && $_FILES['admission_number_list_excel_file']['error'] == 0) {
    $inputFileName = $_FILES['admission_number_list_excel_file']['tmp_name'];
    
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();

    // Prepare the insert statement
    $insertSql = "INSERT IGNORE INTO sdass_admission_number (admission_number) VALUES (?)";
    $insertStmt = $conn->prepare($insertSql);

    // Start a transaction
    $conn->begin_transaction();

    // Set the batch size
    $batchSize = 200;
    $batchCount = 0;

    for ($row = 3; $row <= $highestRow; $row++) {
        // Read data from the Excel file
        $admission_number = $worksheet->getCell('A' . $row)->getValue();

        // Insert the admission number
        $insertStmt->bind_param("s", $admission_number);
        $insertStmt->execute();

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
    $insertStmt->close();

    $conn->close();
}
?>
