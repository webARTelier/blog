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



// delete comment
// --------------
if(isset($_GET['del'])) {
  $delete = new DBO(...$db_access);
  $delete->delete_row('comments', $_GET['del']);
}



// -------------------------------------------------------------------



// put comment online
// ------------------
if(isset($_GET['release'])) {

  // set online = 1
  // --------------
  $releaseData = array('online' => 1);
  $release = new DBO(...$db_access);
  $release->update($releaseData, 'comments', 'ID', $_GET['release']);

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
  ->_cols('comments.ID, comments.online, comments.created, comments.replyTo AS reply, comments.input_name, comments.input_comment, posts.headline AS post')
  ->_from('comments')
  ->_where('comments.ID = ?', $requestedComment)
  ->_leftjoin('posts', 'posts.ID = comments.articleID')
  ->fetch();



include '_admin_html_head.php';
?>



<!-- navigation -->
<?php include '_admin_html_navigation_comments.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">
  <div class="c-post">



    <?php if(!$rs_comment->EOF) { ?>

    <h1 class="c-headline__admin c-headline__admin--2">Kommentar zu „<?php echo $rs_comment->field('post'); ?>“</h1>

    <p><strong><?php echo $rs_comment->field('input_name').' | '.date("d.m.Y - H:i:s", strtotime($rs_comment->field('created'))) ?></strong></p>

    <p><?php echo $rs_comment->field('input_comment'); ?></p>

    <a class="c-button js-submit" href="<?php echo $_SERVER['PHP_SELF'].'?release='.$rs_comment->field('ID'); ?>">
      <span class="c-button__flex">
        <span class="c-button__text">freigeben</span>
        <svg class="c-button__icon"><use xlink:href="../images/icons.svg#icon-checked"></use></svg>
      </span>
    </a>

    <a class="c-button js-submit" onclick="return confirm('Wirklich löschen?')" href="<?php echo $_SERVER['PHP_SELF'].'?del='.$rs_comment->field('ID'); ?>">
      <span class="c-button__flex">
        <span class="c-button__text">löschen</span>
        <svg class="c-button__icon"><use xlink:href="../images/icons.svg#icon-close"></use></svg>
      </span>
    </a>

    <?php } else { ?>

    <h1 class="c-headline__admin c-headline__admin--2">Diesen Kommentar gibt es nicht (mehr).</h1>

    <?php } ?>



  </div>
</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_admin_html_footer.php'; ?>
<!-- end page footer -->
