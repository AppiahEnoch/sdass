<?php
require_once './vendor/autoload.php';
include "./config/config.php";
include "./config/settings.php";

$response = [];

$sql = "SELECT id, class_name FROM school_class ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response[] = [
            'id' => $row['id'],
            'class_name' => $row['class_name']
        ];
    }
}

echo json_encode($response);
?>
