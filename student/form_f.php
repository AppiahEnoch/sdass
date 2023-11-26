<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;








$admission_number = $_SESSION['admission_number'] ?? '';

$response = [
    'student' => [],
    'current_class' => ''
];

// Student and parents information
$sql = "SELECT s.*, p.*, f.*, m.*
        FROM student s
        LEFT JOIN parent p ON s.admission_number = p.admission_number
        LEFT JOIN father f ON s.admission_number = f.admission_number
        LEFT JOIN mother m ON s.admission_number = m.admission_number
        WHERE s.admission_number = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admission_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $response['student'] = $result->fetch_assoc();
    $stmt->close();

    // Current class information
    $classSql = "SELECT sc.class_name
                FROM student_current_class scc
                JOIN school_class sc ON scc.class_id = sc.id
                WHERE scc.admission_number = ?";

    $stmtClass = $conn->prepare($classSql);
    $stmtClass->bind_param("s", $admission_number);
    $stmtClass->execute();
    $classResult = $stmtClass->get_result();

    if ($classRow = $classResult->fetch_assoc()) {
        $response['current_class'] = $classRow['class_name'];

      


    }

    $stmtClass->close();
} else {
    $response = ["success" => false, "message" => "No data found for admission number: " . $admission_number];
}

if(isset($_SESSION["super_admin_login"]) && $_SESSION["super_admin_login"] == "yes") {
    $response['super_admin_login'] = $_SESSION['supper_admin_id'];
}
if(isset($_SESSION["admin_login"]) && $_SESSION["admin_login"] == "yes") {
    $response['admin_login'] = $_SESSION["admin_login"];
}




echo json_encode($response);


