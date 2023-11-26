<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


try {
    $mail = new PHPMailer;
    $emailToCheck = $_POST['form3_email'];

    $name =   $emailToCheck;

 $sql = "SELECT id, username, email FROM usertable WHERE email=?";
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("s", $emailToCheck);
 $stmt->execute();
 $result = $stmt->get_result();

 if ($result->num_rows === 0) {
     echo json_encode(['error' => 'Email does not exist']);
     exit();
 }

 $row = $result->fetch_assoc();
 $userid = $row['id'];
 $name = $row['username'];
 $token = bin2hex(random_bytes(32));










    $token = generateAndStoreToken($emailToCheck,$userid);




    $link = "https://thedressing.shop/reset/validateToken.php?token=" . $token;
    // Example usage
    $settings = [
        'sender' => $email_sender,
        'password' => $email_password,
        'receiver' => $emailToCheck,
        'subject' => "Password Reset Request",
        'host' => "smtp.gmail.com",
        'port' => "25"
    ];

    // HTML content
    $htmlFile = "PSWR.html";
    if (!file_exists($htmlFile)) {
        die($htmlFile . " does not exist");
    } else {
        $html = file_get_contents($htmlFile);
    }

    $curyear = date('Y');
    $html = str_replace('{{name}}', $name, $html);
    $html = str_replace('{{app}}', $app, $html);
    $html = str_replace('{{link}}', $link, $html);
    $html = str_replace('{{current_year}}', $curyear, $html);

    // Email settings
    $mail->isSMTP();
    $mail->Host = $settings['host'];
    $mail->SMTPAuth = "true";
    $mail->SMTPSecure = "tls";
    $mail->Port = $settings['port'];
    $mail->Username = $settings['sender'];
    $mail->Password = $settings['password'];
    $mail->addAddress($settings['receiver']);
    $mail->Subject = $settings['subject'];
    $mail->msgHTML($html);

    // Send email
    if (!$mail->send()) {
        echo "Error3: " . $mail->ErrorInfo;
        exit();
    } else {
        echo 1;
        exit;
    }
} catch (err) {
    echo "lastE". err;
}



function generateAndStoreToken($email,$userid) {

    global $conn;

    try {
        // Generate a secure random token
        $token = bin2hex(random_bytes(32));
    
        // Set an expiry time for the token, e.g., 1 hour from now
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
        // Check if there's already a token for this email
        $sql = "SELECT * FROM `token` WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if($result->num_rows > 0) {
            // Update the existing token
            $sql = "UPDATE `token` SET token=? WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $token,$email);
        } else {
            // Insert the new token
            $sql = "INSERT INTO `token` (userid,email, token) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss",$userid, $email, $token);
        }
        
        $stmt->execute();
    
        return $token;
    } catch (err) {
        // echo error
        echo "error in generateAndStoreToken";
    }
}
