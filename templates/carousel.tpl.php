<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items): ?>
<div id="carousel-wrapper">
  <div id="carousel">
    <div class="carousel-header">
      <div class="carousel-header-left">
        <div id="carousel-menu">
          <h2><?php print t($views[0]['title']); ?></h2>
          <ul id="carousel-sort" style="display: none;">
            <li><a href="#" class="rating"><?php print t('Rating'); ?></a></li>
            <li><a href="#" class="genre"><?php print t('Genre'); ?></a></li>
            <li><a href="#" class="date"><?php print t('Dato'); ?></a></li>
            <li><a href="#" class="free"><?php print t('Udlånt'); ?></a></li>
            <li><a href="#" class="alpha"><?php print t('Alfabetisk'); ?></a></li>
          </ul>
        </div>
      </div>
      <div class="carousel-header-middle">
        <div id="carousel-pager"></div>
      </div>
      <div class="carousel-header-right">
        <div id="carousel-bar-filter">
          <?php
            echo theme('browserbar_filter', array('facets' => $facets, 'tab' => 0));
          ?>
        </div>
      </div>
    </div>
    <div id="carousel-content">
      <?php print $carousel_items; ?>
    </div>
    <a class="scroll" id="prev" href="#"></a>
    <a class="scroll" id="next" href="#"></a>
    <a href="#" class="carousel-close"></a>
  </div>
  <div id="carousel-bar"><?php echo theme('carousel_views', array('views' => $views)); ?></div>
</div>
<?php else: ?>
<h3 style="text-align: center; color: #fff;"><?php print t('No keyword specified.') ?></h3>
<?php endif; ?>
