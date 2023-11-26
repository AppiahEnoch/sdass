<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

/**
 * This script is responsible for inserting a record of old student debt payment into the database.
 * It receives the admission number, amount, debt date, and description from the client-side.
 * The script validates the request and inserts the data into the 'student_old_debt' table.
 * It then returns a JSON response indicating the success or failure of the operation.
 */

$response = ['success' => false, 'message' => ''];

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admission_number'], $_POST['amount'], $_POST['debt_date'])) {
    $admissionNumber = $conn->real_escape_string($_POST['admission_number']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $debtDate = $conn->real_escape_string($_POST['debt_date']);
    $description = $conn->real_escape_string($_POST['description']);

    $insertQuery = "INSERT INTO student_old_debt (admission_number, amount, debt_date, description, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sdsss", $admissionNumber, $amount, $debtDate, $description, $user_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Debt payment recorded successfully.';
    } else {
        $response['message'] = 'Failed to record debt payment.';
    }

    $stmt->close();
} else {
    $response['message'] = 'Invalid request.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
