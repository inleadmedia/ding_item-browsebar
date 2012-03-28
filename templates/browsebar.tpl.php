<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items): ?>
<div id="browsebar-wrapper">
  <div id="browsebar">
    <div id="browsebar-content">
      <?php print $carousel_items; ?>
    </div>
    <div id="browsebar-pager"></div>
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
