<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;



$indexNumber = $_SESSION['index_number'] ?? '';
$firstName = $conn->real_escape_string($_POST['first_name'] ?? '');
$middleName = $conn->real_escape_string($_POST['middle_name'] ?? '');
$lastName = $conn->real_escape_string($_POST['last_name'] ?? '');
$title = $conn->real_escape_string($_POST['title'] ?? '');
$student_class = "1";

// Insert or update student record
$sqlStudent = "INSERT INTO student (admission_number, first_name, middle_name, last_name, student_class) 
               VALUES (?, ?, ?, ?, ?) 
               ON DUPLICATE KEY UPDATE 
               first_name = ?, middle_name = ?, last_name = ?, student_class = ?";
$stmtStudent = $conn->prepare($sqlStudent);

if ($stmtStudent === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for student: ' . $conn->error]);
    $conn->close();
    exit;
}

// Notice there are 9 parameters now to match the 9 placeholders
$stmtStudent->bind_param("sssssssss", $indexNumber, $firstName, $middleName, $lastName, $student_class, $firstName, $middleName, $lastName, $student_class);

if (!$stmtStudent->execute()) {
    echo json_encode(['success' => false, 'message' => 'Failed to save student information: ' . $stmtStudent->error]);
    $stmtStudent->close();
    $conn->close();
    exit;
}

$stmtStudent->close();











// Insert or update parent record
$sqlParent = "INSERT INTO parent (admission_number, title, parent_first_name, parent_middle_name, parent_last_name) 
              VALUES (?, ?, ?, ?, ?) 
              ON DUPLICATE KEY UPDATE 
              title = ?, parent_first_name = ?, parent_middle_name = ?, parent_last_name = ?";
$stmtParent = $conn->prepare($sqlParent);

if ($stmtParent === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for parent: ' . $conn->error]);
    $conn->close();
    exit;
}

// Bind parameters and execute
// There should be 9 parameters in total (5 for the INSERT part, and 4 for the ON DUPLICATE KEY UPDATE part)
$stmtParent->bind_param("sssssssss", $indexNumber, $title, $firstName, $middleName, $lastName, $title, $firstName, $middleName, $lastName);

if ($stmtParent->execute()) {
    echo json_encode(['success' => true, 'message' => 'Guardian information saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save guardian information: ' . $stmtParent->error]);
}

$stmtParent->close();
$conn->close();


