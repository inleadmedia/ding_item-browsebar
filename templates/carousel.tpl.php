<?php
/**
 * @file
 */
?>
<?php if ($carousel_items): ?>
  <div id="carousel-wrapper">
    <div id="carousel">
      <div class="carousel-header">
        <div id="carousel-search-tabs"><?php echo theme('carousel_views', array('views' => $views)); ?></div>
        <h2><?php print t($views[0]['title']); ?></h2>
      </div>
      <div class="carousel-content">
        <div id="carousel-content">
          <?php print $carousel_items; ?>
        </div>
      </div>
      <div class="carousel-footer">
        <div id="carousel-pager"></div>
      </div>
    </div>
  </div>
<?php else: ?>
  <h3 style="text-align: center; color: #fff;"><?php print t('No keyword specified.') ?></h3>
<?php endif; ?>
