<?php
// if not is set token
if(!isset($_SESSION['token'])){
    header('Location: ../index.php');
    exit;
}

$serverName = $_SERVER['SERVER_NAME'];

if ($serverName == "localhost" || $serverName == "127.0.0.1" || $serverName== "192.168.137.1") {
    // Include offline libraries if the server is localhost
    include "./lib_offline1.html";
} else {
    // Include online libraries if on a production server
    include "./lib_online1.html";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SDA Senior High School Bekwai</title>

   
    <link rel="stylesheet" href="./style1.css?
    <?php echo filemtime("style1.css"); ?>
    " />
    <link rel="stylesheet" href="./style2.css?
    <?php echo filemtime("style2.css"); ?>
    " />

    <link rel="stylesheet" href="../aeL.css?
    <?php echo filemtime("../aeL.css"); ?>
    " />
    <link rel="stylesheet" href="../aeT.css?
    <?php echo filemtime("../aeT.css"); ?>
    " />

    <link rel="stylesheet" href="./aeR.css?
    <?php echo filemtime("aeR.css"); ?>
    " />


    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link rel="icon" type="image/png" href="../dev_image/2.jpeg" />

    <link rel="stylesheet" href="fw/all.css">
  </head>
  <body>
 
    
    <?php 
  
    include "aeR.php";
    include "../aeT.php";
    include "../aeM.php";
    include "../aeS.php";
    ?>




<?php

$serverName = $_SERVER['SERVER_NAME'];

// Use if condition to include different libraries
if ($serverName == "localhost" || $serverName == "127.0.0.1" || $serverName== "192.168.137.1") {
    // Include offline libraries if the server is localhost
    include "./lib_offline2.html";
} else {
    // Include online libraries if on a production server
    include "./lib_online2.html";
}

?>


    <script src="../ae.js?version=<?php echo filemtime('../ae.js'); ?>"></script>
    <script src="aeR.js?version=<?php echo filemtime('aeR.js'); ?>"></script>
    <script src="selectID.js?version=<?php echo filemtime('selectID.js'); ?>"></script>



   
  </body>
</html>
