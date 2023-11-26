<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";

// Get student details from the student table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $response = ['success' => false, 'students' => []];

    $query = "SELECT 
                admission_number, 
                CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS fullname 
              FROM student 
              ORDER BY fullname";

    $result = $conn->query($query);

    if ($result) {
        $response['students'] = $result->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
