<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$response = ['success' => false, 'block_status' => 0];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'], $_POST['user_type'])) {
    $userId = $conn->real_escape_string($_POST['user_id']);
    $userType = $conn->real_escape_string($_POST['user_type']);

    $query = "SELECT block_status FROM blocked_user WHERE user_id = ? AND user_type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $userId, $userType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['success'] = true;
        $response['block_status'] = (int) $row['block_status'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
