<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Add your logic to establish a database connection to $conn
// Assuming $conn is your database connection variable from the included files

$sql = "SELECT *, CAST(SUBSTRING(admission_number, 3) AS UNSIGNED) as numeric_part 
        FROM `sdass_admission_number` 
        ORDER BY `is_used` ASC, SUBSTRING(admission_number, 1, 2), numeric_part ASC";
$result = $conn->query($sql);

$admissionList = [];

if ($result->num_rows > 0) {
    // fetch data of each row
    while($row = $result->fetch_assoc()) {
        $admissionList[] = $row;
    }
    echo json_encode(['success' => true, 'admission_number_list' => $admissionList]);
} else {
    echo json_encode(['success' => false, 'message' => 'No records found']);
}
$conn->close();
?>
