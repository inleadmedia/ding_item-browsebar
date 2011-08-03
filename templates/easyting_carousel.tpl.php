<?php drupal_add_js(drupal_get_path('theme', 'easyting') . '/js/jquery.carouFredSel-4.3.3.js', 'file'); ?>

<div id="carousel-wrapper">
  <div id="carousel">
    <div id="foo">
      <?php print $carousel_items; ?>
    </div>
    <a id="prev" href="#"></a>
    <a id="next" href="#"></a>
  </div>
  <div id="carousel-bar">
    <div id="carousel_pager"></div>
  </div>
</div>