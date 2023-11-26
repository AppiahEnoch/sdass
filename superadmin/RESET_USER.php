<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

// Sanitizing and validating input
$userId = isset($_POST['userId']) ? $conn->real_escape_string($_POST['userId']) : '';
$firstName = isset($_POST['firstName']) ? $conn->real_escape_string($_POST['firstName']) : '';
$middleName = isset($_POST['middleName']) ? $conn->real_escape_string($_POST['middleName']) : '';
$lastName = isset($_POST['lastName']) ? $conn->real_escape_string($_POST['lastName']) : '';
$newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : ''; // Password should be hashed, not escaped
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$phoneNumber = isset($_POST['phoneNumber']) ? $conn->real_escape_string($_POST['phoneNumber']) : '';
$username= isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';

// Validate required fields
if (empty($userId) || empty($firstName) || empty($lastName) || empty($newPassword) || empty($email) || empty($phoneNumber) || empty($username)) {
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
    exit;
}


// check if username is already taken
$sql = "SELECT * FROM registration WHERE username = '$username' AND staffid != '$userId'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username already taken.']);
    exit;
}













// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// SQL query to update user details
$sql = "UPDATE registration SET 
            mobile = '$phoneNumber',
            email = '$email',
            firstname = '$firstName',
            middlename = '$middleName',
            lastname = '$lastName',
            username= '$username',
            password = '$hashedPassword'
            WHERE staffid = '$userId'";



// Execute the query
if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'User details reset successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error updating record: ' . $conn->error]);
}

// Close the database connection
$conn->close();
?>
