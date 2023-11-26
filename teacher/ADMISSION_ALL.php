<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if(isset($_POST['admission_number'])) {
    $admission_number = $_POST['admission_number'];

    // Query using INNER JOIN to fetch details from both student and parent tables
    $sql = "SELECT * FROM student 
            INNER JOIN parent ON student.admission_number = parent.admission_number 
            WHERE student.admission_number = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admission_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $combinedData = $result->fetch_assoc();

    echo json_encode($combinedData);

} else {
    echo json_encode(['error' => 'Admission number not provided.']);
}
?>
