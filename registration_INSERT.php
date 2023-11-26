<?php
session_start();
require_once './vendor/autoload.php';
include "./config/config.php";
include "./config/settings.php";

$response = ["status" => "error", "message" => "Failed to register."];

if (isset($_POST['mobile']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['userClass']) && isset($_POST['username']) && isset($_POST['password'])) {
    // Check if mobile or username already exists
    $stmt = $conn->prepare("SELECT mobile, username FROM registration WHERE mobile = ? OR username = ?");
    $stmt->bind_param("ss", $_POST['mobile'], $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        if($data['mobile'] == $_POST['mobile']) {
            $response["message"] = "Mobile number already exists!";
        } elseif ($data['username'] == $_POST['username']) {
            $response["message"] = "Username already exists!";
        }
        echo json_encode($response);
        exit;
    }

    // Fetch the max id value from the registration table
    $stmt = $conn->prepare("SELECT MAX(id) AS max_id FROM registration");
    $stmt->execute();
    $max_id_result = $stmt->get_result();
    $max_id_data = $max_id_result->fetch_assoc();
    $max_id = $max_id_data['max_id'];
    
    // Generate the staffid
    $currentYear = date("Y");
    $staffid = $currentYear . ($max_id + 1); // +1 because we want the next ID

    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO registration (mobile, firstname, middlename, lastname, userClass, username, email, password, staffid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $_POST['mobile'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['userClass'], $_POST['username'], $_POST['email'], $hashedPassword, $staffid);

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Registered successfully!";
    }

    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>
