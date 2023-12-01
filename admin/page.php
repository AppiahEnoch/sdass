<?php
include "../session/CK3.php";
$serverName = $_SERVER['SERVER_NAME'];


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

    <link rel="stylesheet" href="./SIGNATURE.css?
    <?php echo filemtime("./SIGNATURE.css"); ?>
    " />

    <link rel="stylesheet" href="./HOUSE.css?
    <?php echo filemtime("./HOUSE.css"); ?>
    " />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
 
  </head>
  <body>
<?php 
//include "aeH.php";
include "aeNav.php";
include "aeW.php";
include "regCode.php";
include "ADMISSION.php";
include "FEE.php";
include "STUDENT_BILL.php";
include "TERM.php";
include "ATTENDANCE.php";
include "AS1.php";
include "ASR1.php";
include "ASC1.php";
include "NEXT_TERM.php";

include "ADMISSION_RECORD.php";
include "TIMETABLE.php";
include "TIMETABLE_T.php";
include "MESSAGE.php";
include "SIGNATURE.php";
include "TEACHERS.php";
include "STUDENT.php";
include "OLD_STUDENT_DEBT.php";
include "GES_ADMISSION_LIST.php";
include "ADMISSION_NUMBER.php";
include "HOUSE.php";
include "ENROLL_CODE.php";




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
    <script src="regCode.js?version=<?php echo filemtime('regCode.js'); ?>"></script>
    <script src="init.js?version=<?php echo filemtime('init.js'); ?>"></script>
    <script src="ADMISSION.js?version=<?php echo filemtime('ADMISSION.js'); ?>"></script>
    <script src="ADMISSION_F.js?version=<?php echo filemtime('ADMISSION_F.js'); ?>"></script>
    <script src="FEE.js?version=<?php echo filemtime('FEE.js'); ?>"></script>
    <script src="FEE_F.js?version=<?php echo filemtime('FEE_F.js'); ?>"></script>
    <script src="STUDENT_BILL.js?version=<?php echo filemtime('STUDENT_BILL.js'); ?>"></script>
    <script src="TERM.js?version=<?php echo filemtime('TERM.js'); ?>"></script>
  
    <script src="AS1.js?version=<?php echo filemtime('AS1.js'); ?>"></script>
    <script src="ASR1.js?version=<?php echo filemtime('ASR1.js'); ?>"></script>
    <script src="ASC1.js?version=<?php echo filemtime('ASC1.js'); ?>"></script>
    <script src="ATTENDANCE.js?version=<?php echo filemtime('ATTENDANCE.js'); ?>"></script>
    <script src="NEXT_TERM.js?version=<?php echo filemtime('NEXT_TERM.js'); ?>"></script>
    <script src="ADMISSION_RECORD.js?version=<?php echo filemtime('ADMISSION_RECORD.js'); ?>"></script>
    <script src="TIMETABLE.js?version=<?php echo filemtime('TIMETABLE.js'); ?>"></script>
    <script src="TIMETABLET.js?version=<?php echo filemtime('TIMETABLET.js'); ?>"></script>
    <script src="MESSAGE.js?version=<?php echo filemtime('MESSAGE.js'); ?>"></script>
    <script src=SIGNATURE.js?version=<?php echo filemtime('SIGNATURE.js'); ?>"></script>
    <script src=TEACHERS.js?version=<?php echo filemtime('TEACHERS.js'); ?>"></script>
    <script src=STUDENT.js?version=<?php echo filemtime('STUDENT.js'); ?>"></script>
    <script src=OLD_STUDENT_DEBT.js?version=<?php echo filemtime('OLD_STUDENT_DEBT.js'); ?>"></script>
    <script src=GES_ADMISSION_LIST.js?version=<?php echo filemtime('GES_ADMISSION_LIST.js'); ?>"></script>
    <script src=ADMISSION_NUMBER.js?version=<?php echo filemtime('ADMISSION_NUMBER.js'); ?>"></script>
    <script src=HOUSE.js?version=<?php echo filemtime('HOUSE.js'); ?>"></script>
    <script src=HOUSE_FETCH.js?version=<?php echo filemtime('HOUSE_FETCH.js'); ?>"></script>
    <script src=ENROLL_CODE.js?version=<?php echo filemtime('ENROLL_CODE.js'); ?>"></script>
   

  </body>
</html>
