<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = ["status" => "error", "message" => "Failed to update."];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['username']) && isset($_POST['password'])) {

    $id = intval($_POST['id']);
    $username = $_POST['username'];
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE `registration` SET username=?, password=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $hashedPassword, $id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $response["status"] = "success";
        $response["message"] = "Username and password updated successfully!";
    } else {
        echo $id;
        $response["message"] = "No rows updated. Check if the ID exists and the data is different.";
    }

    $stmt->close();
}

//echo json_encode($response);


$token=$_SESSION['token'];

// delete token  from token
$sql = "DELETE FROM token WHERE token=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->close();

$conn->close();

?>
