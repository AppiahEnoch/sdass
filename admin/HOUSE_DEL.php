<?php
session_start();
require_once '../vendor/autoload.php';
include '../config/config.php';
include '../config/settings.php';
include '../config/AE.php';
use AE\AE;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['house_id'])) {
    $houseId = $_POST['house_id'];

    // Assuming $conn is your database connection
    $query = "DELETE FROM student_house WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $houseId); // "i" indicates the parameter is an integer

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting house']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
