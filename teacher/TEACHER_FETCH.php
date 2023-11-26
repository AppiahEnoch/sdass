<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Get teaching staff from the registration table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   // Improved PHP code to get teaching staff and students from the registration table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $response = ['success' => false, 'users' => []];

    // Combining two queries into one using UNION to improve performance
    $query = "
        (SELECT id, staffid AS user_id, 'teaching' AS user_type, CONCAT(firstname, ' ', lastname) AS fullname FROM registration)
        UNION
        (SELECT id, admission_number AS user_id, 'student' AS user_type, CONCAT(first_name, ' ', last_name) AS fullname FROM student)
        ORDER BY fullname
    ";

    $result = $conn->query($query);

    if ($result) {
        $response['users'] = $result->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}



}
?>
