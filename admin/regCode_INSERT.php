<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

if (isset($_POST['userMobile']) && isset($_POST['userType'])) {
    $userMobile = $_POST['userMobile'];
    $userType = $_POST['userType'];

    $stmt = $conn->prepare("INSERT INTO temp_user (userMobile, userType) VALUES (?, ?)");
    $stmt->bind_param("ss", $userMobile, $userType);

    if ($stmt->execute()) {
        echo 1;
    } else {
        echo 0;
    }
}
?>
