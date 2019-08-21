<?php

include 'inc/config.inc.php';
include_once 'inc/class_dbo.inc.php';



// get categories
// --------------
$rs_categories_nav = new DBO(...$db_access);
$rs_categories_nav
  ->_cols('ID, category')
  ->_from('categories')
  ->_where('active = ?', 1)
  ->fetch();



// get popular articles
// --------------------
$rs_posts_nav = new DBO(...$db_access);
$rs_posts_nav
  ->_cols('ID, headline, abstract')
  ->_from('posts')
  ->_where('online = ?', 1)
  ->_orderby('calls DESC')
  ->_limit(5)
  ->fetch();



// get comments
// ------------
$rs_comments_nav = new DBO(...$db_access);
$rs_comments_nav
  ->_cols('ID, articleID, input_comment')
  ->_from('comments')
  ->_where('online = ?', 1)
  ->_orderby('created DESC')
  ->_limit(5)
  ->fetch();

?>
<div class="c-nav">
  <div class="c-nav__scrollable">



    <!-- tab navigation -->
    <div class="c-tabNav">
      <div class="c-tabNav__item js-chooseTab is-active" data-tabtarget="#mainMenu">
        <svg class="c-tabNav__icon"><use xlink:href="images/icons.svg#icon-menu"></use></svg>
      </div>
      <div class="c-tabNav__item js-chooseTab" data-tabtarget="#asideMenu">
        <svg class="c-tabNav__icon"><use xlink:href="images/icons.svg#icon-folder"></use></svg>
      </div>
    </div>
    <!-- end tab navigation -->



    <!-- main navigation -->
    <div id="mainMenu" class="c-tab js-tabContent is-active">
      <div class="c-nav__items">
        <a class="c-logo" href="index.php">
          <img class="c-logo__img" src="images/logo_webartelier.svg" alt="webARTelier">
        </a>

        <a class="c-nav__link home" href="index.php">home</a>
        <a class="c-nav__link about"href="javascript:;">über mich</a>
      </div>
    </div>
    <!-- end main navigation -->



    <!-- alternative navigation -->
    <div id="asideMenu" class="c-tab js-tabContent">
      <div class="c-nav__items">

        <!-- categories -->
        <div class="c-nav__item">
          <h2 class="c-nav__title">kategorien</h2>
          <?php

          while(!$rs_categories_nav->EOF) {
            echo '<a class="c-nav__link" href="categories.php?cat='.$rs_categories_nav->field('ID').'">';
            echo $rs_categories_nav->field('category');
            echo '</a>';

            $rs_categories_nav->move_next();
          }

          ?>
        </div>
        <!-- end categories -->

        <!-- last posts -->
        <div class="c-nav__item">
          <h2 class="c-nav__title">beliebteste posts</h2>
          <?php

          while(!$rs_posts_nav->EOF) {
            echo '<a class="c-nav__link" href="post.php?ID='.$rs_posts_nav->field('ID').'">';
            echo $rs_posts_nav->field('headline');
            echo '</a>';

            $rs_posts_nav->move_next();
          }

          ?>
        </div>
        <!-- end last posts -->

        <!--  last comments -->
        <div class="c-nav__item">
          <h2 class="c-nav__title">letzte kommentare</h2>
          <?php

          while(!$rs_comments_nav->EOF) {

            (strlen($rs_comments_nav->field('input_comment')) > 70)
            ? $ellipsis = '&nbsp;…'
              : $ellipsis = '';

            echo '<a class="c-nav__link" href="post.php?ID='
              .$rs_comments_nav->field('articleID')
              .'#comment'.$rs_comments_nav->field('ID').'">';
            echo mb_substr($rs_comments_nav->field('input_comment'), 0, 70).$ellipsis;
            echo '</a>';

            $rs_comments_nav->move_next();
          }

          ?>
        </div>
        <!-- end last comments -->

      </div>
    </div>
    <!-- end alternative navigation -->



  </div>
</div>
