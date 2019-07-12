<?php

session_start();

include '../inc/config.inc.php';
include '../inc/class_dbo.inc.php';


// logged in?
// ----------
if(!$_SESSION['admin']) {
  header('Location: '.$conf_defaultLoginPage);
  exit;
}



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
