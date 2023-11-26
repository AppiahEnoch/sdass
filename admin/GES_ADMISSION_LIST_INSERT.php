<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['student_list_excel_file']) && $_FILES['student_list_excel_file']['error'] == 0) {
    $inputFileName = $_FILES['student_list_excel_file']['tmp_name'];
    
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();

    // Prepare the insert/update statements
    $updateSql = "UPDATE ges_admission_list SET name = ?, gender = ?, `aggregate` = ?, programme = ?, track = ?, `status` = ? WHERE index_number = ?";
    $updateStmt = $conn->prepare($updateSql);

    $insertSql = "INSERT INTO ges_admission_list (index_number, `name`, gender, `aggregate`, programme, track, `status`, has_enrolled) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertSql);

    // Start a transaction
    $conn->begin_transaction();

    // Set the batch size
    $batchSize = 200;
    $batchCount = 0;

    for ($row = 3; $row <= $highestRow; $row++) {
        // Read data from the Excel file
        $index_number = $worksheet->getCell('A' . $row)->getValue();

        // if the length of the index number is less than 12, pad it with zeros 
        if (strlen($index_number) < 12) {
            $index_number = str_pad($index_number, 12, "0", STR_PAD_LEFT);
        }


        $name = $worksheet->getCell('B' . $row)->getValue();
        $gender = $worksheet->getCell('C' . $row)->getValue();
        $aggregate = $worksheet->getCell('D' . $row)->getValue();
        $programme = $worksheet->getCell('E' . $row)->getValue();
        $track = $worksheet->getCell('F' . $row)->getValue();
        $status = $worksheet->getCell('G' . $row)->getValue();
        $has_enrolled = 0; // Default value

        // Check if record exists and has_enrolled = 0
        $checkSql = "SELECT * FROM ges_admission_list WHERE index_number = ? AND has_enrolled = 0";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $index_number);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            // Record exists and has_enrolled = 0, update it
            $updateStmt->bind_param("ssissss", $name, $gender, $aggregate, $programme, $track, $status, $index_number);
            $updateStmt->execute();
        } else {
            // Insert new record
            $insertStmt->bind_param("sssisssi", $index_number, $name, $gender, $aggregate, $programme, $track, $status, $has_enrolled);
            $insertStmt->execute();
        }

        $checkStmt->close();

        // Commit the transaction after processing a batch
        $batchCount++;
        if ($batchCount % $batchSize == 0) {
            $conn->commit();
            $conn->begin_transaction();
        }
    }

    // Commit the remaining transaction
    $conn->commit();

    // Close the statements
    $updateStmt->close();
    $insertStmt->close();

    $conn->close();
}
?>
