<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$indexNumber = $_SESSION['index_number'] ?? '';
$response = ['success' => false, 'fullname' => '', 'index_number' => ''];

if ($indexNumber) {
    // Check in ges_admission_list table
    $sqlGes = "SELECT name FROM ges_admission_list WHERE index_number = ?";
    $stmtGes = $conn->prepare($sqlGes);
    $stmtGes->bind_param("s", $indexNumber);
    $stmtGes->execute();
    $resultGes = $stmtGes->get_result();

    if ($rowGes = $resultGes->fetch_assoc()) {
        $response = ['success' => true, 'fullname' => $rowGes['name'], 'index_number' => $indexNumber];
    } else {
        $stmtGes->close(); // Close the first statement before opening a new one

        // Check in student table if no record found in ges_admission_list
        $sqlStudent = "SELECT first_name, middle_name, last_name FROM student WHERE admission_number = ?";
        $stmtStudent = $conn->prepare($sqlStudent);
        if ($stmtStudent) {
            $stmtStudent->bind_param("s", $indexNumber);
            $stmtStudent->execute();
            $resultStudent = $stmtStudent->get_result();

            if ($rowStudent = $resultStudent->fetch_assoc()) {
                $fullName = $rowStudent['first_name'] . ' ' . ($rowStudent['middle_name'] ? $rowStudent['middle_name'] . ' ' : '') . $rowStudent['last_name'];
                $response = ['success' => true, 'fullname' => $fullName, 'index_number' => $indexNumber];
            }
            $stmtStudent->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for student: ' . $conn->error]);
            $conn->close();
            exit;
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Index number not provided']);
}

$conn->close();
echo json_encode($response);
?>
