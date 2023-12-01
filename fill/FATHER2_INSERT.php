<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$indexNumber = $_SESSION['index_number'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $occupation = $_POST['father_occupation_select'] ?? '';
    $otherOccupation = $_POST['father_occupation_other'] ?? '';
    $father_email = $_POST['father_email'] ?? '';

    $fatherOccupation = ($occupation === 'other') ? $otherOccupation : $occupation;

    // to uppercase
    $fatherOccupation = strtoupper($fatherOccupation);

    $sql = "UPDATE father SET father_occupation = ?, father_email = ? WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $fatherOccupation, $father_email, $indexNumber);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Father\'s occupation and email updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update father\'s occupation and email.']);
    }

    $stmt->close();
}
?>
