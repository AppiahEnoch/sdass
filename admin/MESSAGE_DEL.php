<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Check if the id and tb (table) values are set
if (isset($_POST['id']) && isset($_POST['tb'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $table = $conn->real_escape_string($_POST['tb']);

    // Create the query to delete the message
    $query = "DELETE FROM `$table` WHERE `id` = '$id'";

    // Execute the query
    if ($conn->query($query)) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => $conn->error));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "ID or table name missing."));
}

$conn->close();
?>
