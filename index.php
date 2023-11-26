
<?php
include "./session/SESSION_CLR.php";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SDASS</title>
    <link  rel="icon" type="image/png" href="./devimage/logo.png"/>

 

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />

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


    <script src="ae.js?version=<?php echo filemtime('ae.js'); ?>"></script>
   
    <script src="registration.js?version=<?php echo filemtime('registration.js'); ?>"></script>
    <script src="login.js?version=<?php echo filemtime('login.js'); ?>"></script>
    <script src="footer.js?version=<?php echo filemtime('footer.js'); ?>"></script>
    <script src="./SESSION_CLR.js?version=<?php echo filemtime('./session/SESSION_CLR.js'); ?>"></script>
  </body>
</html>
