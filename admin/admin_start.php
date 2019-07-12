<!-- page head -->
<?php include 'admin_html_head.php'; ?>
<!-- end page head -->



<?php

// get data from db
// ----------------
$rs_posts = new DBO(...$db_access);
$rs_posts->pagination = true;

if(isset($_GET['page'])) {
  $rs_posts->pagination_currentPage = $_GET['page'];
}

$rs_posts
  ->_cols('ID, headline')
  ->_from('posts')
  ->_where('ID > ?', 0)
  ->_orderby('created DESC')
  ->fetch();

?>



<!-- navigation -->
<?php include 'admin_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">
  <h1 class="c-headline__admin c-headline__admin--1">Posts</h1>

  <?php

  while(!$rs_posts->EOF) {
    echo '<a class="c-link-admin" href="admin_post.php?ID='.$rs_posts->field('ID').'">'
      .$rs_posts->field('headline')
      .'</a><br>';
    $rs_posts->move_next();
  }

  echo $rs_posts->pagination_html;

  ?>
</div>
<!-- end page content -->



<!-- page footer -->
<?php include 'admin_html_footer.php'; ?>
<!-- end page footer -->
