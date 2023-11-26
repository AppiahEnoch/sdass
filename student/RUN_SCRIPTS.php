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

function executeCommand($command) {
    $output = null;
    $retval = null;
    exec($command . ' 2>&1', $output, $retval);
    if ($retval !== 0) {
        throw new Exception("Command execution failed: " . implode("\n", $output));
    }
    return implode("\n", $output);
}

try {
    $command1 = "python DOCX_PDF_admissionForm.py $admission_number";
    $output1 = executeCommand($command1);
    // Echo output if needed
    // echo $output1;
} catch (Exception $e) {
    echo "Error executing admission form script: " . $e->getMessage();
}

try {
    $command2 = "python DOCX_PDF_admissionLetter.py $admission_number";
    $output2 = executeCommand($command2);
    // Echo output if needed
    // echo $output2;
} catch (Exception $e) {
    echo "Error executing admission letter script: " . $e->getMessage();
}

echo $admission_number;
