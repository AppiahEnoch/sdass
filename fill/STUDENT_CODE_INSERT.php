<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Assuming index_number is received from a session or other secure source
$index_number = $_SESSION['index_number']; // Replace with actual session variable or source
$code = $_POST['enrollment_code_input'];



$sql = "INSERT INTO enrollment_code (index_number, code) VALUES (?, ?)
        ON DUPLICATE KEY UPDATE code = VALUES(code)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ss", $index_number, $code);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Enrollment code accepted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update enrollment code.']);
}

$stmt->close();
$conn->close();
?>
