<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;




// Prepare the SQL query
$sql = "SELECT id, index_number, name, gender, aggregate, programme, track, status, has_enrolled, recdate FROM ges_admission_list";
$result = $conn->query($sql);

$gesList = [];

// Check if the query was successful and has rows
if ($result && $result->num_rows > 0) {
    // Fetch all records as an associative array
    while ($row = $result->fetch_assoc()) {
        $gesList[] = $row;
    }

    // Output the data in JSON format
    echo json_encode(['success' => true, 'gesList' => $gesList]);
} else {
    echo json_encode(['success' => false, 'message' => 'No records found']);
}

// Close the database connection
$conn->close();
?>
