<?php
session_start();
require_once './vendor/autoload.php';
include "./config/config.php";
include "./config/settings.php";

$mobile = $_POST['mobile'];

// trim
$mobile = trim($mobile);

$query = "SELECT userType FROM temp_user WHERE userMobile = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["userType" => $row['userType']]);
} else {
    echo json_encode(["userType" => null]);
}
?>
