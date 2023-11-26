<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;


// Get the data from the AJAX request
$houseId = isset($_POST['house_id']) ? $_POST['house_id'] : '';
$capacityBoys = isset($_POST['capacity_boys']) ? $_POST['capacity_boys'] : '';
$capacityGirls = isset($_POST['capacity_girls']) ? $_POST['capacity_girls'] : '';

// Prepare and bind
$stmt = $conn->prepare("UPDATE student_house SET capacity_boys = ?, capacity_girls = ? WHERE id = ?");
$stmt->bind_param("iii", $capacityBoys, $capacityGirls, $houseId);

// Execute the statement
if ($stmt->execute()) {
    echo "House updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
