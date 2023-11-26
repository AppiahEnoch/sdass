<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$studentsData = [];

$sql = "SELECT admission_number, first_name, middle_name, last_name FROM student ORDER BY admission_number ASC";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    $studentsData[] = [
        'admission_number' => $row['admission_number'],
        'first_name' => $row['first_name'],
        'middle_name' => $row['middle_name'],
        'last_name' => $row['last_name']
    ];
}

echo json_encode($studentsData);

