<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

function convertDocxToPdf($admission_number) {
    $filename = "LETTER_" . $admission_number;
    $docxFilePath = "../DOCX_LETTERS/" . $admission_number . ".docx";
 
    $pdfFilePath = "../PDF_LETTERS/" . $filename . ".pdf";

    $phpWord = \PhpOffice\PhpWord\IOFactory::load($docxFilePath);
    $domPdfPath = \PhpOffice\PhpWord\Settings::setPdfRendererPath('../vendor/dompdf/dompdf');
    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord , 'PDF');
    $xmlWriter->save($pdfFilePath);
}


    $admission_number = $_SESSION['index_number'] ?? '';
    convertDocxToPdf($admission_number);
?>
