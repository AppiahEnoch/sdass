<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = ["status" => "error", "message" => "Failed to delete record."];

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM temp_user WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Record deleted successfully!";
    }
}

echo json_encode($response);
?>
