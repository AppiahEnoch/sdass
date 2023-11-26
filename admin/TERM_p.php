<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

// SQL query to select current term
$sql_term = "SELECT term_year FROM term WHERE current_term = 1";
$result_term = $conn->query($sql_term);

if ($result_term->num_rows > 0) {
    $row_term = $result_term->fetch_assoc();
    $current_term_year = $row_term['term_year'];

    // Remove the "Second Term " part from the term_year
    $filtered_term_year = substr($current_term_year, strrpos($current_term_year, " ") + 1);

    // SQL query to check if the filtered_term_year is already in the student_class table
    $sql_student_class = "SELECT term_year FROM student_class WHERE term_year LIKE ?";
    $stmt = $conn->prepare($sql_student_class);
    $like_term_year = '%' . $filtered_term_year;
    $stmt->bind_param("s", $like_term_year);
    $stmt->execute();
    $result_student_class = $stmt->get_result();

    if ($result_student_class->num_rows > 0) {
        echo "0";
    } else {
        echo "1";

        $sql = "INSERT INTO student_class (admission_number, school_class_id, term_year)
                SELECT admission_number, class_id, ? FROM student_current_class";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $current_term_year);
        if (!$stmt->execute()) {
            // Handle error
        }

        // Update class_id in student_current_class by plus 1
        $sql_update = "UPDATE student_current_class SET class_id = class_id + 1";
        $stmt_update = $conn->prepare($sql_update);

        if (!$stmt_update->execute()) {
            // Handle error
        }

  
        $stmt->close();
    }
}
