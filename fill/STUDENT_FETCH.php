<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$admission_number =  $_SESSION['index_number'];
$data = array();

// Check if parent details are filled
$parentQuery = "SELECT * FROM parent WHERE admission_number = '$admission_number'";
$parentResult = $conn->query($parentQuery);

if ($parentResult->num_rows > 0) {
    $data['parent'] = $parentResult->fetch_assoc();

    // Check if student details are filled
    $studentQuery = "SELECT * FROM student WHERE admission_number = '$admission_number'";
    $studentResult = $conn->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        $data['student'] = $studentResult->fetch_assoc();

        // Check if father details are filled
        $fatherQuery = "SELECT * FROM father WHERE admission_number = '$admission_number'";
        $fatherResult = $conn->query($fatherQuery);

        if ($fatherResult->num_rows > 0) {
            $data['father'] = $fatherResult->fetch_assoc();

            // Check if mother details are filled
            $motherQuery = "SELECT * FROM mother WHERE admission_number = '$admission_number'";
            $motherResult = $conn->query($motherQuery);

            if ($motherResult->num_rows > 0) {
                $data['mother'] = $motherResult->fetch_assoc();
            } else {
                $data['next_step'] = 'mother';
            }
        } else {
            $data['next_step'] = 'father';
        }
    } else {
        $data['next_step'] = 'student';
    }
} else {
    $data['next_step'] = 'parent';
}

echo json_encode($data);
?>
