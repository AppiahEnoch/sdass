<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$specific_class_id = $_SESSION['userClass'];

$query = "SELECT s.admission_number, s.first_name, s.middle_name, s.last_name
          FROM student s
          INNER JOIN student_current_class scc ON s.admission_number = scc.admission_number
          WHERE scc.class_id = ?";
          
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $specific_class_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);

// Spreadsheet setup
$spreadsheet = new Spreadsheet();
$activeSheet = $spreadsheet->getActiveSheet();

// Column dimensions
$activeSheet->getColumnDimension('A')->setAutoSize(true);
$activeSheet->getColumnDimension('B')->setAutoSize(true);
$activeSheet->getColumnDimension('C')->setAutoSize(true);
$activeSheet->getColumnDimension('D')->setAutoSize(true);
$activeSheet->getColumnDimension('E')->setAutoSize(true);

$activeSheet->setTitle('Student Records');

// Column headers
$activeSheet->setCellValue('A1', 'Serial Numbers');
$activeSheet->setCellValue('B1', 'Admission Number');
$activeSheet->setCellValue('C1', 'First Name');
$activeSheet->setCellValue('D1', 'Middle Name');
$activeSheet->setCellValue('E1', 'Last Name');
$activeSheet->setCellValue('F1', 'Mark');

// Insert data into the spreadsheet
$row = 2;
$serialNumber = 1;
foreach ($data as $student) {
  $activeSheet->setCellValue("A$row", $serialNumber);
  $activeSheet->setCellValue("B$row", $student['admission_number']);
  $activeSheet->setCellValue("C$row", $student['first_name']);
  $activeSheet->setCellValue("D$row", $student['middle_name']);
  $activeSheet->setCellValue("E$row", $student['last_name']);
  $row++;
  $serialNumber++;
}

// Export Excel File
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('../Excel/class_list.xlsx');
echo 1;
?>
