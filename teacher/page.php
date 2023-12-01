<?php
include "../session/CK3.php";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> SDA Senior High School Bekwai</title>
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



    <link rel="stylesheet" href="./ae.css?
    <?php echo filemtime("./ae.css"); ?>
    " />
    <link rel="stylesheet" href="./style1.css?
    <?php echo filemtime("./style1.css"); ?>
    " />



    <link rel="stylesheet" href="./style2.css?
    <?php echo filemtime("./style2.css"); ?>
    " />
    <link rel="stylesheet" href="./carousel.css?
    <?php echo filemtime("./carousel.css"); ?>
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
   
    <link rel="stylesheet" href="./regCode.css?
    <?php echo filemtime("./regCode.css"); ?>
    " />

    <link rel="stylesheet" href="./ADMISSION.css?
    <?php echo filemtime("./ADMISSION.css"); ?>
    " />

    <link rel="stylesheet" href="./ADMISSION_F.css?
    <?php echo filemtime("./ADMISSION_F.css"); ?>
    " />

    <link rel="stylesheet" href="./FEE.css?
    <?php echo filemtime("./FEE.css"); ?>
    " />


    <link rel="stylesheet" href="./STUDENT_BILL.css?
    <?php echo filemtime("./STUDENT_BILL.css"); ?>
    " />


    <link rel="stylesheet" href="./aeCT.css?
    <?php echo filemtime("./aeCT.css"); ?>
    " />

    <link rel="stylesheet" href="./CLASS_LIST.css?
    <?php echo filemtime("./CLASS_LIST.css"); ?>
    " />
    <link rel="stylesheet" href="./AS1.css?
    <?php echo filemtime("./AS1.css"); ?>
    " />
    <link rel="stylesheet" href="./MESSAGE.css?
    <?php echo filemtime("./MESSAGE.css"); ?>
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



include "TERM.php";
include "ATTENDANCE.php";
include "AS1.php";
include "ASR1.php";
include "ASC1.php";

include "CLASS_LIST.php";


include "TIMETABLE_T.php";
include "MESSAGE.php";



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
    <script src="ADMISSION.js?version=<?php echo filemtime('ADMISSION.js'); ?>"></script>

    



    <script src="CLASS_LIST.js?version=<?php echo filemtime('CLASS_LIST.js'); ?>"></script>
    <script src="AS1.js?version=<?php echo filemtime('AS1.js'); ?>"></script>
    <script src="ASR1.js?version=<?php echo filemtime('ASR1.js'); ?>"></script>
    <script src="ASC1.js?version=<?php echo filemtime('ASC1.js'); ?>"></script>
    <script src="ATTENDANCE.js?version=<?php echo filemtime('ATTENDANCE.js'); ?>"></script>
    <script src="TIMETABLET.js?version=<?php echo filemtime('TIMETABLET.js'); ?>"></script>
    <script src="MESSAGE.js?version=<?php echo filemtime('MESSAGE.js'); ?>"></script>
   

  </body>
</html>
