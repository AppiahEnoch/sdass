<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

// Initialize response array
$response = [];

// Check for the bill item ID in the request
if (isset($_POST['id'])) {
    $billItemId = $_POST['id'];

    // Prepare the SQL statement for deleting the bill item
    $stmt = $conn->prepare("DELETE FROM bill_item WHERE id = ?");
    $stmt->bind_param("i", $billItemId);

    // Execute and check if the statement was successful
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Bill item deleted successfully';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to delete bill item';
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Bill item ID not provided';
}

// Send JSON response back to the front-end
echo json_encode($response);
?>
