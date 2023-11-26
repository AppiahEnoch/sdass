<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include '../AE/AE.php';

$sql = "SELECT next_term_Date FROM next_term_date ORDER BY recdate DESC LIMIT 1";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
     $current_date= $row['next_term_Date'];
   
   

     $current_date = \AE\AE::aeDate($current_date);
     $data['next_term_date'] = $current_date;
     
    }
}
echo json_encode($data);
