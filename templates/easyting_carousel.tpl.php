<?php
/**
 * @file
 *
 */
?>

<?php drupal_add_js(drupal_get_path('theme', 'easyting') . '/js/jquery.carouFredSel-4.3.3.js', 'file'); ?>

<div id="carousel-wrapper">
  <div id="carousel">
    <div id="carousel-menu">
      <h2><?php print t('Seneste bøger'); ?></h2>
      <ul id="carousel-sort">
        <li><a href="#" class="rating"><?php print t('Rating'); ?></a></li>
        <li><a href="#" class="genre"><?php print t('Genre'); ?></a></li>
        <li><a href="#" class="date"><?php print t('Dato'); ?></a></li>
        <li><a href="#" class="free"><?php print t('Udlånt'); ?></a></li>
        <li><a href="#" class="alpha"><?php print t('Alfabetisk'); ?></a></li>
      </ul>
    </div>
    <div id="coverflow">
      <?php print $carousel_items; ?>
    </div>
    <a id="prev" href="#"></a>
    <a id="next" href="#"></a>
    <a href="#" class="carousel-close"><img src="/<?php print path_to_theme(); ?>/images/carousel-close.png" width="57" height="24" alt="" /></a>
  </div>
  <div id="carousel-bar">

    <div id="carousel-bar-filter">
      <div class="popup">
        <ul>
          <li><a href="#1">Børnebøger</a></li>
          <li><a href="#2">Ungdomsbøger</a></li>
          <li><a href="#3">Folkebøger</a></li>
          <li><a class="selected" href="#4">Gysere</a></li>
          <li><a href="#5">Krimier</a></li>
          <li><a href="#6">Noveller</a></li>
          <li><a href="#7">Romaner</a></li>
          <li><a href="#8">Science fiction</a></li>
        </ul>
        <a href="" class="close">
          <div class="icon"></div>
          <div class="text">Close menu</div>
        </a>
      </div>
      <a href="#" class="current open">
        <div class="icon"></div>
        <div class="text"></div>
      </a>
    </div>

    <div id="carousel-pager"></div>
  </div>
</div>
