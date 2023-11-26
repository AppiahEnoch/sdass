<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$sql = "SELECT r.id, r.firstname, r.middlename, r.lastname, r.staffid, sc.class_name, r.profile_pic, 
               (SELECT COUNT(scc.admission_number) 
                FROM student_current_class scc 
                WHERE scc.class_id = r.userClass) as student_count,
                l.recdate
        FROM registration r 
        LEFT JOIN school_class sc ON r.userClass = sc.id
        LEFT JOIN log l ON r.staffid = l.user_id
        WHERE r.user_type = 'Teaching Staff'";

$teachers = [];
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['recdate']);
        $row['recdate'] = $date->format('l, jS F, Y g:i a'); // format date
        $teachers[] = $row;
    }
    $stmt->close();
}

echo json_encode($teachers);





