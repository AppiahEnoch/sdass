<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $conn->real_escape_string($_POST['message']);
    $messageTitle = $conn->real_escape_string($_POST['messageTitle']);
    $staffId = $conn->real_escape_string($_POST['staffId']);
    $userId = $_SESSION['user_id'] ?? 0; // Assuming session contains user_id

    $query = "INSERT INTO individual_message (user_id, receiver_id, title, message) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("isss", $userId, $staffId, $messageTitle, $message);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
