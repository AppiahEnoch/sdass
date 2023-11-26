<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);

// trim
$id = trim($id);

$debts = [];




if (\AE\AE::isEmpty($id)) {
    $stmt = $conn->prepare("SELECT student_old_debt.*, registration.firstname, registration.middlename, registration.lastname FROM student_old_debt LEFT JOIN registration ON student_old_debt.user_id = registration.id ORDER BY admission_number, recdate DESC");
} else {
    $stmt = $conn->prepare("SELECT student_old_debt.*, registration.firstname, registration.middlename, registration.lastname FROM student_old_debt LEFT JOIN registration ON student_old_debt.user_id = registration.id WHERE admission_number = ? ORDER BY admission_number, recdate DESC");
    $stmt->bind_param("s", $id);
}

$stmt->execute();
$result = $stmt->get_result();
$debts = [];
while ($row = $result->fetch_assoc()) {
    $system_user = $row['firstname'];
    if (!empty($row['middlename'])) {
        $system_user .= ' ' . $row['middlename'];
    }
    $system_user .= ' ' . $row['lastname'];
    $row['system_user'] = $system_user;
    $debts[] = $row;
}
$stmt->close();

echo json_encode($debts);
