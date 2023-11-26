<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $debtId = $conn->real_escape_string($_POST['id']);

    $deleteQuery = "DELETE FROM student_old_debt WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $debtId);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Failed to delete debt record.";
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
