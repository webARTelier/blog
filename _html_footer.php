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



<!-- importing required javascripts -->
<script src="js/custom_min.js"></script>



<?php

if($conf_devMode) { ?>
<!-- show viewport size in browser (for development only) -->
<script src="js/dev_pageinfos.js"></script>

<?php } ?>



</body>
</html>
