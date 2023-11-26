<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$userId = $_SESSION['user_id'] ?? 0; // Assuming user_id is stored in session



$folderPath = "../signature/";

$files = glob($folderPath . '*', GLOB_MARK); // Get all file names

foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); // Delete file
    }
}


// Function definitions

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Call the function to upload the image
    $signatureUrl = uploadImageWithUniqueName('headteacher_upload_signature');

    if ($signatureUrl) {
        // Check if the record already exists
        $checkQuery = "SELECT id FROM signature WHERE user_id = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Record exists, update it
            $updateQuery = "UPDATE signature SET signature_url = ? WHERE user_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("si", $signatureUrl, $userId);
            $updateStmt->execute();
        } else {
            // No record exists, insert a new one
            $insertQuery = "INSERT INTO signature (user_id, signature_url) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("is", $userId, $signatureUrl);
            $insertStmt->execute();
        }

        // Check for successful insert/update
        if ($conn->affected_rows > 0) {
            // Success
            echo json_encode(['success' => true, 'message' => 'Signature saved successfully.', 'signature_url' => $signatureUrl]);
        } else {
            // Error
            echo json_encode(['success' => false, 'message' => 'Unable to save signature.']);
        }
    } else {
        // File upload failed or file was not provided
        echo json_encode(['success' => false, 'message' => 'Failed to upload file or file not provided.']);
    }
} else {
    // Not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}





function uploadImageWithUniqueName($input_name, $target_dir = "../signature/") {
    //$image_url = uploadImageWithUniqueName('material_image');

    if(isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0){
        // Generate a unique ID
        $unique_id = bin2hex(openssl_random_pseudo_bytes(16));

        // add  generateCode() to $unique_id
        $unique_id = $unique_id . generateCode();
    
        // Get the extension of the file
        $file_extension = pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION);
    
        // Create a new filename with the unique ID
        $new_filename = $unique_id . '.' . $file_extension;
    
        // Full path to the new file
        $new_file_path = $target_dir . $new_filename;
    
        // Move the uploaded file to the new location
        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $new_file_path)) {
            // Return the relative path
            return $new_file_path;
        }
    }

    return false;
}




function generateCode() {
    $seed = md5(uniqid(mt_rand(), true));
    $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $charIndex = hexdec(substr($seed, $i, 1)) % $charactersLength;
        $randomString .= $characters[$charIndex];
    }
    return $randomString;
  }
