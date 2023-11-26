<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";

$sql = "SELECT * FROM term order by  current_term desc,recdate desc";
$result = $conn->query($sql);

$terms = [];

$first_term = true;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $terms[] = $row;
        if($first_term){
            $first_term = false;
            $_SESSION['current_term'] = $row['term_year'];
        }

       
      
    }
}

echo json_encode($terms);
?>
