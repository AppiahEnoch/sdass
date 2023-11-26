<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;


// Prepare the query
$sql = "SELECT * FROM student";
$filters = [];
$params = [];

if (isset($_POST['fromDate']) && $_POST['fromDate']) {
    $filters[] = "recdate >= ?";
    $params[] = $_POST['fromDate'];
}
if (isset($_POST['toDate']) && $_POST['toDate']) {
    $filters[] = "recdate <= ?";
    $params[] = $_POST['toDate'];
}
if (isset($_POST['status']) && $_POST['status']) {
    $filters[] = "boarding_status = ?";
    $params[] = $_POST['status'];
}
if (isset($_POST['programme']) && $_POST['programme']) {
    $filters[] = "programme = ?";
    $params[] = $_POST['programme'];
}
if (isset($_POST['gender']) && $_POST['gender']) {
    $filters[] = "gender = ?";
    $params[] = $_POST['gender'];
}
if (isset($_POST['house']) && $_POST['house']) {
    $filters[] = "house = ?";
    $params[] = $_POST['house'];
}
if (isset($_POST['religion']) && $_POST['religion']) {
    $filters[] = "religion = ?";
    $params[] = $_POST['religion'];
}
if (isset($_POST['healthIssue']) && $_POST['healthIssue']) {
    $filters[] = "has_health_problem = ?";
    $params[] = $_POST['healthIssue'];
}
if (isset($_POST['admission_number']) && $_POST['admission_number']) {
    $filters[] = "admission_number LIKE ?";
    $params[] = "%" . $_POST['admission_number'] . "%";
}
if (isset($_POST['denomination']) && $_POST['denomination']) {
    $filters[] = "denomination = ?";
    $params[] = $_POST['denomination'];
}

if (count($filters) > 0) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error in query: " . $conn->error);
}

// Bind parameters
foreach ($params as $index => $param) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    break; // Break after binding all parameters
}

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

// save data to session
$_SESSION['admission_record'] = $data;


// Extract admission numbers from session
$admissionNumbers = array_column($_SESSION['admission_record'], 'admission_number');

// Create placeholders for the IN clause
$placeholders = implode(',', array_fill(0, count($admissionNumbers), '?'));

// SQL Query
$sql = "SELECT s.*, f.*, m.*, p.*
        FROM student s
        LEFT JOIN father f ON s.admission_number = f.admission_number
        LEFT JOIN mother m ON s.admission_number = m.admission_number
        LEFT JOIN parent p ON s.admission_number = p.admission_number
        WHERE s.admission_number IN ($placeholders)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error in query: " . $conn->error);
}

// Bind parameters
$stmt->bind_param(str_repeat('s', count($admissionNumbers)), ...$admissionNumbers);

$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);


// Save data to session
$_SESSION['admission_record'] = $data;



$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
