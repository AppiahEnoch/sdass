<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$sql = "SELECT signature_url FROM signature ORDER BY id DESC LIMIT 1";
if($stmt = $conn->prepare($sql)){
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $signature_url = $data ? $data['signature_url'] : '../devimage/default_signature.png';
    echo json_encode(['signature_url' => $signature_url]);
    $stmt->close();
}
?>
