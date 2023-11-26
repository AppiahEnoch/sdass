<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$response = ['success' => false, 'message' => 'Failed to delete assessments.'];

$userId = $_SESSION['user_id'];
$classId =  $_SESSION['userClass'];

if (isset($_POST['term_year'], $_POST['subject_name'], $_POST['class_name'], $_POST['assessment_name'])) {
    $termYear = $_POST['term_year'];
    $subjectName = $_POST['subject_name'];
    $className = $_POST['class_name'];
    $assessmentName = $_POST['assessment_name'];

    $sql = "DELETE a FROM assessment a
            JOIN subjects subj ON a.subject_id = subj.id
            JOIN school_class sc ON a.class_id = sc.id
            JOIN assessment_type atype ON a.assessment_type_id = atype.id
            WHERE a.user_id = ? AND a.class_id = ? AND a.term_year = ? 
            AND subj.subject_name = ? AND sc.class_name = ? AND atype.assessment_name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiisss', $userId, $classId, $termYear, $subjectName, $className, $assessmentName);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Assessments deleted successfully.';
    } else {
        $response['message'] = 'Error: ' . $conn->error;
    }
}

echo json_encode($response);
?>
