<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'], $_POST['userType'])) {
    $userId = $conn->real_escape_string($_POST['userId']);
    $userType = $conn->real_escape_string($_POST['userType']);

    // Check if the user already exists in the blocked_user table
    $query = "SELECT id, block_status FROM blocked_user WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists, toggle their block status
        $row = $result->fetch_assoc();
        $newStatus = $row['block_status'] == 1 ? 0 : 1; // Toggle status

        $updateQuery = "UPDATE blocked_user SET block_status = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("is", $newStatus, $userId);
        $updateStmt->execute();

        if ($newStatus == 1) {
            echo "User blocked successfully.";
        } else {
            echo "User unblocked successfully.";
        }
    } else {
        // User does not exist, insert a new record with block_status set to 1 (blocked)
        $insertQuery = "INSERT INTO blocked_user (user_id, user_type, block_status) VALUES (?, ?, 1)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("ss", $userId, $userType);
        $insertStmt->execute();

        if ($insertStmt->affected_rows > 0) {
            echo "User blocked successfully.";
        } else {
            echo "Failed to block user.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
