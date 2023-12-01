<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Assuming index_number is received from a session or other secure source
$index_number = $_SESSION['index_number']; // Replace with actual session variable or source


$sql = "SELECT code FROM enrollment_code WHERE index_number = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $index_number);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['code' => $row['code']]);
    } else {
        echo json_encode(['code' => null, 'message' => 'No code found for this index number.']);
    }
} else {
    echo json_encode(['code' => null, 'message' => 'Failed to retrieve enrollment code.']);
}

$stmt->close();
$conn->close();
?>
