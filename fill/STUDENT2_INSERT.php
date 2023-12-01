<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$student_fullname = $_SESSION['full_name'] ?? '';

// Split the full name into an array
$nameParts = explode(' ', trim($student_fullname));

$firstname = $nameParts[0] ?? '';
$lastname = '';
$middleName = '';

// Check how many parts the name has
$partsCount = count($nameParts);

if ($partsCount > 2) {
    // Assume the last part is the last name, the first part is the first name, and the middle parts are the middle name
    $lastname = array_pop($nameParts); // Remove and get the last part
    array_shift($nameParts); // Remove the first part
    $middleName = implode(' ', $nameParts); // Combine the remaining parts as the middle name
} elseif ($partsCount == 2) {
    // Assume the last part is the last name
    $lastname = $nameParts[1];
} 

$aggregate = $_SESSION['aggregate'] ?? '';

$programme = $_SESSION['programme'] ?? '';

$status = $_SESSION['boarding_status'] ?? '';

// Assuming admission_number is in the session or posted from another form
$admissionNumber = $_SESSION['index_number'] ?? '';

// Get form data
$dob = $conn->real_escape_string($_POST['dob'] ?? '');
$placeOfBirth = $conn->real_escape_string($_POST['placeOfbirth'] ?? '');
$hometown = $conn->real_escape_string($_POST['hometown'] ?? '');
$religion = $conn->real_escape_string($_POST['religion'] ?? '');
$denomination = $conn->real_escape_string($_POST['denomination'] ?? '');

// Update student detail in the database
$sqlUpdateStudentDetail = "UPDATE student 
                           SET ";
$bindParams = [];
if (!empty($firstname)) {
    $sqlUpdateStudentDetail .= "first_name = ?, ";
    $bindParams[] = $firstname;
}
if (!empty($middleName)) {
    $sqlUpdateStudentDetail .= "middle_name = ?, ";
    $bindParams[] = $middleName;
}
if (!empty($lastname)) {
    $sqlUpdateStudentDetail .= "last_name = ?, ";
    $bindParams[] = $lastname;
}
if (!empty($dob)) {
    $sqlUpdateStudentDetail .= "date_of_birth = ?, ";
    $bindParams[] = $dob;
}
if (!empty($placeOfBirth)) {
    $sqlUpdateStudentDetail .= "student_residential_address = ?, ";
    $bindParams[] = $placeOfBirth;
}
if (!empty($hometown)) {
    $sqlUpdateStudentDetail .= "home_town = ?, ";
    $bindParams[] = $hometown;
}
if (!empty($religion)) {
    $sqlUpdateStudentDetail .= "religion = ?, ";
    $bindParams[] = $religion;
}
if (!empty($denomination)) {
    $sqlUpdateStudentDetail .= "denomination = ?, ";
    $bindParams[] = $denomination;
}
if (!empty($aggregate)) {
    $sqlUpdateStudentDetail .= "aggregate1 = ?, ";
    $bindParams[] = $aggregate;
}
if (!empty($programme)) {
    $sqlUpdateStudentDetail .= "programme = ?, ";
    $bindParams[] = $programme;
}
if (!empty($status)) {
    $sqlUpdateStudentDetail .= "boarding_status = ?, ";
    $bindParams[] = $status;
}

$sqlUpdateStudentDetail = rtrim($sqlUpdateStudentDetail, ', '); // Remove the trailing comma and space

$sqlUpdateStudentDetail .= " WHERE admission_number = ?";
$bindParams[] = $admissionNumber;

$stmtUpdateStudentDetail = $conn->prepare($sqlUpdateStudentDetail);

if ($stmtUpdateStudentDetail === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for student update: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtUpdateStudentDetail->bind_param(str_repeat('s', count($bindParams)), ...$bindParams);

if ($stmtUpdateStudentDetail->execute()) {
    echo json_encode(['success' => true, 'message' => 'Student details updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update student details: ' . $stmtUpdateStudentDetail->error]);
}

$stmtUpdateStudentDetail->close();
$conn->close();
?>
