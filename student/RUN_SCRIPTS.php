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


$command1 = "python DOCX_PDF_admissionForm.py $admission_number &";
$command2 = "python DOCX_PDF_admissionLetter.py $admission_number &";

exec($command1);
exec($command2);


echo $admission_number;