<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;



$admissionNumber = $_SESSION['index_number'] ?? '';





// Get form data
$gender = $conn->real_escape_string($_POST['gender'] ?? '');
$nhisNumber = $conn->real_escape_string($_POST['nhis'] ?? '');
$ghanaCardNumber = $conn->real_escape_string($_POST['ghana'] ?? '');

// File handling
$id = "passport" . $admissionNumber;
$passportImage = ae_upload('passport', $id, "../studentpassport/");

$id = "results" . $admissionNumber;
$resultSlipImage = ae_upload('resultslip', $id, '../studentresultslip/');

// SQL Update Statement
$sqlUpdateStudent = "UPDATE student SET gender = ?, nhis_number = ?, ghana_card_number = ?";
$params = [$gender, $nhisNumber, $ghanaCardNumber];
$types = 'sss';

// Append passport image if valid
if ($passportImage) {
    $sqlUpdateStudent .= ", student_passport_image_input = ?";
    $types .= 's';
    $params[] = $passportImage;
}

// Append result slip image if valid
if ($resultSlipImage) {
    $sqlUpdateStudent .= ", previous_school_report = ?";
    $types .= 's';
    $params[] = $resultSlipImage;
}

$sqlUpdateStudent .= " WHERE admission_number = ?";
$types .= 's';
$params[] = $admissionNumber;

$stmtUpdateStudent = $conn->prepare($sqlUpdateStudent);
if ($stmtUpdateStudent === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for student update: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtUpdateStudent->bind_param($types, ...$params);

if ($stmtUpdateStudent->execute()) {
    echo json_encode(['success' => true, 'message' => 'Student details updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update student details: ' . $stmtUpdateStudent->error]);
}

$stmtUpdateStudent->close();
$conn->close();







function ae_upload($input_name, $id, $target_dir = "../upload/") {
    try {
        if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
            // Get the file size
            $file_size = $_FILES[$input_name]['size'];

            // Get the extension of the file
            $file_extension = strtolower(pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION));

            // Check if the file size is within the allowed limits
            if (($file_extension == "jpg" || $file_extension == "jpeg" || $file_extension == "png") && $file_size <= 3 * 1024 * 1024) {
                // Generate a unique ID
                $unique_id = $id;

                // Create a new filename with the unique ID
                $new_filename = $unique_id . '.' . $file_extension;

                // Full path to the new file
                $new_file_path = $target_dir . $new_filename;

                // Move the uploaded file to the new location
                if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $new_file_path)) {
                    // Return the relative path
                    return $new_file_path;
                }
            } elseif ($file_size <= 5 * 1024 * 1024) {
                // Generate a unique ID
                $unique_id = $id;

                // Create a new filename with the unique ID
                $new_filename = $unique_id . '.' . $file_extension;

                // Full path to the new file
                $new_file_path = $target_dir . $new_filename;

                // Move the uploaded file to the new location
                if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $new_file_path)) {
                    // Return the relative path
                    return $new_file_path;
                }
            }
        }
    } catch (Exception $e) {
        // Handle the exception
        return false;
    }

    return false;
}
