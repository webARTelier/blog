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



// requested post?
// ---------------
$requestedPost = 0;

if(isset($_GET['ID'])) {
  $requestedPost = $_GET['ID'];
}



// -------------------------------------------------------------------



// submitted post?
// ---------------
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $storePost = new DBO(...$db_access);
  $storePost->store($_POST, 'posts');

  // inserted new post?
  // ------------------
  if($storePost->insert_lastID != '') {
    $requestedPost = $storePost->insert_lastID;
  }

  // prepare message
  // ---------------
  $_SESSION['modal'] = array(
    'headline'    => 'Daten übernommen',
    'message'     => 'Die Änderungen wurden in die Datenbank übernommen.'
  );
}



// -------------------------------------------------------------------



// get post from db
// ----------------
$rs_post = new DBO(...$db_access);
$rs_post
  ->_cols('ID, created, category, online, img, abstract, headline, text')
  ->_from('posts')
  ->_where('ID = ?', $requestedPost)
  ->fetch();

($rs_post->field('online') == 1)
?  $checked_online = ' checked'
  : $checked_online = '';



// -------------------------------------------------------------------



// get categories from db
// ----------------------
$rs_categories = new DBO(...$db_access);
$rs_categories
  ->_cols('ID, category')
  ->_from('categories')
  ->_where('ID > ?', 0)
  ->fetch();



// -------------------------------------------------------------------



// get comments for current post
// -----------------------------
$rs_comments = new DBO(...$db_access);
$rs_comments
  ->_cols('ID, created, input_name, input_comment')
  ->_from('comments')
  ->_where('articleID = ?', $requestedPost)
  ->fetch();



include '_admin_html_head.php';
?>



<!-- navigation -->
<?php include '_admin_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <!-- post -->
  <form action="<?php echo $_SERVER['PHP_SELF'].'?ID='.$_GET['ID']; ?>" method="post">
    <div class="c-post">

      <img class="c-post__image" src="../images/<?php echo $rs_post->field('img'); ?>_small.jpg"
           srcset="../images/<?php echo $rs_post->field('img'); ?>_s.jpg 768w,
                   ../images/<?php echo $rs_post->field('img'); ?>_m.jpg 1024w,
                   ../images/<?php echo $rs_post->field('img'); ?>_l.jpg 1200w"
           sizes="(min-width: 990px) 68vw, 89vw"
           alt="<?php echo $rs_post->field('headline'); ?>">

      <input class="c-input c-input--admin" name="img" value="<?php echo $rs_post->field('img'); ?>" placeholder="Bildname">

      <input class="c-input c-input--admin u-spaceTop js-date" name="created" value="<?php echo $rs_post->field('created'); ?>" placeholder="Datum/Uhrzeit">
      <span class="c-setDate js-setDate">Timestamp NOW</span>

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

                  ($rs_categories->field('ID') == $rs_post->field('category'))
                  ? $checked_category = ' selected'
                    : $checked_category = '';

                  echo '<option value="'.$rs_categories->field('ID').'"'.$checked_category.'>'.$rs_categories->field('category').'</option>';
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



</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_admin_html_footer.php'; ?>
<!-- end page footer -->
