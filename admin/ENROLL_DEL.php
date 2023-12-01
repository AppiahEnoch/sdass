<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

try {
    // Ensure that the user is authorized to perform this action
    // (You may want to check if the user has the right permissions)

    // Execute delete query
    $sql = "DELETE FROM enrollment_code";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "All records have been deleted."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting records: " . $conn->error]);
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
}
?>
