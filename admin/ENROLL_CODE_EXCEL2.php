<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$activeSheet = $spreadsheet->getActiveSheet();

// Setting column widths
$activeSheet->getColumnDimension('A')->setAutoSize(true);
$activeSheet->getColumnDimension('B')->setAutoSize(true);
$activeSheet->getColumnDimension('C')->setAutoSize(true);
$activeSheet->getColumnDimension('D')->setAutoSize(true);
$activeSheet->getColumnDimension('E')->setAutoSize(true);
$activeSheet->getColumnDimension('F')->setAutoSize(true);

// Setting sheet title
$activeSheet->setTitle('Enrollment Codes');

// Add column headers
$activeSheet->setCellValue('A1', 'Index Number');
$activeSheet->setCellValue('B1', 'Code');
$activeSheet->setCellValue('C1', 'Is Verified');
$activeSheet->setCellValue('D1', 'Full Name');
$activeSheet->setCellValue('E1', 'House');
$activeSheet->setCellValue('F1', 'Date of Admission');

// Fetching data from database
$query = "SELECT ec.index_number, ec.code, ec.is_verified, 
                 CONCAT(s.first_name, ' ', s.middle_name, ' ', s.last_name) AS full_name,
                 s.house, s.recdate
          FROM enrollment_code ec
          JOIN student s ON ec.index_number = s.admission_number
          WHERE ec.is_verified = 1";
$result = $conn->query($query);

$row = 2; // Starting from the second row
if ($result->num_rows > 0) {
    while($data = $result->fetch_assoc()) {
        $activeSheet->setCellValue('A' . $row, $data['index_number']);
        $activeSheet->setCellValue('B' . $row, $data['code']);
        $activeSheet->setCellValue('C' . $row, $data['is_verified']);
        $activeSheet->setCellValue('D' . $row, $data['full_name']);
        $activeSheet->setCellValue('E' . $row, $data['house']);
        $activeSheet->setCellValue('F' . $row, $data['recdate']);
        $row++;
    }
} else {
    // Handle no data case
    $activeSheet->setCellValue('A2', 'No records found.');
}

// Save the spreadsheet to a file
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$writer->save('FULLY_ENROLLED.xlsx');
echo 1;

$conn->close();
?>
