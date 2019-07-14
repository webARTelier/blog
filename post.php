<!-- page head -->
<?php

$pageID = 'blog';
include '_html_head.php';

?>
<!-- end page head -->



<?php

$showPost = false;

if(isset($_GET['ID'])) {



  // get post from db
  // ----------------
  $rs_post = new DBO(...$db_access);
  $rs_post
    ->_cols('ID, created, category, abstract, headline, text')
    ->_from('posts')
    ->_where('ID = ?', $_GET['ID'])
    ->fetch();

  // post exists? show content
  // -------------------------
  if(!$rs_post->EOF) {
    $showPost = true;
  }



  // get comments for current post
  // -----------------------------
  $rs_comments = new DBO(...$db_access);
  $rs_comments
    ->_cols('ID, created, replyTo, input_name, input_comment')
    ->_from('comments')
    ->_where('articleID = ?', $_GET['ID'])
    ->_orderby('created')
    ->fetch();



  // sort comments and replies
  // -------------------------
  $comments_sorted = [];
  $exclude = [];

  while(!$rs_comments->EOF) {

    if(!in_array($rs_comments->rs_currow, $exclude)) {
      $comments_sorted[] = $rs_comments->recordset[$rs_comments->rs_currow];
      $replies = $rs_comments->find_rows('replyTo', $rs_comments->field('ID'));

      if(!empty($replies)) {
        foreach($replies AS $reply) {
          $comments_sorted[] = $rs_comments->recordset[$reply];
          $exclude[] = $reply;
        }
      }
    }

    echo '<pre>';
    print_r($comments_sorted);
    echo '</pre>';
    echo '<hr>';

    $rs_comments->move_next();
  }
}

?>



<!-- navigation -->
<?php //include '_html_navigation.php'; ?>
<!-- end navigation -->



<!-- page content -->
<div class="l-content">



  <?php

  if($showPost) {

  ?>
  <!-- post -->
  <div class="c-post">

    <img class="c-post__image" src="images/post_small.jpg"
         srcset="images/post_small.jpg 768w,
                 images/post_medium.jpg 1024w,
                 images/post_large.jpg 1200w"
         sizes="(min-width: 990px) 68vw, 89vw"
         alt="Image">

    <div class="c-post__time">
      <time datetime="<?php echo $rs_post->field('created'); ?>"><?php echo date("d.m.Y", strtotime($rs_post->field('created'))); ?></time>
      | WEB<span class="u-color-primary">ART</span>ELIER
    </div>

    <a href="javascript:;">
      <h1 class="c-post__headline" ><?php echo $rs_post->field('headline'); ?></h1>
    </a>



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

        <div class="c-post__abstract"><p><?php echo $rs_post->field('abstract'); ?></p></div>
        <div class="c-post__text"><?php echo $rs_post->field('text'); ?></div>



        <!-- comments -->
        <div class="l-comments js-shiftFormHome">

          <h3 class="c-comments__title u-spaceTop">Drei Kommentare</h3>



          <!-- comment -->
          <div class="c-comment" data-id="1">
            <div class="c-comment__avatar">
              <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
            </div>

            <div class="c-comment__content">
              <div class="c-comment__author">ocean king royal jelly</div>
              <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
              <div class="c-comment__text js-shiftFormAnchor">
                <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
              </div>



              <div class="c-divider c-divider--small"></div>



              <!-- comment -->
              <div class="c-comment" data-id="2">
                <div class="c-comment__avatar">
                  <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
                </div>

                <div class="c-comment__content">

                  <div class="c-comment__author">ocean king royal jelly</div>
                  <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
                  <div class="c-comment__text js-shiftFormAnchor">
                    <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                    <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
                  </div>

                  <div class="c-divider c-divider--small"></div>



                  <!-- comment -->
                  <div class="c-comment" data-id="3">
                    <div class="c-comment__avatar">
                      <svg class="c-comment__icon"><use xlink:href="images/icons.svg#icon-user"></use></svg>
                    </div>

                    <div class="c-comment__content">

                      <div class="c-comment__author">ocean king royal jelly</div>
                      <div class="c-comment__date">01.03.2019 um 0:43 Uhr</div>
                      <div class="c-comment__text js-shiftFormAnchor">
                        <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
                        <a class="c-comment__reply js-shiftForm" href="javascript:;">antworten →</a>
                      </div>

                    </div>
                  </div>
                  <!-- end comment -->

                </div>
              </div>
              <!-- end comment -->

            </div>
          </div>
          <!-- end comment -->



          <!-- comment form -->
          <form id="target-comment" class="js-prefill js-shiftableForm">

            <div class="c-divider c-divider--small"></div>

            <h3 class="c-comments__title">
              Kommentar&nbsp;
              <span class="c-button c-button--small is-hidden js-shiftbackForm">cancel</span>
            </h3>

            <label class="c-label" for="input_name">Name*</label>
            <input id="input_name" class="c-input" name="input_name" required>

            <label class="c-label" for="input_comment">Kommentar*</label>
            <textarea id="input_comment" class="c-input" name="input_comment" cols="45" rows="8" maxlength="65525" required></textarea>

            <input id="input_replyTo" name="antwortenTo" value="">
            <input id="input_remark" class="c-input" name="input_remark">

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
