<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$userId = $_SESSION['user_id'];
$classId =  $_SESSION['userClass'];
$termYear =  $_SESSION['current_term'];


// $userId = 27;
// $classId = 5;
// $termYear = "Second Term 2023/2024";

//echo "UserID: $userId, ClassID: $classId, TermYear: $termYear";



$sql = "SELECT 
            a.id, 
            a.admission_number, 
            CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS full_name, 
            subj.subject_name, 
            sc.class_name,
            atype.assessment_name,
            a.term_year, 
            a.mark 
        FROM assessment a 
        JOIN student s ON a.admission_number = s.admission_number 
        JOIN subjects subj ON a.subject_id = subj.id
        JOIN school_class sc ON a.class_id = sc.id
        JOIN assessment_type atype ON a.assessment_type_id = atype.id
        WHERE a.user_id = ? AND a.class_id = ? AND a.term_year = ? order by a.id desc";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param('iis', $userId, $classId, $termYear); 
$stmt->execute();
$result = $stmt->get_result();
$rawData = $result->fetch_all(MYSQLI_ASSOC);




$groupedData = [];

foreach ($rawData as $row) {
    $key = $row['term_year'] . '_' . $row['subject_name'] . '_' . $row['class_name'] . '_' . $row['assessment_name'];
    if (!isset($groupedData[$key])) {
        $groupedData[$key] = [
            'term_year' => $row['term_year'],
            'subject_name' => $row['subject_name'],
            'class_name' => $row['class_name'],
            'assessment_name' => $row['assessment_name'],
            'students' => []
        ];
    }
    $groupedData[$key]['students'][] = [
        'id' => $row['id'],
        'admission_number' => $row['admission_number'],
        'full_name' => $row['full_name'],
        'mark' => $row['mark']
    ];
}

echo json_encode(array_values($groupedData));
?>

