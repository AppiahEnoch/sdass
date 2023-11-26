<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

if(isset($_POST['admission_number'])) {
    $admission_number = $_POST['admission_number'];

    // Query using INNER JOIN to fetch details from student, parent, mother, and father tables
    $sql = "SELECT student.*, parent.*, mother.*, father.* FROM student 
            INNER JOIN parent ON student.admission_number = parent.admission_number
            INNER JOIN mother ON student.admission_number = mother.admission_number
            INNER JOIN father ON student.admission_number = father.admission_number
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
