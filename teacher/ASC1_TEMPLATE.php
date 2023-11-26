<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);
$activeSheet = $spreadsheet->getActiveSheet();
$activeSheet->getColumnDimension('A')->setAutoSize(true);
$activeSheet->getColumnDimension('B')->setAutoSize(true);
$activeSheet->getColumnDimension('C')->setAutoSize(true);
$activeSheet->getColumnDimension('D')->setAutoSize(true);
$activeSheet->getColumnDimension('E')->setAutoSize(true);
$activeSheet->getColumnDimension('F')->setAutoSize(true);

// Set header titles
$activeSheet->setCellValue('A1', 'Serial Number');
$activeSheet->setCellValue('B1', 'Admission Number');
$activeSheet->setCellValue('C1', 'Student Full Name');
$activeSheet->setCellValue('D1', 'Interest');
$activeSheet->setCellValue('E1', 'Attitude');
$activeSheet->setCellValue('F1', 'Comments');

$currentClassId = $_SESSION['userClass'];

// SQL to fetch students of a specific class and their related details
$sql = "
SELECT 
    students.admission_number, 
    CONCAT(students.first_name, ' ', IFNULL(students.middle_name, ''), ' ', students.last_name) AS full_name,
    GROUP_CONCAT(DISTINCT current_interest.interest) as interest_description,
    GROUP_CONCAT(DISTINCT current_attitude.attitude) as attitude_description,
    GROUP_CONCAT(DISTINCT current_comment.comment_description) as comments,
    COALESCE(GROUP_CONCAT(DISTINCT ht_comment.comment_description), 'More room for improvement') as headteacher_comment
FROM 
    student AS students
JOIN student_current_class AS scc ON students.admission_number = scc.admission_number AND scc.class_id = ?
LEFT JOIN current_interest ON students.admission_number = current_interest.admission_number
LEFT JOIN current_attitude ON students.admission_number = current_attitude.admission_number
LEFT JOIN current_comment ON students.admission_number = current_comment.admission_number
LEFT JOIN current_headteacher_comment as ht_comment ON students.admission_number = ht_comment.admission_number AND current_interest.term_year = ht_comment.term_year
GROUP BY 
    students.admission_number;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentClassId);
$stmt->execute();
$result = $stmt->get_result();

$rowNumber = 2; // start from the second row
$serialNumber = 1;

while ($row = $result->fetch_assoc()) {
    $activeSheet->setCellValue('A' . $rowNumber, $serialNumber);
    $activeSheet->setCellValue('B' . $rowNumber, $row['admission_number']);
    $activeSheet->setCellValue('C' . $rowNumber, $row['full_name']);
    $activeSheet->setCellValue('D' . $rowNumber, $row['interest_description']);
    $activeSheet->setCellValue('E' . $rowNumber, $row['attitude_description']);
    $activeSheet->setCellValue('F' . $rowNumber, $row['comments']);
    $rowNumber++;
    $serialNumber++;
}

// Save the spreadsheet as an Excel file
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('../Excel/teacher_remark.xlsx');
echo 1;
?>
