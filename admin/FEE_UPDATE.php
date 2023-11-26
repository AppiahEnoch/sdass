<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$id = $_POST['id'];
$column = $_POST['column'];
$value = $_POST['value'];

$response = [];

$sql = "UPDATE student_payment SET $column = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $value, $id);  // s for string, i for integer. Modify based on your actual column types.

if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Updated successfully';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to update: ' . $stmt->error;
}

$stmt->close();
echo json_encode($response);
?>
