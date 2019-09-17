<?php

session_start();

include 'inc/config.inc.php';
include 'inc/func.inc.php';
include 'inc/class_dbo.inc.php';



$pageID = 'blog';
include '_html_head.php';



// -------------------------------------------------------------------



// submitted comment?
// ------------------
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  // robot entry?
  // ------------
  if(empty($_POST['email'])) {



    include 'inc/class_gump.inc.php';



    // sanitize submitted data
    // -----------------------
    unset($_POST['email']);

    $gump = new GUMP();
    $_POST_sanitized = $gump->sanitize($_POST);



    // validate submitted data
    // -----------------------
    $gump->validation_rules(array(
      'articleID'                => 'required',
      'input_name'        => 'required',
      'input_comment'     => 'required'
    ));



    // trim/sanitize submitted data
    // ----------------------------
    $gump->filter_rules(array(
      'articleID'         => 'trim|sanitize_numbers',
      'input_name'        => 'trim|sanitize_string',
      'input_comment'     => 'trim|sanitize_string'
    ));



    // set field description label for error handling
    // ----------------------------------------------
    GUMP::set_field_name('input_name', 'Name');
    GUMP::set_field_name('input_comment', 'Kommentar');



    $_POST_validated = $gump->run($_POST_sanitized);



    // validation successful
    // ---------------------
    if($_POST_validated) {

      // add current date and store data in db
      // -------------------------------------
      $_POST_validated['created'] = date("Y-m-d H:i:s");
      $store_comment = new DBO(...$db_access);
      $store_comment->store($_POST_validated, 'comments');

      // prepare message
      // ---------------
      $_SESSION['modal'] = array(
        'headline'    => 'Moment noch …',
        'message'     => 'Vielen Dank! Dein Kommentar ist wohlbehalten angekommen. Da wir alle keinen Spam mögen, wird jeder Kommentar „von Hand“ freigeschaltet &ndash; natürlich so schnell wie möglich!<br><br>Vielen Dank für dein Verständnis!'
      );
    }



    // validation failed
    // -----------------
    $errors = $gump->get_readable_errors(true);
  }
}



// -------------------------------------------------------------------



// get requested post
// ------------------
$showPost = false;

if(isset($_GET['ID'])) {



  // get post from db
  // ----------------
  $rs_post = new DBO(...$db_access);
  $rs_post
    ->_cols('ID, created, img, category, abstract, headline, text')
    ->_from('posts')
    ->_where('ID = ?', $_GET['ID'])
    ->fetch();

  // post exists? show content
  // -------------------------
  if(!$rs_post->EOF) {
    $showPost = true;
  }



  if($showPost) {



    // count call for current post
    // ---------------------------
    $countCall = new DBO(...$db_access);
    $countCall
      ->_cols('calls')
      ->_from('posts')
      ->_where('ID = ?', $_GET['ID'])
      ->fetch();

    $updateCalls = array('calls' => $countCall->field('calls') + 1);
    $countCall->update($updateCalls, 'posts', 'ID', $_GET['ID']);



    // get comments for current (existing) post
    // ----------------------------------------
    $rs_comments = new DBO(...$db_access);
    $rs_comments
      ->_cols('ID, created, replyTo, input_name, input_comment')
      ->_from('comments')
      ->_where('articleID = ?', $_GET['ID'])
      ->_and('online = ?', 1)
      ->_orderby('created')
      ->fetch();

    $numbers = array('Noch keine', 'Ein', 'Zwei', 'Drei', 'Vier', 'Fünf', 'Sechs', 'Sieben', 'Acht', 'Neun', 'Zehn', 'Elf', 'Zwölf');

    (array_key_exists($rs_comments->rs_totalrows, $numbers))
    ? $label_number = $numbers[$rs_comments->rs_totalrows]
      : $label_number = $rs_comments->rs_totalrows;

    ($rs_comments->rs_totalrows != 1)
    ? $label_headline = 'Kommentare'
      : $label_headline = 'Kommentar';
  }
}
?>



