<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$updatedData = $_POST['updatedData'];

foreach ($updatedData as $row) {
  $admission_number = $row['admission_number'];
  $mark = $row['mark'];
  $max_mark = $row['max_mark'];

  $sql = "UPDATE student_attendance SET mark = ?, max_mark = ? WHERE admission_number = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iis", $mark, $max_mark, $admission_number);
  $stmt->execute();
}

echo json_encode(["status" => "success"]);
?>
