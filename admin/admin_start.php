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



// get data from db
// ----------------
$rs_posts = new DBO(...$db_access);
$rs_posts->pagination = true;

if(isset($_GET['page'])) {
  $rs_posts->pagination_currentPage = $_GET['page'];
}

$rs_posts
  ->_cols('ID, created, headline')
  ->_from('posts')
  ->_where('ID > ?', 0)
  ->_orderby('created DESC')
  ->fetch();



$pageID = 'blog';
include '_admin_html_head.php';
?>



<!-- navigation -->
<?php include '_admin_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">
  <h1 class="c-headline__admin c-headline__admin--1">Posts</h1>

  <?php

  while(!$rs_posts->EOF) {
    echo '<a class="c-link--admin" href="admin_post.php?ID='.$rs_posts->field('ID').'">'
      .'<span class="c-link--date">'.date("d.m.Y", strtotime($rs_posts->field('created'))).'</span>&nbsp;'
      .$rs_posts->field('headline')
      .'</a><br>';
    $rs_posts->move_next();
  }

  echo $rs_posts->pagination_html;

  ?>

</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_admin_html_footer.php'; ?>
<!-- end page footer -->
