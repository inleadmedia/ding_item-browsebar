<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items): ?>
<div id="browsebar-wrapper">
  <div id="browsebar">
    <div class="browsebar-header">
      <div class="browsebar-header-left">
        <div id="browsebar-menu">
          <h2><?php print t($views[0]['title']); ?></h2>
          <ul id="browsebar-sort" style="display: none;">
            <li><a href="#" class="rating"><?php print t('Rating'); ?></a></li>
            <li><a href="#" class="genre"><?php print t('Genre'); ?></a></li>
            <li><a href="#" class="date"><?php print t('Date'); ?></a></li>
            <li><a href="#" class="free"><?php print t('On loan'); ?></a></li>
            <li><a href="#" class="alpha"><?php print t('Alphabetical'); ?></a></li>
          </ul>
        </div>
      </div>
      <div class="browsebar-header-middle">
        <div id="browsebar-pager"></div>
      </div>
      <div class="browsebar-header-right">
        <div id="browsebar-bar-filter">
          <?php echo theme('browsebar_facet_filter', array('keyword' => $keyword, 'facets' => $facets)); ?>
        </div>
      </div>
    </div>
    <div id="browsebar-content">
      <?php print $carousel_items; ?>
    </div>
    <a class="scroll" id="prev" href="#"></a>
    <a class="scroll" id="next" href="#"></a>
  </div>
  <div id="browsebar-bar">
    <div class="browsebar-bar">
      <?php echo theme('browsebar_views', array('views' => $views)); ?>
      <a href="#" class="browsebar-display close"></a>
    </div>
  </div>
</div>
<?php else: ?>
<h3 style="text-align: center; color: #fff;"><?php print t('No keyword specified.') ?></h3>
<?php endif; ?>
