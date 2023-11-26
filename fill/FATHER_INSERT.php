<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Assuming admission_number is in the session or posted from another form
$admissionNumber = $_SESSION['index_number'] ?? '';

// Get form data
$fatherFirstName = $conn->real_escape_string($_POST['fatherFirstName'] ?? '');
$fatherMiddleName = $conn->real_escape_string($_POST['fatherMiddleName'] ?? '');
$fatherLastName = $conn->real_escape_string($_POST['fatherLastName'] ?? '');
$fatherMobile = $conn->real_escape_string($_POST['fatherMobile'] ?? '');

// Check if admission number exists
$sqlCheckAdmissionNumber = "SELECT admission_number FROM father WHERE admission_number = ?";
$stmtCheckAdmissionNumber = $conn->prepare($sqlCheckAdmissionNumber);
$stmtCheckAdmissionNumber->bind_param("s", $admissionNumber);
$stmtCheckAdmissionNumber->execute();
$stmtCheckAdmissionNumber->store_result();

if ($stmtCheckAdmissionNumber->num_rows > 0) {
    // Admission number exists, update father's details
    $sqlUpdateFatherDetails = "UPDATE father 
                               SET father_first_name = ?, father_middle_name = ?, father_last_name = ?, father_mobile = ? 
                               WHERE admission_number = ?";
    $stmtUpdateFatherDetails = $conn->prepare($sqlUpdateFatherDetails);

    if ($stmtUpdateFatherDetails === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for updating father details: ' . $conn->error]);
        $conn->close();
        exit;
    }

    $stmtUpdateFatherDetails->bind_param("sssss", $fatherFirstName, $fatherMiddleName, $fatherLastName, $fatherMobile, $admissionNumber);

    if ($stmtUpdateFatherDetails->execute()) {
        echo json_encode(['success' => true, 'message' => 'Father\'s details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update father\'s details: ' . $stmtUpdateFatherDetails->error]);
    }

    $stmtUpdateFatherDetails->close();
} else {
    // Admission number does not exist, insert father's details
    $sqlInsertFatherDetails = "INSERT INTO father (admission_number, father_first_name, father_middle_name, father_last_name, father_mobile) 
                               VALUES (?, ?, ?, ?, ?)";
    $stmtInsertFatherDetails = $conn->prepare($sqlInsertFatherDetails);

    if ($stmtInsertFatherDetails === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for inserting father details: ' . $conn->error]);
        $conn->close();
        exit;
    }

    $stmtInsertFatherDetails->bind_param("sssss", $admissionNumber, $fatherFirstName, $fatherMiddleName, $fatherLastName, $fatherMobile);

    if ($stmtInsertFatherDetails->execute()) {
        echo json_encode(['success' => true, 'message' => 'Father\'s details inserted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert father\'s details: ' . $stmtInsertFatherDetails->error]);
    }

    $stmtInsertFatherDetails->close();
}

$stmtCheckAdmissionNumber->close();
$conn->close();
?>
