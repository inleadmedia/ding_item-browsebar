<?php if ($carousel_items): ?>
<div id="carousel-wrapper">
  <div id="carousel">
    <div id="carousel-bar-filter">
      <?php
        echo theme('browserbar_filter', array('facets' => $facets, 'tab' => 0));
      ?>
    </div>
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
    <div id="carousel-content">
      <?php print $carousel_items; ?>
    </div>
    <a id="prev" href="#"></a>
    <a id="next" href="#"></a>
    <a href="#" class="carousel-close"><img src="/<?php print drupal_get_path('theme', 'easyting'); ?>/images/carousel-close.png" width="57" height="24" alt="" /></a>
    <?php echo $views; ?>
  </div>
  <div id="carousel-bar"></div>
</div>
<?php else: ?>
<h3 style="text-align: center; color: #fff;"><?php print t('No keyword specified.') ?></h3>
<?php endif; ?>
