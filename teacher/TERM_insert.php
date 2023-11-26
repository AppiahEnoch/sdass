<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$academic_term = $_POST['academic_term'];
$reopening_date = $_POST['reopening_date'];
$vacation_date = $_POST['vacation_date'];

$user_id = $_SESSION['user_id'];



$reopening_year = date('Y', strtotime($reopening_date));

// Get the current year
$current_year = date('Y');

// Initialize a variable to check the format
$invalid_format = false;
$response = [];


// Compare the reopening year to the current year and current year + 1
if ($reopening_year > $current_year) {
    $invalid_format = true;
    $response["status"] = "error";
    $response["message"] = "The reopening year cannot be greater than the current year";
    echo json_encode($response);
    exit;


}







// Insert or update term data
$sql = "INSERT INTO term (academic_term, reopening_date, vacation_date, user_id) VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE academic_term=VALUES(academic_term), reopening_date=VALUES(reopening_date), vacation_date=VALUES(vacation_date), user_id=VALUES(user_id)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $academic_term, $reopening_date, $vacation_date, $user_id);

$response = [];

if ($stmt->execute()) {
    $new_id = $stmt->insert_id;  // Get the ID of the inserted/updated record
    $stmt->close();
    
    // Call the update_current_term stored procedure
    $sql = "CALL update_current_term(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $new_id);
    
    if ($stmt->execute()) {
        $response["status"] = "success";
    } else {
        $response["status"] = "error";
    }
    $stmt->close();
    
} else {
    $response["status"] = "error";
}

echo json_encode($response);
?>
