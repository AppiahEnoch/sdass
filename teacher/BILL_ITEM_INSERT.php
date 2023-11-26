<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$item = $_POST['student_bill_addBillItem'];

$stmt = $conn->prepare("INSERT INTO bill_item (item) VALUES (?)");
$stmt->bind_param("s", $item);
$stmt->execute();
$stmt->close();

