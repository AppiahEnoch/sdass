<?php
include "../session/CK3.php";


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SDA Senior High School Bekwai </title>
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



    <link rel="stylesheet" href="../style1.css?
    <?php echo filemtime("../style1.css"); ?>
    " />
    <link rel="stylesheet" href="./nav.css?
    <?php echo filemtime("./nav.css"); ?>
    " />
    <link rel="stylesheet" href="../style2.css?
    <?php echo filemtime("../style2.css"); ?>
    " />


    <link rel="stylesheet" href="../aeT.css?
    <?php echo filemtime("../aeT.css"); ?>
    " />
    <link>

    <link rel="stylesheet" href="./form.css?
    <?php echo filemtime("./form.css"); ?>
    " />
    <link rel="stylesheet" href="../aeFooter.css?
    <?php echo filemtime("../aeFooter.css"); ?>
    " />
    <link rel="stylesheet" href="./MESSAGE.css?
    <?php echo filemtime("./MESSAGE.css"); ?>
    " />


    
    





    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <link rel="icon" type="image/jpg" href="../devimage/logo.jpg" />
  </head>
  <body>
   





  <?php 
include "./aeH.php";
include "./form.php";
include "./MESSAGE.php";


include "../aeT.php";
include "../aeM.php";
include "../aeS.php";
include "./aeFooter.php";
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
    <script src="./footer.js?version=<?php echo filemtime('./footer.js'); ?>"></script>
    <script src="./form.js?version=<?php echo filemtime('./form.js'); ?>"></script>
    <script src="./TIMETABLE.js?version=<?php echo filemtime('./TIMETABLE.js'); ?>"></script>
    <script src="./MESSAGE.js?version=<?php echo filemtime('./MESSAGE.js'); ?>"></script>
    
  </body>
</html>
