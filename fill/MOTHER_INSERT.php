<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$admissionNumber = $_SESSION['index_number'] ?? '';

$motherFirstName = $conn->real_escape_string($_POST['motherFirstName'] ?? '');
$motherMiddleName = $conn->real_escape_string($_POST['motherMiddleName'] ?? '');
$motherLastName = $conn->real_escape_string($_POST['motherLastName'] ?? '');
$motherMobile = $conn->real_escape_string($_POST['motherMobile'] ?? '');

$sql = "INSERT INTO mother (admission_number, mother_first_name, mother_middle_name, mother_last_name, mother_mobile)
        VALUES (?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE 
            mother_first_name = VALUES(mother_first_name), 
            mother_middle_name = VALUES(mother_middle_name), 
            mother_last_name = VALUES(mother_last_name), 
            mother_mobile = VALUES(mother_mobile)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("sssss", $admissionNumber, $motherFirstName, $motherMiddleName, $motherLastName, $motherMobile);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Mother\'s details saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save mother\'s details: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
