<?php
include "../session/CK3.php";


$serverName = $_SERVER['SERVER_NAME'];

// Use if condition to include different libraries
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
    <title> SDA Senior High School Bekwai</title>
    <link rel="icon" type="image/png" href="../devimage/logo.png" />
 


    <link rel="stylesheet" href="../ae.css?
    <?php echo filemtime("../ae.css"); ?>
    " />
    <link rel="stylesheet" href="./style1.css?
    <?php echo filemtime("./style1.css"); ?>
    " />



    <link rel="stylesheet" href="./style2.css?
    <?php echo filemtime("./style2.css"); ?>
    " />


    <link rel="stylesheet" href="../aeT.css?
    <?php echo filemtime("../aeT.css"); ?>
    " />
    <link>
    
    <link rel="stylesheet" href="./aeM.css?
    <?php echo filemtime("./aeM.css"); ?>
    " />

    <link rel="stylesheet" href="./aeSC.css?
    <?php echo filemtime("./aeSC.css"); ?>
    " />
   
    <link rel="stylesheet" href="./aeC.css?
    <?php echo filemtime("./aeC.css"); ?>
    " />
    <link rel="stylesheet" href="./TEACHER.css?
    <?php echo filemtime("./TEACHER.css"); ?>
    " />
 
   


    <link rel="stylesheet" href="./RESET_USER.css?
    <?php echo filemtime("./RESET_USER.css"); ?>
    " />
   







    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
 
  </head>
  <body>
<?php 
//include "aeH.php";
include "aeNav.php";
include "aeW.php";
include "TEACHERS.php";
include "STUDENT.php";
include "BLOCK.php";
include "RED_BUTTON.php";




include "../aeT.php";
include "./aeM.php";
include "./aeS.php";
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
    <script src="admin.js?version=<?php echo filemtime('admin.js'); ?>"></script>
    <script src="init.js?version=<?php echo filemtime('init.js'); ?>"></script>
    <script src="TEACHERS.js?version=<?php echo filemtime('TEACHERS.js'); ?>"></script>
    <script src="STUDENT.js?version=<?php echo filemtime('STUDENT.js'); ?>"></script>
    <script src="BLOCK.js?version=<?php echo filemtime('BLOCK.js'); ?>"></script>
    <script src="RED_BUTTON.js?version=<?php echo filemtime('RED_BUTTON.js'); ?>"></script>
    <script src="RESET_USER.js?version=<?php echo filemtime('RESET_USER.js'); ?>"></script>
  
 
       

  </body>
</html>
