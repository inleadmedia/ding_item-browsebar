<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items): ?>
  <?php 
  carousel_create_missed_covers($carousel_items);
  $k = 0;
  foreach ($carousel_items as $i => $item): ?>
  <?php  
    /**
     * @todo: replace Danish used in t() with English
     */
    $stars = '';
    $image_base_path = '/' . drupal_get_path('module', 'carousel') . '/images/';
    for ($j = 0; $j < 5; $j++):
      $stars .= '<img src="' . $image_base_path . 'star-' . (($j < $item->rating) ? 'on' : 'off') . '.png" width="15" height="15" alt="" />';
    endfor;
  ?>

  <div class="result-item inactive">
    <?php
    $image_vars = array(
      'style_name' => 'ding_large',
      'path' => $item->image,
      'getsize' => TRUE,
      'attributes' => array('class' => 'thumb', 'width' => '120', 'height' => '160'),
    );
    if ($item->image == carousel_default_image()) {
      echo theme('image', $image_vars);
    }
    else {
      echo theme('image_style', $image_vars);
    }

    $title = (drupal_strlen($item->title) > 20) ? drupal_substr($item->title, 0, 20) . '...' : $item->title;
    ?>
    <p class="title"><?php print $title ?></p>
    <p class="creator"><?php print isset($item->creator) ? $item->creator : '' ?></p>
    <div class="item-overlay"></div>
    <div class="item-overlay-details">
      <p class="title"><?php print $title ?></p>
      <p class="creator"><?php isset($item->creator) ? print t('By') . ' ' .  $item->creator : '' ?></p>
    </div>
    <div class="result-item-details">
    <?php
      $title = (drupal_strlen($item->title) > 40) ? drupal_substr($item->title, 0, 40) . '...' : $item->title;
    ?>

      <h1><?php print l($title,'ting/object/' . $item->id, array('attributes' => array('title' => $item->title))) ?></h1>
      <p>
        <?php if (isset($item->creator)): ?>
          <?php print t('By') ?> <span class="creator"><?php print $item->creator ?></span> <?php print $item->year ? "({$item->year})" : '' ?>
        <?php endif; ?>
      </p>
      <p class="description"><?php print is_array($item->description) ? join(', ', $item->description) : $item->description ?></p>
      <p class="subject"><span class="hightlight"><?php print t('Subjects') ?>: </span><?php print $item->subject ?></p>
      <p class="stats">
        <span class="rating-label"><?php print t('Rating:'); ?> </span><?php print $stars ?><span class="rating-count">(<?php print $item->rating_count ?>)</span>
        <span class="comment-count"><?php print t('User reviews') ?> (<?php print $item->comment_count ?>)</span>
      </p>
    </div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>
