<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$id = $_POST['id'];

$sql = "DELETE FROM term WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$response = [];

if ($stmt->execute()) {
    $response["status"] = "success";
} else {
    $response["status"] = "error";
}

$stmt->close();

echo json_encode($response);
?>
