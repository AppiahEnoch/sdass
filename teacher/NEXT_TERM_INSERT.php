<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Clear existing records
$sqlClear = "TRUNCATE TABLE next_term_date";
if ($conn->query($sqlClear) === FALSE) {
  echo json_encode(["success" => false]);
  exit;
}

$user_id = $_SESSION['user_id'];
// Insert new record
$nextTermBeginsDate = $_POST['nextTermBeginsDate'];
// Replace with the actual user ID
$sql = "INSERT INTO next_term_date (user_id, next_term_Date) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $nextTermBeginsDate);

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false]);
}
?>
