<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

$response = [];

if (!isset($_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'Please login to continue';
    echo json_encode($response);
    exit;
}

$selectedTermId = $_POST['term'];


if (\AE\AE::isEmpty($selectedTermId)) {
    $selectedTermId =  $_SESSION['current_term'];
}

$stmt = $conn->prepare("SELECT * FROM class_bill_view WHERE term = ?");
$stmt->bind_param("s", $selectedTermId);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $records = $result->fetch_all(MYSQLI_ASSOC);
    $response['status'] = 'success';
    $response['records'] = $records;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Failed to fetch records';
}

$stmt->close();

echo json_encode($response);
?>
