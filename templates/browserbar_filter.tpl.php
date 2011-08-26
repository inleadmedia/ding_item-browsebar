  <div class="popup">
    <ul>
    <?php foreach ($facets as $facet_value => $facet_name) { ?>
      <li><a href="#<?php echo $facet_value; ?>"><?php echo $facet_name; ?></a></li>
    <?php } ?>
    </ul>
    <a href="#" class="close">
      <div class="icon"></div>
      <div class="text"><?php echo t('Close menu'); ?></div>
    </a>
  </div>
  <a href="#" class="current open">
    <div class="icon"></div>
    <div class="text"><?php echo t('Filter by...'); ?></div>
  </a>
