<?php

session_start();

include '../inc/config.inc.php';
include '../inc/func.inc.php';
include '../inc/class_dbo.inc.php';



// logged in?
// ----------
if(!$_SESSION['admin']) {
  header('Location: '.$conf_defaultLoginPage);
  exit;
}



// -------------------------------------------------------------------



// requested comment?
// ------------------
$requestedComment = 0;

if(isset($_GET['comment'])) {
  $requestedComment = $_GET['comment'];
}



// -------------------------------------------------------------------



// put comment online
// ------------------
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // prepare message
  // ---------------
  $_SESSION['modal'] = array(
    'headline'    => 'Änderung übernommen',
    'message'     => 'Der Kommentar wurde freigegeben.'
  );
}



// -------------------------------------------------------------------



// get comment from db
// -------------------
$rs_comment = new DBO(...$db_access);
$rs_comment
  ->_cols('ID, online, created, articleID, replyTo, input_name, input_comment')
  ->_from('comments')
  ->_where('ID = ?', $requestedComment)
  ->fetch();



include '_admin_html_head.php';
?>



<!-- navigation -->
<?php include '_admin_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <h1 class="c-headline__admin"><?php $rs_comment->field('input_name'); ?></h1>



</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_admin_html_footer.php'; ?>
<!-- end page footer -->
