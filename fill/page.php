<?php
//include "../session/CK3.php";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SDA Senior High School Bekwai</title>
    <link rel="icon" type="image/png" href="../devimage/logo.png" />

    <?php
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
  
    



    <link rel="stylesheet" href="./style1.css?
    <?php echo filemtime("./style1.css"); ?>
    " />





    <link rel="stylesheet" href="./aeT.css?
    <?php echo filemtime("./aeT.css"); ?>
    " />
    <link>



   




    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
 
  </head>
  <body>
<?php 
//include "aeH.php";
include "aeW.php";




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
    <script src="init.js?version=<?php echo filemtime('init.js'); ?>"></script>

    <script src="STUDENT.js?version=<?php echo filemtime('STUDENT.js'); ?>"></script>
    <script src="GUARDIAN.js?version=<?php echo filemtime('GUARDIAN.js'); ?>"></script>
    <script src="FATHER.js?version=<?php echo filemtime('FATHER.js'); ?>"></script>
    <script src="MOTHER.js?version=<?php echo filemtime('MOTHER.js'); ?>"></script>
    <script src="PLEDGE.js?version=<?php echo filemtime('PLEDGE.js'); ?>"></script>
    <script src="STUDENT_CODE.js?version=<?php echo filemtime('STUDENT_CODE.js'); ?>"></script>

  
  </body>
</html>
