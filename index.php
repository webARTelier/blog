<!-- page head -->
<?php

$pageID = 'blog';
include '_html_head.php';

?>
<!-- end page head -->



<!-- navigation -->
<?php include '_html_navigation.php'; ?>
<!-- end navigation -->



<?php

// get data from db
// ----------------
$rs_posts = new DBO(...$db_access);
$rs_posts->pagination = true;
$rs_posts->pagination_entriesPerPage = 5;

if(isset($_GET['page'])) {
  $rs_posts->pagination_currentPage = $_GET['page'];
}

$rs_posts
  ->_cols('posts.ID, posts.created, posts.headline, posts.abstract, categories.category')
  ->_from('posts')
  ->_leftjoin('categories', 'categories.ID = posts.category')
  ->_where('posts.ID > ?', 0)
  ->_orderby('created DESC')
  ->fetch();

?>



<!-- page content -->
<div class="l-content">



  <!-- post -->
  <?php



  // prepare divider
  // ---------------
  $html_divider = '';



  while(!$rs_posts->EOF) {

    echo $html_divider;

  ?>

  <div class="c-post">

    <img class="c-post__image" src="images/post_small.jpg"
         srcset="images/post_small.jpg 768w,
                 images/post_medium.jpg 1024w,
                 images/post_large.jpg 1200w"
         sizes="(min-width: 990px) 68vw, 89vw"
         alt="<?php echo $rs_posts->field('abstract'); ?>">

    <div class="c-post__time">
      <time datetime="<?php echo $rs_posts->field('created'); ?>"><?php echo date("d.m.Y", strtotime($rs_posts->field('created'))); ?></time>
      | WEB<span class="u-color-primary">ART</span>ELIER
    </div>

    <a href="javascript:;">
      <h1 class="c-post__headline" ><?php echo $rs_posts->field('headline'); ?></h1>
    </a>



    <!-- wrapper meta/post content -->
    <div class="c-post__wrapper">

      <!-- post meta -->
      <div class="c-meta">
        <div class="c-meta__item">
          <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-list"></use></svg>
          <a class="c-meta__link" href="javascript:;"><?php echo $rs_posts->field('category'); ?></a>
        </div>
        <div class="c-meta__item">
          <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-bubble"></use></svg>
          <a class="c-meta__link" href="javascript:;">7 Kommentare</a>
        </div>
      </div>
      <!-- post meta -->



      <!-- post content -->
      <div class="c-post__content">

        <div class="c-post__abstract">
          <p><?php echo $rs_posts->field('abstract'); ?></p>

          <a class="c-post__more" href="post.php?ID=<?php echo $rs_posts->field('ID'); ?>">weiterlesen →</a>
        </div>

      </div>
      <!-- end post content -->

    </div>
    <!-- end wrapper meta/post content -->

  </div>

  <?php

    // create divider
    // --------------
    if($html_divider == '') {
      $html_divider = '<div class="c-divider c-divider--large"></div>';
    }

    $rs_posts->move_next();
  }

  ?>
  <!-- end post -->



  <!-- pagination -->
  <?php echo $rs_posts->pagination_html; ?>
  <!-- end pagination -->



</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_html_footer.php'; ?>
<!-- end page footer -->
