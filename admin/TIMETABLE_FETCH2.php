<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";


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
