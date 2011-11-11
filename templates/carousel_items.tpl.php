<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items): ?>
  <?php 
  $k = 0;
  foreach ($carousel_items as $i => $item): ?>
  <?php  
    /**
     * @todo: replace Danish used in t() with English
     */
    $stars = '';
    $image_base_path = '/' . drupal_get_path('theme', 'easyting') . '/images/';
    for ($j = 0; $j < 5; $j++):
      $stars .= '<img src="' . $image_base_path . 'carousel-star-' . (($j < $item->rating) ? 'on' : 'off') . '.png" width="15" height="15" alt="" />';
    endfor;
  ?>

  <div class="result-item <?php print (($k++ == 2) ? 'active' : 'inactive') ?>">
    <?php 
    if (isset($item->image)) {
      echo theme('image_style', 
             array('style_name' => 'ding_medium', 
                 'path' => $item->image, 
                 'getsize' => TRUE, 
                 'attributes' => array('class' => 'thumb', 'width' => '120', 'height' => '160')));
    } else {
      echo '<img src="' . $image_base_path . 'ting_item.jpg" width="120" height="160" alt=""/>';
    }
    ?>
    <?php
      $title = (drupal_strlen($item->title) > 20) ? drupal_substr($item->title, 0, 20) . '...' : $item->title;
    ?>
    <p class="title"><?php print $title ?></p>
    <p class="creator"><?php print isset($item->creator) ? $item->creator : '' ?></p>
    <div class="item-overlay"></div>
    <div class="item-overlay-details">
      <p class="title"><?php print $title ?></p>
      <p class="creator"><?php isset($item->creator) ? print t('Af') . ' ' .  $item->creator : '' ?></p>
    </div>
    <div class="result-item-details">
      <h1><?php print l($item->title,'ting/object/' . $item->id) ?></h1>
      <p>
        <?php if (isset($item->creator)): ?>
          <?php print t('Af') ?> <span class="creator"><?php print $item->creator ?></span> <?php print $item->year ? "({$item->year})" : '' ?>
        <?php endif; ?>
      </p>
      <p class="description"><?php print is_array($item->description) ? join(', ', $item->description) : $item->description ?></p>
      <p class="subject"><span class="hightlight"><?php print t('Emner') ?>: </span><?php print $item->subject ?></p>
      <p class="stats">
        <span class="rating-label">Rating: </span><?php print $stars ?><span class="rating-count">(<?php print $item->rating_count ?>)</span>
        <span class="comment-count"><?php print t('Anmeldelser') ?>(<?php print $item->comment_count ?>)</span>
      </p>
    </div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>
