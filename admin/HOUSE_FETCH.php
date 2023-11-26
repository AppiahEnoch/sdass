<?php
session_start();
require_once '../vendor/autoload.php';
include '../config/config.php';
include '../config/settings.php';
include '../config/AE.php';
use AE\AE;

// Assuming $conn is your database connection
$query = "SELECT * FROM student_house";
$stmt = $conn->prepare($query);
$stmt->execute();

$houses = array();
$result = $stmt->get_result();
while($row = $result->fetch_assoc()) {
    $houses[] = $row;
}

echo json_encode($houses);
?>
