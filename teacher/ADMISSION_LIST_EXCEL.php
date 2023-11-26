<?php
// ADMISSION_RECORD_LIST_EXCEL.php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// Check if AE class exists and autoload is properly configured
if (!class_exists('AE\AE')) {
    die('AE class not found. Please check your autoload configuration.');
}

$ae = new AE\AE();

// Instantiate Spreadsheet
$spreadsheet = new Spreadsheet();
/** @var Worksheet $sheet */
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator('Your Name')
    ->setLastModifiedBy('Your Name')
    ->setTitle('Admission List')
    ->setSubject('Admission List')
    ->setDescription('Admission list export.');

// Add header
$sheet->setCellValue('A1', 'Admission Number');
$sheet->setCellValue('B1', 'Full Name');
$sheet->setCellValue('C1', 'Admission Date');

// Auto resize columns
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);

if (isset($_SESSION['admission_list'])) {
    $admissionNumbers = $_SESSION['admission_list'];
    $placeholders = implode(',', array_fill(0, count($admissionNumbers), '?'));

    $sql = "SELECT admission_number, 
                   CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS full_name, 
                   date_of_admission 
            FROM student 
            WHERE admission_number IN ($placeholders)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($admissionNumbers)), ...$admissionNumbers);
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through each record and add to the spreadsheet
    $rowNumber = 2; // Start from the second row
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['admission_number']);
        $sheet->setCellValue('B' . $rowNumber, $row['full_name']);
        $sheet->setCellValue('C' . $rowNumber, $ae->aeDate2($row['date_of_admission']));
        $rowNumber++;
    }
}

// Define the file name
$fileName = 'admission_list.xlsx';
$filePath = '../Excel/' . $fileName; // Specify the path where you want to save the file

// Create writer and save to the specified path
$writer = new Xlsx($spreadsheet);
$writer->save($filePath);

echo $filePath;
?>
