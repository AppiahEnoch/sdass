<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;


$sql = "TRUNCATE TABLE sdass_admission_number";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'All records have been deleted and auto-increment reset']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error in truncating table: ' . $conn->error]);
}

$conn->close();
?>
