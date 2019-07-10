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
    if(password_verify($_POST['input_password'], $conf_pwHash)) {

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
    // do (intentionally!) nothing ;)
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
    <?php include 'admin_html_navigation_login.php'; ?>
    <!-- end navigation -->



    <!-- page content -->
    <div class="l-content">



      <!-- login form -->
      <form id="target-comment" action="" method="post">

        <h3 class="c-post__headline">Login</h3>

        <label class="c-label" for="input_password">Website</label>
        <input id="input_password" class="c-input" name="input_password">

        <button class="c-button js-submit">
          <span class="c-button__flex">
            <span class="c-button__text">anmelden</span>
            <svg class="c-button__icon"><use xlink:href="../images/icons.svg#icon-plane"></use></svg>
          </span>
        </button>

      </form>
      <!-- end login form -->



    </div>
    <!-- end page content -->



    <!-- page footer -->
    <?php include 'admin_html_footer.php'; ?>
    <!-- end page footer -->
