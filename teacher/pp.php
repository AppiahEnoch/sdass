<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$sql = "SELECT * FROM term WHERE current_term = 1";
$stmt = $conn->prepare($sql);

$term_year = '';

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if ($row) {
        $term_year = $row['term_year'];
    }
    $stmt->close();
}

if ($term_year) {
    // Check if term_year exists in student_class
    $sql = "SELECT COUNT(*) as cnt FROM student_class WHERE term_year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $term_year);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    if ($row['cnt'] == 0) {
        // Clone student_current_class and insert into student_class
        $sql = "INSERT INTO student_class (admission_number, school_class_id, term_year)
                SELECT admission_number, class_id, ? FROM student_current_class";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $term_year);
        
        if (!$stmt->execute()) {
            // Handle error
        }
        $stmt->close();
    }
}
?>
