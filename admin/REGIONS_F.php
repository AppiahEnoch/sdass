<?php
// REGIONS_F.php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

$sql = "SELECT * FROM regions order by name desc";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'id' => $row['id'],
            'name' => $row['name']
        ];
    }
    echo json_encode($response);
} else {
    echo json_encode($response);
}

$conn->close();
?>
