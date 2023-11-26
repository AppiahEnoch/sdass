<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$response = ["status" => "error", "message" => "Failed to upload image."];

if (isset($_FILES['profilePic'])) {
    $uploadedImagePath = uploadImageWithUniqueName('profilePic', "../userprofile/");
    
    if ($uploadedImagePath) {
        // Here's the change: updating the profile_pic field in the registration table
        $stmt = $conn->prepare("UPDATE registration SET profile_pic = ? WHERE id = ?");
        $stmt->bind_param("si", $uploadedImagePath, $_SESSION['user_id']);
        
        if ($stmt->execute()) {
            $response["status"] = "success";
            $response["message"] = "Profile image updated successfully!";
            $response["newImagePath"] = $uploadedImagePath;
        } else {
            $response["message"] = "Database update failed.";
        }
    } else {
        $response["message"] = "File upload failed.";
    }
}

echo json_encode($response);

function uploadImageWithUniqueName($input_name, $target_dir = "../material_image/") {
    if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] == 0) {
        $unique_id = bin2hex(openssl_random_pseudo_bytes(16));
        $unique_id = $unique_id . generateCode();
        $file_extension = pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION);
        $new_filename = $unique_id . '.' . $file_extension;
        $new_file_path = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $new_file_path)) {
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
?>
