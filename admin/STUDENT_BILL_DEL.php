<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Get the ID from the AJAX request
$billItemId = $_POST['id'];

// Validate the ID
if (!filter_var($billItemId, FILTER_VALIDATE_INT)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid ID"]);
    exit;
}

// Prepare and execute the delete query
$stmt = $conn->prepare("DELETE FROM class_bill WHERE id = ?");
$stmt->bind_param("i", $billItemId);
$result = $stmt->execute();

// Check if the deletion was successful
if ($result) {
    echo json_encode(["success" => true, "message" => "Bill item deleted successfully"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to delete bill item"]);
}

$stmt->close();
?>
