<?php

include '../inc/config.inc.php';



// get open comments
// -----------------
$rs_comments_nav = new DBO(...$db_access);
$rs_comments_nav
  ->_cols('ID, created, input_name, input_comment')
  ->_from('comments')
  ->_where('online = ?', 1)
  ->_and('articleID = ?', $_GET['ID'])
  ->_orderby('created ASC')
  ->fetch();




?>
<div class="c-nav c-nav--admin">
  <div class="c-nav__scrollable">



    <!-- tab navigation -->
    <div class="c-tabNav c-tabNav--admin">
      <div class="c-tabNav__item c-tabNav__item--admin js-chooseTab is-active" data-tabtarget="#mainMenu">
        <svg class="c-tabNav__icon c-tabNav__icon--admin"><use xlink:href="../images/icons.svg#icon-menu"></use></svg>
      </div>
      <div class="c-tabNav__item c-tabNav__item--admin js-chooseTab" data-tabtarget="#asideMenu">
        <svg class="c-tabNav__icon  c-tabNav__icon--admin"><use xlink:href="../images/icons.svg#icon-bubble"></use></svg>
      </div>
    </div>
    <!-- end tab navigation -->



    <!-- tab content item -->
    <div id="mainMenu" class="c-tab js-tabContent is-active">
      <div class="c-nav__items">
        <a class="c-logo" href="javascript:;">
          <div class="c-logo__admin">Admin</div>
        </a>

        <a class="c-nav__link c-nav__link--admin blog" href="admin_start.php">posts</a>
        <a class="c-nav__link c-nav__link--admin about" href="javascript:;">über mich</a>
      </div>
    </div>
    <!-- end tab content item -->



    <!-- tab content item -->
    <div id="asideMenu" class="c-tab js-tabContent">
      <div class="c-nav__items">

        <div class="c-nav__item">
          <h2 class="c-nav__title c-nav__title--admin">kommentare</h2>

          <?php
          while(!$rs_comments_nav->EOF) {

            (strlen($rs_comments_nav->field('input_comment')) > 70)
            ? $ellipsis = '&nbsp;…'
              : $ellipsis = '';

            echo '<a class="c-nav__link c-nav__link--admin" ';
            echo 'href="admin_comment.php?comment='.$rs_comments_nav->field('ID').'">';
            echo $rs_comments_nav->field('input_name').':<br>';
            echo mb_substr($rs_comments_nav->field('input_comment'), 0, 70).$ellipsis;
            echo '</a>';

            $rs_comments_nav->move_next();
          }
          ?>

        </div>

      </div>
    </div>
    <!-- end tab content item -->



  </div>
</div>
