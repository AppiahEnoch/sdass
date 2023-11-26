<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Get additional variables for parent
$location = $conn->real_escape_string($_POST['location'] ?? '');
$email = $conn->real_escape_string($_POST['email'] ?? '');
$mobile = $conn->real_escape_string($_POST['mobile'] ?? '');
$postalAddress = $conn->real_escape_string($_POST['postaladdress'] ?? '');
$digitalAddress = $conn->real_escape_string($_POST['digitaladdress'] ?? '');

$indexNumber = $_SESSION['index_number'] ?? '';

// Update parent record
$sqlParent = "UPDATE parent SET 
              parent_mobile = ?, parent_email = ?, parent_location = ?, parent_house_address = ?, parent_digital_address = ?
              WHERE admission_number = ?";
$stmtParent = $conn->prepare($sqlParent);

if ($stmtParent === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for parent: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtParent->bind_param("ssssss", $mobile, $email, $location, $postalAddress, $digitalAddress, $indexNumber);

if ($stmtParent->execute()) {
    echo json_encode(['success' => true, 'message' => 'Parent information updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update parent information: ' . $stmtParent->error]);
}

$stmtParent->close();
$conn->close();
?>
