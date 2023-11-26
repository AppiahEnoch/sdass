<?php
// ADMISSION_RECORD_FETCH.php

session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : null;
$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : date('Y-m-d');
$term = isset($_POST['term']) ? $_POST['term'] : null;
$class = isset($_POST['class']) ? $_POST['class'] : null;

$sql = "SELECT admission_number, CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS full_name, date_of_admission FROM student WHERE 1";

$params = [];
$types = "";

if ($fromDate) {
    $sql .= " AND date_of_admission >= ?";
    $params[] = $fromDate;
    $types .= "s";
}

if ($toDate) {
    $sql .= " AND date_of_admission <= ?";
    $params[] = $toDate;
    $types .= "s";
}

if ($term) {
    $sql .= " AND term = ?";
    $params[] = $term;
    $types .= "s";
}

if ($class) {
    $sql .= " AND student_class = ?";
    $params[] = $class;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$admission_numbers = [];
$records = [];
while ($row = $result->fetch_assoc()) {
    $row['date_of_admission'] = AE::aeDate2($row['date_of_admission']);
    $records[] = $row;
    $admission_numbers[] = $row['admission_number'];
}

$_SESSION['admission_list'] = $admission_numbers;

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'records' => $records]);
?>
