<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
//$_SESSION['userClass']=1;

$class_id = $_SESSION['userClass'];  // Assuming the class ID is stored in a session variable named 'specific_class_id'
//echo "r:". $class_id;

$sql = "SELECT s.first_name, s.middle_name, s.last_name, s.admission_number, s.student_passport_image_input 
        FROM student AS s
        JOIN student_current_class AS scc ON s.admission_number = scc.admission_number
        WHERE scc.class_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

$students = array();

while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

echo json_encode($students);
