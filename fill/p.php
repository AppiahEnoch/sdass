<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;





function generateUniqueID($admissionDate) {
    global $con;
    $year = date("Y", strtotime($admissionDate));
    $only_two_chars = substr($year, -2); 
    $month = date("m", strtotime($admissionDate));
    $prefix = "FH-" . $only_two_chars;

    $only_two_chars = substr($year, -2); 


    // extract year from ad_date and compare with $year in where clause


    $stmt = $con->prepare("SELECT COUNT(*) AS student_count FROM admission__  where year(Adm_Date) = '$year'");
    if (!$stmt->execute()) {
 
        die("Error executing query: " . $con->error);
    }
    $result = $stmt->get_result();
    $countRow = $result->fetch_assoc();
    $studentCount = $countRow['student_count'];
    $formattedCount = str_pad($studentCount + 1, 4, '0', STR_PAD_LEFT);

    // Create the unique ID
    $uniqueID = $prefix . '-' . $formattedCount;

    return $uniqueID;
}


