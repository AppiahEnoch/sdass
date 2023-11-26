<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$userClass = $_SESSION['userClass'];
$response = [];

// Ensure the session variable is set
if (!isset($userClass)) {
    echo json_encode(['error' => 'User class not set']);
    exit;
}

// Interests
$query = "SELECT CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS fullName, s.admission_number, ci.`interest`
          FROM `current_interest` ci
          INNER JOIN `student_current_class` scc ON ci.`admission_number` = scc.`admission_number`
          INNER JOIN `student` s ON s.`admission_number` = ci.`admission_number`
          WHERE scc.`class_id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userClass);
$stmt->execute();
$result = $stmt->get_result();
$interests = [];
while ($row = $result->fetch_assoc()) {
    $interests[] = $row;
}
$response['interests'] = $interests;

// Attitudes
$query = "SELECT CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS fullName, s.admission_number, ca.`attitude`
          FROM `current_attitude` ca
          INNER JOIN `student_current_class` scc ON ca.`admission_number` = scc.`admission_number`
          INNER JOIN `student` s ON s.`admission_number` = ca.`admission_number`
          WHERE scc.`class_id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userClass);
$stmt->execute();
$result = $stmt->get_result();
$attitudes = [];
while ($row = $result->fetch_assoc()) {
    $attitudes[] = $row;
}
$response['attitudes'] = $attitudes;

// Remarks
$query = "SELECT CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS fullName, s.admission_number, cc.`comment_description` AS remark
          FROM `current_comment` cc
          INNER JOIN `student_current_class` scc ON cc.`admission_number` = scc.`admission_number`
          INNER JOIN `student` s ON s.`admission_number` = cc.`admission_number`
          WHERE scc.`class_id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $userClass);
$stmt->execute();
$result = $stmt->get_result();
$remarks = [];
while ($row = $result->fetch_assoc()) {
    $remarks[] = $row;
}
$response['remarks'] = $remarks;

echo json_encode($response);
?>
