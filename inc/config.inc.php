<?php



// data base access (server, user, password, db name)
// --------------------------------------------------
$db_access = array(
  'localhost',
  'root',
  'sqladmin',
  'credit'
);



// -------------------------------------------------------------------



// FRONT END AREA
// ==============

// time settings
// -------------
date_default_timezone_set('Europe/Berlin');



// set development/production mode
// -------------------------------
$conf_devMode = true;



// creation year (used in copyright note)
// --------------------------------------
$conf_creationYear = 2019;



// page title
// ----------
$conf_pageTitle = 'webARTelier | Individuelle Internet-Lösungen';



// -------------------------------------------------------------------



// ADMIN AREA
// ==========

// maximal number of login attempts
// --------------------------------
$conf_maxLoginAttempts = 3;



// password hash
// -------------
$conf_pwHash = '$2y$10$ZqSXnnWh5MCuRvyDDUTqkuaxRAPnkPOdaOqsHYd/S8Hr//57QuI8G';



// default login page
// ------------------
$conf_defaultLoginPage = 'index.php';



// default start page
// ------------------
$conf_defaultStartPage = 'admin_start.php';

?>
