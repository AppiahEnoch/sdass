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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />


    <link rel="stylesheet" href="./ae.css?
    <?php echo filemtime("./ae.css"); ?>
    " />
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
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
      integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
      integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.7.0.min.js"
      integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://kit.fontawesome.com/c1db89cf54.js"
      crossorigin="anonymous"
    ></script>


    <script src="../ae.js?version=<?php echo filemtime('../ae.js'); ?>"></script>
    <script src="init.js?version=<?php echo filemtime('init.js'); ?>"></script>

    <script src="STUDENT.js?version=<?php echo filemtime('STUDENT.js'); ?>"></script>
    <script src="GUARDIAN.js?version=<?php echo filemtime('GUARDIAN.js'); ?>"></script>
    <script src="FATHER.js?version=<?php echo filemtime('FATHER.js'); ?>"></script>
    <script src="MOTHER.js?version=<?php echo filemtime('MOTHER.js'); ?>"></script>
    <script src="PLEDGE.js?version=<?php echo filemtime('PLEDGE.js'); ?>"></script>

  
  </body>
</html>
