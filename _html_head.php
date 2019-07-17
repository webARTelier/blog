<?php

session_start();

include 'inc/config.inc.php';
include 'inc/func.inc.php';
include 'inc/class_dbo.inc.php';

?>

<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your, keywords, here">
    <meta name="description" content="your description here">

    <title><?php echo $conf_pageTitle; ?></title>

    <link rel="stylesheet" href="css/main.css">

  </head>

  <body<?php if(isset($pageID)) { echo ' id="'.$pageID.'"'; } ?>>
