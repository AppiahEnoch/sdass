<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";


$sql = "SELECT * FROM resource_lock WHERE resource_id = 'academic_calendar' AND lock_status = 0 ORDER BY recdate DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Resource is locked
    echo json_encode(["success" => false, "message" => "Resource is locked"]);
    exit;
} else {
    // Resource is not locked
    //echo json_encode(["success" => true, "message" => "Resource is not locked"]);
}


$response = [
    'timetable_url' => '',
    'academic_calendar_url' => ''
];


    $stmt = $conn->prepare("SELECT academic_calendar_url FROM academic_calendar");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
    
            'academic_calendar_url' => $row['academic_calendar_url']
        ];
    }

    $stmt->close();




echo json_encode($response);
?>
