<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkboxes']) && isset($_SESSION['admission_record'])) {
    $checkboxes = $_POST['checkboxes'];
    $records = $_SESSION['admission_record'];

    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $activeSheet = $spreadsheet->getActiveSheet();

    // Modified function to get column name that handles columns beyond 'Z'
    function getColumnName($index) {
        $columnName = '';
        while ($index > 0) {
            $modulo = ($index - 1) % 26;
            $columnName = chr(65 + $modulo) . $columnName;
            $index = (int)(($index - $modulo) / 26);
        }
        return $columnName;
    }

    // Set auto size for columns based on number of selected checkboxes
    foreach ($checkboxes as $index => $checkbox) {
        $columnID = getColumnName($index + 1); // Adjust index for Excel columns
        $activeSheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $activeSheet->setTitle('records');

    // Add the column headers to the sheet
    $columnIndex = 1;
    foreach ($checkboxes as $header) {
        // Replace 'parent' with 'guardian' in the header
        $formattedHeader = str_replace('parent', 'guardian', $header);
    
        // Check and modify specific column names
        if ($formattedHeader === 'sdass_admission_number') {
            $formattedHeader = 'admission_number';
        } else if ($formattedHeader === 'admission_number') {
            $formattedHeader = 'BECE_index_number';
        }
    
        // Set the cell value with the modified header
        $activeSheet->setCellValue(getColumnName($columnIndex) . '1', strtoupper(str_replace('_', ' ', $formattedHeader)));
        $columnIndex++;
    }
    
    

    // Add data to the sheet
    $rowNumber = 2;
    foreach ($records as $row) {
        $columnIndex = 1;
        foreach ($checkboxes as $header) {
            if (isset($row[$header])) {
                $activeSheet->setCellValue(getColumnName($columnIndex) . $rowNumber, $row[$header]);
            }
            $columnIndex++;
        }
        $rowNumber++;
    }

    // Write to an Excel file
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $fileName = "admission_list.xlsx";
    $writer->save($fileName);
    echo $fileName;
}
?>
