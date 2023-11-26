<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$sql = "SELECT id, item FROM bill_item ORDER BY recdate DESC";
$result = $conn->query($sql);

$billItems = [];

while($row = $result->fetch_assoc()) {
    $billItems[] = $row;
}

echo json_encode($billItems);