<!-- navigation -->
<?php include '_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <?php

  if($showPost) {

  ?>
  <!-- post -->
  <div class="c-post">

    <img class="c-post__image" src="images/<?php echo $rs_post->field('img'); ?>_small.jpg"
         srcset="images/content/<?php echo $rs_post->field('img'); ?>_s.jpg 768w,
                 images/content/<?php echo $rs_post->field('img'); ?>_m.jpg 1024w,
                 images/content/<?php echo $rs_post->field('img'); ?>_l.jpg 1200w"
         sizes="(min-width: 990px) 68vw, 89vw"
         alt="<?php echo $rs_post->field('headline'); ?>">

    <div class="c-post__time">
      <time datetime="<?php echo $rs_post->field('created'); ?>"><?php echo date("d.m.Y", strtotime($rs_post->field('created'))); ?></time>
      | web<span class="u-color-primary">art</span>elier | Björn
    </div>

    <h1 class="c-post__headline" ><?php echo $rs_post->field('headline'); ?></h1>



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

        <div class="c-post__abstract"><?php echo nl2br($rs_post->field('abstract')); ?></div>
        <div class="c-post__text"><?php echo nl2p($rs_post->field('text')); ?></div>



        <!-- comments -->
        <div class="l-comments js-shiftFormHome">

          <h3 class="c-comments__title u-spaceTop">
            <?php echo $label_number.' '.$label_headline; ?>
          </h3>

          <?php

    $divider = '';

    while(!$rs_comments->EOF) {

      echo $divider;

          ?>
          <!-- comment -->
          <div id="comment<?php echo $rs_comments->field('ID'); ?>" class="c-comment" data-id="<?php echo $rs_comments->field('ID'); ?>">
            <div class="c-comment__avatar">
              <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
            </div>

            <div class="c-comment__content">
              <div class="c-comment__author"><?php echo $rs_comments->field('input_name'); ?></div>
              <time class="c-comment__date" datetime="<?php echo $rs_comments->field('created'); ?>">
                <?php echo date("d.m.Y", strtotime($rs_comments->field('created'))); ?> um
                <?php echo date("H:i:s", strtotime($rs_comments->field('created'))); ?> Uhr
              </time>
              <div class="c-comment__text js-shiftFormAnchor">
                <p><?php echo nl2br($rs_comments->field('input_comment')); ?></p>
              </div>

            </div>
          </div>
          <!-- end comment -->

          <?php

      $divider = '<div class="c-divider c-divider--small"></div>';
      $rs_comments->move_next();
    }

          ?>



          <!-- comment form -->
          <form id="target-comment" class="js-form js-prefill js-shiftableForm" action="<?php echo $_SERVER['PHP_SELF'].'?ID='.$_GET['ID']; ?>" method="post">

            <div class="c-divider c-divider--small"></div>

            <h3 class="c-comments__title">Kommentar</h3>

            <?php if(isset($errors)) { echo $errors; } ?>

            <label class="c-label" for="input_name">Name*</label>
            <input id="input_name" class="c-input" name="input_name" required>

            <label class="c-label" for="input_comment">Kommentar*</label>
            <textarea id="input_comment" class="c-input" name="input_comment" rows="8" maxlength="65525" required></textarea>

            <input type="hidden" name="email">
            <input type="hidden" name="articleID" value="<?php echo $rs_post->field('ID'); ?>">

            <button class="c-button js-submit">
              <span class="c-button__flex">
                <span class="c-button__text">abschicken</span>
                <svg class="c-button__icon"><use xlink:href="images/icons.svg#icon-plane"></use></svg>
              </span>
            </button>

          </form>
          <!-- end comment form -->

        </div>
        <!-- end comments -->

      </div>
      <!-- end post content -->

    </div>
    <!-- end wrapper meta/post content -->

  </div>
  <!-- end post -->



  <!-- link 'back to overview' -->
  <a class="c-homelink" href="index.php">&#10094; zurück zur Übersicht</a>
  <!-- end link 'back to overview' -->



  <?php } else { ?>
  <!-- post does not exist -->
  <div class="c-post__headline">Oooops! Dieser Artikel<br>existiert leider nicht …</div>
  <p><a class="c-post__more" href="index.php">&#8592; zurück zur Übersicht</a></p>
  <!-- end post does not exist -->
  <?php } ?>



</div>
<!-- end page content -->



<!-- page footer -->
<?php include '_html_footer.php'; ?>
<!-- end page footer -->
