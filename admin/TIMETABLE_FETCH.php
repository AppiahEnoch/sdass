<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$class_id = isset($_POST['class_id']) ? $conn->real_escape_string($_POST['class_id']) : null;

$response = [
    'timetable_url' => '',
    'academic_calendar_url' => ''
];

if ($class_id) {
    $stmt = $conn->prepare("SELECT timetable_url, academic_calendar_url FROM timetable WHERE class_id = ?");
    $stmt->bind_param("s", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            'timetable_url' => $row['timetable_url'],
            'academic_calendar_url' => $row['academic_calendar_url']
        ];
    }

    $stmt->close();
}



echo json_encode($response);
?>
