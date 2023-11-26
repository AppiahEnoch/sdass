<?php
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = [];

function formatDateWithOrdinal($date) {
    return date("jS M. Y", strtotime($date));
}

$admission_number = $_POST['admission_number'];

$sql = "SELECT 
  id, amount,
  (SELECT item FROM bill_item WHERE id = payment_type) as payment_type, 
  description, recdate
FROM student_payment  
WHERE admission_number = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admission_number);
$stmt->execute();

$result = $stmt->get_result();
$payments = $result->fetch_all(MYSQLI_ASSOC);

foreach ($payments as &$payment) {
    $payment['recdate'] = formatDateWithOrdinal($payment['recdate']);
   
}

$response['status'] = 'success';
$response['payments'] = $payments;

echo json_encode($response);
?>
