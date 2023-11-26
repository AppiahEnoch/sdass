<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = ["status" => "error", "message" => "Failed to fetch user data."];








// Assuming you store user ID in the session when they log in.
if (isset($_SESSION['user_id'])) {

    $stmt = $conn->prepare("SELECT * FROM registration WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Data fetched successfully!";
        $response["data"] = $data;
    
        $response['current_term'] =  $_SESSION['current_term'];
        $response['current_class_name'] = $_SESSION['userClass_name'];
        $response['total_student']= $_SESSION['total_student'];
        
}
echo json_encode($response);
}


?>
