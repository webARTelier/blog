<?php

include '_admin_html_head.php';



// get requested post
// ------------------
$showPost = false;

if(isset($_GET['ID'])) {



  // get post from db
  // ----------------
  $rs_post = new DBO(...$db_access);
  $rs_post
    ->_cols('ID, created, category, img, abstract, headline, text')
    ->_from('posts')
    ->_where('ID = ?', $_GET['ID'])
    ->fetch();

  // post exists? show content
  // -------------------------
  if(!$rs_post->EOF) {
    $showPost = true;
  }
}
?>



<!-- navigation -->
<?php include '_admin_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <?php

  if($showPost) {

  ?>
  <!-- post -->
  <form action="<?php echo $_SERVER['PHP_SELF'].'?ID='.$_GET['ID']; ?>" method="post">
    <div class="c-post">

      <img class="c-post__image" src="../images/<?php echo $rs_post->field('img'); ?>_small.jpg"
           srcset="../images/<?php echo $rs_post->field('img'); ?>_small.jpg 768w,
                   ../images/<?php echo $rs_post->field('img'); ?>_medium.jpg 1024w,
                   ../images/<?php echo $rs_post->field('img'); ?>_large.jpg 1200w"
           sizes="(min-width: 990px) 68vw, 89vw"
           alt="<?php echo $rs_post->field('headline'); ?>">
      <input class="c-input c-input--admin" name="img" value="<?php echo $rs_post->field('img'); ?>">

      <input class="c-input c-input--admin u-spaceTop" name="date" value="<?php echo $rs_post->field('created'); ?>">

      <div class="c-post__headline">
        <input class="c-input c-input--admin" name="headline" value="<?php echo $rs_post->field('headline'); ?>">
      </div>



      <!-- wrapper meta/post content -->
      <div class="c-post__wrapper">

        <!-- post meta -->
        <div class="c-meta">
          <div class="c-meta__item">
            <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-list"></use></svg>
            <a class="c-meta__link" href="javascript:;">general</a>
          </div>
          <div class="c-meta__item">
            <svg class="c-meta__icon"><use xlink:href="images/icons.svg#icon-bubble"></use></svg>
            <a class="c-meta__link" href="#target-comment">kommentieren</a>
          </div>
        </div>
        <!-- end post meta -->



        <!-- post content -->
        <div class="c-post__content">

          <div class="c-post__abstract">
            <textarea class="c-input c-input--admin js-textarea"><?php echo $rs_post->field('abstract'); ?></textarea>
          </div>


          <div class="c-post__text">
            <textarea class="c-input c-input--admin js-textarea"><?php echo $rs_post->field('text'); ?></textarea>
          </div>

        </div>
        <!-- end post content -->

      </div>
      <!-- end wrapper meta/post content -->

    </div>
  </form>
  <!-- end post -->



  <?php } else { ?>
  <!-- post does not exist -->
  <div class="c-post__headline">Oooops! Dieser Artikel<br>existiert leider nicht …</div>
  <p><a class="c-post__more" href="index.php">&#8592; zurück zur Übersicht</a></p>
  <!-- end post does not exist -->
  <?php } ?>



</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_admin_html_footer.php'; ?>
<!-- end page footer -->
