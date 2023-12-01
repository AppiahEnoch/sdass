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




include "./session/SESSION_CLR.php";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SDA Senior High School Bekwai</title>
    <link  rel="icon" type="image/png" href="./devimage/logo.png"/>

 

  

    <link rel="stylesheet" href="./ae.css?
    <?php echo filemtime("ae.css"); ?>
    " />

    <link rel="stylesheet" href="./aeNav.css?
    <?php echo filemtime("aeNav.css"); ?>
    " />

    <link rel="stylesheet" href="./style1.css?
    <?php echo filemtime("style1.css"); ?>
    " />


    <link rel="stylesheet" href="./style2.css?
    <?php echo filemtime("style2.css"); ?>
    " />
    <link rel="stylesheet" href="./carousel.css?
    <?php echo filemtime("carousel.css"); ?>
    " />

    <link rel="stylesheet" href="./registration.css?
    <?php echo filemtime("registration.css"); ?>
    " />


    <link rel="stylesheet" href="./aeT.css?
    <?php echo filemtime("aeT.css"); ?>
    " />
    <link rel="stylesheet" href="./aeT.css?
    <?php echo filemtime("aeT.css"); ?>
    " />
    <link rel="stylesheet" href="./login.css?
    <?php echo filemtime("login.css"); ?>
    " />

    <link rel="stylesheet" href="./aeCard1.css?
    <?php echo filemtime("aeCard1.css"); ?>
    " />
    <link rel="stylesheet" href="./aeAbout.css?
    <?php echo filemtime("aeAbout.css"); ?>
    " />
    <link rel="stylesheet" href="./aeFooter.css?
    <?php echo filemtime("aeFooter.css"); ?>
    " />




    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link rel="icon" type="image/png" href="../dev_image/2.jpeg" />
  </head>
  <body>
<?php 
//include "aeH.php";
include "aeNav.php";
include "aeCarousel.php";
include "aeCard1.php";
include "aeAbout.php";
include "registration.php";
include "login.php";
include "reset.php";
include "aeT.php";
include "aeM.php";
include "aeS.php";
include "aeFooter.php";
?>
 
 <?php

$serverName = $_SERVER['SERVER_NAME'];

if ($serverName == "localhost" || $serverName == "127.0.0.1" || $serverName== "192.168.137.1") {

    // Include offline libraries if the server is localhost
    include "./lib_offline2.html";
} else {
    // Include online libraries if on a production server
    include "./lib_online2.html";
}

?>


    <script src="ae.js?version=<?php echo filemtime('ae.js'); ?>"></script>
   
    <script src="registration.js?version=<?php echo filemtime('registration.js'); ?>"></script>
    <script src="login.js?version=<?php echo filemtime('login.js'); ?>"></script>
    <script src="footer.js?version=<?php echo filemtime('footer.js'); ?>"></script>
    <script src="./SESSION_CLR.js?version=<?php echo filemtime('.SESSION_CLR.js'); ?>"></script>


    

  </body>
</html>
