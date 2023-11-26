<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

// get session userid
$user_id  = $_SESSION['user_id'];

$response = [];

try {
    // Turn off error reporting on production server
    // error_reporting(0);

    // Validate and sanitize input
    $admission_number = filter_input(INPUT_POST, 'admission_number', FILTER_SANITIZE_STRING);
    $paymentType = filter_input(INPUT_POST, 'paymentType', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'otherPaymentDescription', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'student_payment_amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $receipt_id = filter_input(INPUT_POST, 'student_payment_receiptId', FILTER_SANITIZE_STRING);







    // Check if user_id is set
    if (!$user_id) {
        throw new Exception("User is not authenticated.");
        exit;
    }

    // Check if essential POST data is set and is not empty
    if (!$admission_number || !$paymentType || !$amount) {
        throw new Exception("Required fields missing.". $admission_number . $paymentType . $amount);
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM receipt WHERE receipt_id = ?");
    $stmt->bind_param("s", $receipt_id);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    $row = $stmt_result->fetch_row();
    $receipt_count = $row[0];
    // check if count is more than 0
    if ($receipt_count > 0) {
     echo 0;
        exit;
    }

  

    
 






    $payment_id=null;


    // Query to insert the data
    $sql = "INSERT INTO student_payment (userid, admission_number, payment_type, description, amount) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssd", $user_id, $admission_number, $paymentType, $description, $amount);

    if ($stmt->execute()) {
        $payment_id = $stmt->insert_id;
        $response['status'] = 'success';
        $response['message'] = 'Payment data inserted successfully.';
    } else {
        throw new Exception("Error inserting payment data.");  // Use a generic error message
    }

    $stmt->close();
} catch(Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);












$term_year =   $_SESSION['current_term'];
$admission_number = $_SESSION['admission_number'];




$stmt = $conn->prepare("INSERT INTO receipt (user_id, payment_id, receipt_id, term_year, admission_number) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $user_id, $payment_id, $receipt_id, $term_year, $admission_number);
$stmt->execute();

if($stmt->affected_rows > 0){
    // Successfully inserted
} else {
    throw new Exception("Failed to insert receipt data.");
}





?>
