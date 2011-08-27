  <div class="popup">
    <ul>
    <?php 
    foreach ($facets['facet.subject']->terms as $facet=>$amount) {
      echo '<li><a class="use-ajax" href="/ding/carousel/filter/bog?facet=' . htmlspecialchars($facet) . '">' . htmlspecialchars($facet) . '</a></li>';
    } ?> 
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
