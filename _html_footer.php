<div class="l-footer">
  <div class="c-legal">
    <div class="c-legal__item">
      &copy; <?php echo $conf_creationYear != date('Y') ? $conf_creationYear.' &ndash; '.date('Y') : $conf_creationYear; ?>
      web<span class="u-color-primary">art</span>elier</div>
    <div class="c-legal__item">
      <a class="c-legal__link" href="javascript:;">Impressum</a>
    </div>
    <div class="c-legal__item">
      <a class="c-legal__link" href="javascript:;">Datenschutz</a>
    </div>
  </div>
</div>



<?php

// show modal on demand
// --------------------
if(isset($_SESSION['modal'])) {

?>

<!-- modal -->
<div class="c-modal is-visible u-shadow--modal js-modal">
  <div class="c-modal__close js-closeModal">
    <svg class="c-modal__icon"><use xlink:href="images/icons.svg#icon-close"></use></svg>
  </div>
  <?php
  echo '<h2 class="c-modal__headline">'.$_SESSION['modal']['headline'].'</h2>';
  echo '<p>'.$_SESSION['modal']['message'].'</p>';
  ?>
</div>
<!-- end modal 'switch' -->



<!-- overlay for closing modals -->
<div class="c-pageOverlay c-pageOverlay--dark is-visible js-pageOverlay js-closeModal" onclick=""></div>
<!-- end overlay for closing modals -->

<?php

  unset($_SESSION['modal']);

}

?>



<!-- importing required javascripts -->
<script src="js/custom_min.js"></script>



<?php

if($conf_devMode) { ?>
<!-- show viewport size in browser (for development only) -->
<script src="js/dev_pageinfos.js"></script>

<?php } ?>



</body>
</html>
