<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Initialize an array to hold the lock status
$lockStatuses = [
  'timetable' => 0,
  'academic_calendar' => 0
];

// Prepare the SQL query to select the lock status for both resources
$query = "SELECT resource_id, lock_status FROM resource_lock WHERE resource_id IN ('timetable', 'academic_calendar')";

// Execute the query
$result = $conn->query($query);

// Check if there are results
if ($result->num_rows > 0) {
  // Fetch the result rows as an associative array
  while($row = $result->fetch_assoc()) {
    // Assign the lock status to the respective resource in the array
    $lockStatuses[$row['resource_id']] = (int)$row['lock_status'];
  }
}

// Close the result set
$result->close();

// Encode the lock statuses array as JSON and output it
echo json_encode($lockStatuses);
?>
