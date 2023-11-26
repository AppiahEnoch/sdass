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
$region = $conn->real_escape_string($_POST['region'] ?? '');
$lastSchool = $conn->real_escape_string($_POST['last_school'] ?? '');
$beceYear = $conn->real_escape_string($_POST['bece_year'] ?? '');

// Update student's region, last school, and BECE year
$sqlUpdateStudentRegion = "UPDATE student 
                           SET region = ?, last_school = ?, bece_year = ? 
                           WHERE admission_number = ?";
$stmtUpdateStudentRegion = $conn->prepare($sqlUpdateStudentRegion);

if ($stmtUpdateStudentRegion === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for updating student region: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtUpdateStudentRegion->bind_param("ssis", $region, $lastSchool, $beceYear, $admissionNumber);

if ($stmtUpdateStudentRegion->execute()) {
    echo json_encode(['success' => true, 'message' => 'Region details updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update region details: ' . $stmtUpdateStudentRegion->error]);
}

$stmtUpdateStudentRegion->close();
$conn->close();
?>
