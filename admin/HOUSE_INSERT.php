<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $house_name = $_POST['house_name'] ?? '';
    $capacity_girls = $_POST['capacity_girls'] ?? 0;
    $capacity_boys = $_POST['capacity_boys'] ?? 0;

    // Prepare SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO student_house (house_name, capacity_girls, capacity_boys) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $house_name, $capacity_girls, $capacity_boys);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
