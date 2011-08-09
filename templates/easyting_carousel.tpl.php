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
    <div id="carousel-pager"></div>
  </div>
</div>
