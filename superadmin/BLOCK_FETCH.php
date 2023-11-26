<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";

// Combined user details from student and registration tables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $response = ['success' => false, 'users' => []];

    // Query to get student details
    $studentQuery = "SELECT 
    st.admission_number AS user_id, 
    st.student_passport_image_input as profile_pic,
    CONCAT(st.first_name, ' ', COALESCE(st.middle_name, ''), ' ', st.last_name) AS fullname, 
    'student' AS user_type,
    pt.parent_mobile AS mobile,
    pt.parent_email AS email
 FROM student st
 LEFT JOIN parent pt ON st.admission_number = pt.admission_number";


    // Query to get staff details
    $staffQuery = "SELECT 
                        staffid AS user_id, profile_pic, 
                        CONCAT(firstname, ' ', COALESCE(middlename, ''), ' ', lastname) AS fullname, 
                        user_type,mobile, email
                    FROM registration
                    WHERE staffid IS NOT NULL AND staffid <> ''";

    // Combine queries
    $combinedQuery = "($studentQuery) UNION ($staffQuery) ORDER BY fullname";

    $result = $conn->query($combinedQuery);

    if ($result) {
        $response['users'] = $result->fetch_all(MYSQLI_ASSOC);
        $response['success'] = true;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
