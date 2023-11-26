<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;



include "FILL_ADMISSION_FORM.php";
include "FILL_ADMISSION_LETTER.php";

$admission_number = $_SESSION['index_number'] ?? '';

try {
    $command1 = "python DOCX_PDF_admissionForm.py $admission_number &";
    exec($command1);
} catch (Exception $e) {
    // Handle the error
    echo "Error executing admission form script: " . $e->getMessage();
}

try {
    $command2 = "python DOCX_PDF_admissionLetter.py $admission_number &";
    exec($command2);
} catch (Exception $e) {
    // Handle the error
    echo "Error executing admission letter script: " . $e->getMessage();
}

echo $admission_number;