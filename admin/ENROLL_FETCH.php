<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

try {
    $currentYear = date('Y');

    // Query to count the total number of verified students added this year
    $sqlVerified = "SELECT COUNT(*) AS total_verified FROM student WHERE YEAR(recdate) = ? AND accepted_pledge = 1";
    $stmtVerified = $conn->prepare($sqlVerified);
    $stmtVerified->bind_param("i", $currentYear);
    $stmtVerified->execute();
    $resultVerified = $stmtVerified->get_result();
    $totalVerified = 0;
    if ($resultVerified) {
        $rowVerified = $resultVerified->fetch_assoc();
        $totalVerified = $rowVerified['total_verified'];
    }

    // Query to count the total number of enrolled students
    $sqlEnrolled = "SELECT COUNT(*) AS total_enrolled FROM enrollment_code WHERE is_verified = 1";
    $resultEnrolled = $conn->query($sqlEnrolled);
    $totalEnrolled = 0;
    if ($resultEnrolled) {
        $rowEnrolled = $resultEnrolled->fetch_assoc();
        $totalEnrolled = $rowEnrolled['total_enrolled'];
    }

    // Form the string
    $enrollmentString = "{$totalEnrolled} out of {$totalVerified}";

    // Prepare the response
    $response = [
        "total_verified_students" => $totalVerified,
        "total_enrolled" => $totalEnrolled,
        "enrollment_string" => $enrollmentString
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    

    $stmtVerified->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}


?>
