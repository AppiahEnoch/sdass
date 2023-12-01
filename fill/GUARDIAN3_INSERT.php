<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$indexNumber = $_SESSION['index_number'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $occupation = $_POST['guardian_occupation_select'] ?? '';
    $otherOccupation = $_POST['guardian_occupation_other'] ?? '';

    $parentOccupation = ($occupation === 'other') ? $otherOccupation : $occupation;

    // to puuercase
    $parentOccupation = strtoupper($parentOccupation);

    $sql = "UPDATE parent SET parent_occupation = ? WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $parentOccupation, $indexNumber);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Occupation updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update occupation.']);
    }

    $stmt->close();
}
?>
