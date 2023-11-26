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
$selectSick = $conn->real_escape_string($_POST['selectsick'] ?? '');
$typeOfSickness = $conn->real_escape_string($_POST['typeofsickness'] ?? '');

// Preparing the update statement
$sqlUpdateHealthDetails = "UPDATE student 
                           SET has_health_problem = ?, health_problem_details = ? 
                           WHERE admission_number = ?";
$stmtUpdateHealthDetails = $conn->prepare($sqlUpdateHealthDetails);

if ($stmtUpdateHealthDetails === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for updating health details: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtUpdateHealthDetails->bind_param("sss", $selectSick, $typeOfSickness, $admissionNumber);

if ($stmtUpdateHealthDetails->execute()) {
    echo json_encode(['success' => true, 'message' => 'Health details updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update health details: ' . $stmtUpdateHealthDetails->error]);
}

$stmtUpdateHealthDetails->close();
$conn->close();
?>
