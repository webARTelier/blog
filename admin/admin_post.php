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



// submitted post?
// ---------------
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $storePost = new DBO(...$db_access);
  $storePost->store($_POST, 'posts');

  // inserted new post?
  // ------------------
  if($insert_lastID != '') {

  }
}



// get requested post
// ------------------
$showPost = false;

if(isset($_GET['ID'])) {



  // get post from db
  // ----------------
  $rs_post = new DBO(...$db_access);
  $rs_post
    ->_cols('ID, created, category, online, img, abstract, headline, text')
    ->_from('posts')
    ->_where('ID = ?', $_GET['ID'])
    ->fetch();

  $checked_online = '';
  if($rs_post->field('online') == 1) {
    $checked_online = ' checked';
  }

  // post exists? show content
  // -------------------------
  if(!$rs_post->EOF) {
    $showPost = true;
  }



  // get categories from db
  // ----------------------
  $rs_categories = new DBO(...$db_access);
  $rs_categories
    ->_cols('ID, category')
    ->_from('categories')
    ->_where('ID > ?', 0)
    ->fetch();
}

include '_admin_html_head.php';
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

      <input class="c-input c-input--admin" name="img" value="<?php echo $rs_post->field('img'); ?>" placeholder="Bildname">

      <input class="c-input c-input--admin u-spaceTop" name="date" value="<?php echo $rs_post->field('created'); ?>" placeholder="Datum/Uhrzeit">

      <div class="c-post__headline">
        <input class="c-input c-input--admin" name="headline" value="<?php echo $rs_post->field('headline'); ?>" placeholder="Überschrift">
      </div>



      <!-- wrapper meta/post content -->
      <div class="c-post__wrapper">

        <!-- post meta -->
        <div class="c-meta">

          <div class="c-meta__item">
            <svg class="c-meta__icon"><use xlink:href="../images/icons.svg#icon-list"></use></svg>
            <div class="c-meta__link">
              <select class="c-select c-input--admin" name="category">
                <?php
    while(!$rs_categories->EOF) {
      echo '<option value="'.$rs_categories->field('ID').'">'.$rs_categories->field('category').'</option>';
      $rs_categories->move_next();
    }
                ?>
              </select>
            </div>
          </div>

          <div class="c-meta__item">
            <div class="c-meta__link">
              <input name="online" type="hidden" value ="0">
              <input id="online" class="c-checkbox" name="online" type="checkbox" value="1" <?php echo $checked_online; ?>>
              <label class="c-checkbox__label" for="online">online</label>
            </div>
          </div>

        </div>
        <!-- end post meta -->



        <!-- post content -->
        <div class="c-post__content">

          <div class="c-post__abstract">
            <textarea class="c-input c-input--admin js-autogrow" placeholder="Abstract"><?php echo $rs_post->field('abstract'); ?></textarea>
          </div>


          <div class="c-post__text">
            <textarea class="c-input c-input--admin js-autogrow" placeholder="Text"><?php echo $rs_post->field('text'); ?></textarea>
          </div>

          <input type="hidden" name="ID" value="<?php echo $rs_post->field('ID'); ?>">

          <button class="c-button js-submit">
            <span class="c-button__flex">
              <span class="c-button__text">eintragen</span>
              <svg class="c-button__icon"><use xlink:href="../images/icons.svg#icon-plane"></use></svg>
            </span>
          </button>

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
