<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
$activeSheet = $spreadsheet->getActiveSheet();

// Column headers
$headers = [
    'Student ID', 'SDASS Admission Number', 'index number', 'First Name', 'Middle Name', 'Last Name', 
    'House', 'Programme', 'Boarding Status', 'Date of Birth', 'Denomination', 'Religion', 'Home Town', 'Region', 
    'BECE Year', 'Last School', 'Aggregate', 'Student Class', 'Ghana Card Number', 'NHIS Number', 
    'Ghana Card Image', 'Birth Certificate', 'Previous School Report', 'Student Passport Image', 'Date of Admission', 
    'Term', 'Has Health Problem', 'Health Problem Details', 'Has Special Needs', 'Special Needs Details', 
    'Child Nationality', 'Student Residential Address', 'Gender', 'Language Spoken', 'Accepted Pledge', 
    'Student Record Date', 'Father First Name', 'Father Middle Name', 'Father Last Name', 'Father Education', 
    'Father Occupation', 'Father Email', 'Father Mobile', 'Father Residential Address', 'Mother First Name', 'Mother Middle Name', 
    'Mother Last Name', 'Mother Education', 'Mother Occupation', 'Mother Mobile', 'Mother Residential Address', 
    'Parent Title', 'Parent First Name', 'Parent Middle Name', 'Parent Last Name', 'Parent Passport Picture', 
    'Parent Ghana Card Number', 'Parent Ghana Card Image', 'Parent Mobile', 'Parent Email', 'Parent Location', 
    'Parent House Address', 'Parent Digital Address', 'Parent Occupation', 'Parent Proof of Residence', 
    'Parent Region', 'Relationship With Child', 'Parent Record Date','code','isVerified','recdate',
];

// Adding headers to sheet
$column = 'A';
foreach ($headers as $header) {
    $activeSheet->setCellValue($column . '1', $header);
    $activeSheet->getColumnDimension($column)->setAutoSize(true);
    $column++;
}

$query = "SELECT sd.*, ec.code, ec.is_verified, ec.recdate 
          FROM studentDetails sd
          JOIN enrollment_code ec ON sd.admission_number = ec.index_number
          WHERE ec.is_verified = 0";

$result = $conn->query($query);

$row = 2; // Start from the second row
if ($result->num_rows > 0) {
    while($data = $result->fetch_assoc()) {
        $col = 'A';
        foreach ($data as $value) {
            $activeSheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }
} else {
    $activeSheet->setCellValue('A2', 'No records found.');
}

// Save the spreadsheet to a file
$writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$filename = 'ENROLL.xlsx';
$writer->save($filename);
echo 1;

$conn->close();
?>
