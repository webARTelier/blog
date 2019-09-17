<?php

session_start();

include 'inc/config.inc.php';
include 'inc/func.inc.php';
include 'inc/class_dbo.inc.php';



$pageID = 'home';
include '_html_head.php';



// get data from db
// ----------------
$rs_posts = new DBO(...$db_access);
$rs_posts->pagination = true;
$rs_posts->pagination_entriesPerPage = 5;

if(isset($_GET['page'])) {
  $rs_posts->pagination_currentPage = $_GET['page'];
}

$rs_posts
  ->_cols('posts.ID, posts.created, posts.img, posts.headline, posts.abstract, categories.category')
  ->_from('posts')
  ->_leftjoin('categories', 'categories.ID = posts.category')
  ->_where('posts.online = ?', 1)
  ->_orderby('created DESC')
  ->fetch();

?>



<!-- navigation -->
<?php include '_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <!-- post -->
  <?php



  // prepare divider
  // ---------------
  $html_divider = '';

  while(!$rs_posts->EOF) {

    echo $html_divider;



    // count comments
    // --------------
    $countComments = new DBO(...$db_access);
    $comments = $countComments
      ->_cols('ID')
      ->_from('comments')
      ->_where('articleID = ?', $rs_posts->field('ID'))
      ->do_count();

    ($comments == 1)
    ? $comments_label = 'Kommentar'
      : $comments_label = 'Kommentare';

  ?>

  <div class="c-post">

    <img class="c-post__image" src="images/<?php echo $rs_posts->field('img'); ?>_small.jpg"
         srcset="images/content/<?php echo $rs_posts->field('img'); ?>_s.jpg 768w,
                 images/content/<?php echo $rs_posts->field('img'); ?>_m.jpg 1024w,
                 images/content/<?php echo $rs_posts->field('img'); ?>_l.jpg 1200w"
         sizes="(min-width: 990px) 68vw, 89vw"
         alt="<?php echo $rs_posts->field('headline'); ?>">

    <div class="c-post__time">
      <time datetime="<?php echo $rs_posts->field('created'); ?>"><?php echo date("d.m.Y", strtotime($rs_posts->field('created'))); ?></time>
      | web<span class="u-color-primary">art</span>elier | Björn
    </div>

    <a class="c-post__headline c-post__headline--link" href="post.php?ID=<?php echo $rs_posts->field('ID'); ?>"><?php echo $rs_posts->field('headline'); ?></a>



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
          <a class="c-meta__link" href="javascript:;"><?php echo $comments.' '.$comments_label; ?></a>
        </div>
      </div>
      <!-- post meta -->



      <!-- post content -->
      <div class="c-post__content">

        <div class="c-post__abstract">
          <p><?php echo $rs_posts->field('abstract'); ?></p>

          <a class="c-post__more" href="post.php?ID=<?php echo $rs_posts->field('ID'); ?>">weiterlesen &#10095;</a>
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
