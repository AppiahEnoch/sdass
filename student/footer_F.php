<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$sql = "SELECT * FROM app LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode(["success" => true, "email" => $row["email"], "mobile" => $row["mobile"], "location" => $row["location"]]);
} else {
  echo json_encode(["success" => false]);
}
?>
