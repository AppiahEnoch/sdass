<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Fetching the data sent from the JavaScript function
$changedInterests = json_decode($_POST['changedInterests'], true);
$changedAttitudes = json_decode($_POST['changedAttitudes'], true);
$changedRemarks = json_decode($_POST['changedRemarks'], true);

// Assuming you have a connection object $conn as mentioned in your profile

// Updating Interests
foreach ($changedInterests as $change) {
    $sql = "UPDATE current_interest SET interest = ? WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $change['newValue'], $change['admission_number']);
    $stmt->execute();
}

// Updating Attitudes
foreach ($changedAttitudes as $change) {
    $sql = "UPDATE current_attitude SET attitude = ? WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $change['newValue'], $change['admission_number']);
    $stmt->execute();
}

// Updating Remarks
foreach ($changedRemarks as $change) {
    $sql = "UPDATE current_comment SET comment_description = ? WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $change['newValue'], $change['admission_number']);
    $stmt->execute();
}

// Send a response back
echo json_encode(['success' => true]);
?>
