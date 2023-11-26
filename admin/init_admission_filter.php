<?php
session_start();
require_once '../vendor/autoload.php';
include '../config/config.php';
include '../config/settings.php';
include '../config/AE.php';
use AE\AE;

// Assuming $conn is your database connection
$data = array();

// Fetch unique denominations
$query = "SELECT DISTINCT denomination FROM student WHERE denomination IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$denominations = [];
while($row = $result->fetch_assoc()) {
    $denominations[] = $row['denomination'];
}
$data['denominations'] = $denominations;

// Fetch unique houses
$query = "SELECT DISTINCT house FROM student WHERE house IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$houses = [];
while($row = $result->fetch_assoc()) {
    $houses[] = $row['house'];
}
$data['houses'] = $houses;

// Fetch unique programmes
$query = "SELECT DISTINCT programme FROM student WHERE programme IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$programmes = [];
while($row = $result->fetch_assoc()) {
    $programmes[] = $row['programme'];
}
$data['programmes'] = $programmes;

// Fetch unique religions
$query = "SELECT DISTINCT religion FROM student WHERE religion IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$religions = [];
while($row = $result->fetch_assoc()) {
    $religions[] = $row['religion'];
}
$data['religions'] = $religions;

// Fetch unique boarding statuses
$query = "SELECT DISTINCT boarding_status FROM student WHERE boarding_status IS NOT NULL";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$boardingStatuses = [];
while($row = $result->fetch_assoc()) {
    $boardingStatuses[] = $row['boarding_status'];
}
$data['boarding_statuses'] = $boardingStatuses;

echo json_encode($data);
?>
