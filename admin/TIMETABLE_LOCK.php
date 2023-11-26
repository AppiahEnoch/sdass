<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$resource_id = $_POST['resource_id'] ?? '';
$lock_status = $_POST['lock_status'] ?? '';

$response = ['success' => false];

if ($resource_id !== '' && ($lock_status === '0' || $lock_status === '1')) {
    $lock_status = (int)$lock_status;
    
    // Check if the resource already exists
    $stmt_select = $conn->prepare("SELECT id FROM resource_lock WHERE resource_id = ?");
    $stmt_select->bind_param("s", $resource_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $stmt_select->close();

    if ($result->num_rows === 0) {
        // Insert new resource lock status
        $stmt_insert = $conn->prepare("INSERT INTO resource_lock (resource_id, lock_status) VALUES (?, ?)");
        $stmt_insert->bind_param("si", $resource_id, $lock_status);
    } else {
        // Update existing resource lock status
        $stmt_insert = $conn->prepare("UPDATE resource_lock SET lock_status = ? WHERE resource_id = ?");
        $stmt_insert->bind_param("is", $lock_status, $resource_id);
    }
    
    if ($stmt_insert->execute()) {
        $response['success'] = true;
    }
    $stmt_insert->close();
}

echo json_encode($response);
?>
