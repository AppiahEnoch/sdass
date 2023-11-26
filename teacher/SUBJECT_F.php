<?php
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

$sql = "SELECT * FROM subjects ORDER BY id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response[] = [
            'id' => $row['id'],
            'subject_name' => $row['subject_name']
        ];
    }
}

echo json_encode($response);
?>
