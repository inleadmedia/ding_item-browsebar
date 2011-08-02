<?php drupal_add_js(drupal_get_path('theme', 'easyting') . '/js/jquery.carouFredSel-4.3.3.js', 'file'); ?>

<div id="carousel-wrapper">
  <div id="carousel">
    <div id="foo">
      <?php print $carousel_items; ?>
    </div>
    <div id="carousel_pager"></div>
    <a id="prev" href="#">Prev</a>
    <a id="next" href="#">Next</a>
  </div>
</div>