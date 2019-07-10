<?php

session_start();

include '../inc/config.inc.php';
include '../inc/class_dbo.inc.php';
include '../inc/class_gump.inc.php';



// set maximal number of login attempts
// ------------------------------------
if(!isset($_SESSION['loginAttempts'])) {
  $_SESSION['loginAttempts'] = 0;
}



// -------------------------------------------------------------------



// submitted data?
// ---------------
if($_SERVER['REQUEST_METHOD'] == 'POST') {



  // count login attempts
  // --------------------
  $_SESSION['loginAttempts']++;



  // stop executing after maximum number of login attempts
  // -----------------------------------------------------
  if($_SESSION['loginAttempts'] < $conf_maxLoginAttempts) {



    // correct password
    // ----------------
    if(password_verify($_POST['password'], $conf_pwHash)) {

      // set user session variable
      // -------------------------
      $_SESSION['admin'] = true;

      // send user back to requested page?
      // ---------------------------------
      (isset($_SESSION['requestedPage']))
      ? $nextPage = $_SESSION['requestedPage']
        : $nextPage = $conf_defaultStartPage;

      unset($_SESSION['requestedPage']);

      header('Location: '.$nextPage);
      die;
    }



    // incorrect password:
    // do nothing (intentionally!) ;)
  }
}



// -------------------------------------------------------------------

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>webARTelier | Admin</title>

    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/admin.css">

  </head>
  <body>

    <!-- navigation -->
    <?php include 'admin_html_navigation.php'; ?>
    <!-- end navigation -->



    <!-- page content -->
    <div class="l-content">



      <?php include 'admin_html_footer.php'; ?>

    </div>

