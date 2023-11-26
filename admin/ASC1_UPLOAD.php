<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['teacher_upload_student_remark_upload_remarks']) && $_FILES['teacher_upload_student_remark_upload_remarks']['error'] == 0) {
    $inputFileName = $_FILES['teacher_upload_student_remark_upload_remarks']['tmp_name'];
    
    // Load the Excel file
    $spreadsheet = IOFactory::load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();

    // Iterate over the rows in the uploaded Excel file
    for ($row = 2; $row <= $highestRow; $row++) {
        $admission_number = $worksheet->getCell('B' . $row)->getValue();
        
        if(empty($admission_number) || is_numeric($admission_number)) {
            continue; // Skip this row if no valid admission number or if it's numeric
        }

        $interest = $worksheet->getCell('D' . $row)->getValue();
        $attitude = $worksheet->getCell('E' . $row)->getValue();
        $comment = $worksheet->getCell('F' . $row)->getValue();
        
        // Update current_interest
        if(!empty($interest) && !is_numeric($interest) && strlen($interest) > 3) {
            // TO LOWER CASE
            $interest = strtolower($interest);
            $sql = "UPDATE current_interest SET interest=? WHERE admission_number=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $interest, $admission_number);
            $stmt->execute();
        }
        
        // Update current_attitude
        if(!empty($attitude) && !is_numeric($attitude) && strlen($attitude) > 3) {
            // TO LOWER CASE
            $attitude = strtolower($attitude);
            $sql = "UPDATE current_attitude SET attitude=? WHERE admission_number=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $attitude, $admission_number);
            $stmt->execute();
        }
        
        // Update current_comment
        if(!empty($comment) && !is_numeric($comment) && strlen($comment) > 3) {
            // TO LOWER CASE
            $comment = strtolower($comment);
            $sql = "UPDATE current_comment SET comment_description=? WHERE admission_number=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $comment, $admission_number);
            $stmt->execute();
        }
    }
}
?>
