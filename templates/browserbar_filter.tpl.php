  <div class="popup">
    <ul>
    <?php 
    $max_facet_length = 0;
    foreach ($facets['facet.subject']->terms as $facet=>$amount) {
      $max_facet_length = (strlen($facet) > $max_facet_length) ?  strlen($facet) : $max_facet_length;
      echo '<li><a class="use-ajax' . ($active_facet == $facet ? ' active' : '') . '" href="/ding/carousel/filter/bog?facet=' . htmlspecialchars($facet) . '">' . htmlspecialchars($facet) . '</a></li>';
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
  <?php
    // Change this to if styles change!
    $letter_width = 5;
    $paddings = 40;
    drupal_add_js('(function($){$(function(){
      $("#carousel-bar-filter").css("width", "' . ($letter_width * $max_facet_length + $paddings) . '");
    })})(jQuery)', 'inline')
  ?>