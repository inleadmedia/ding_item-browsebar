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
      'style_name' => 'ding_medium',
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

    $title = $item->title;

    if (drupal_strlen($title) > 18) {
      $title = drupal_substr($title, 0, 18) . '...';
    }
    ?>
    <p class="title"><?php print $title ?></p>
    <p class="creator"><?php print isset($item->creator) ? $item->creator : '' ?></p>
    <div class="item-overlay"></div>
    <div class="item-overlay-details">
      <p class="title"><?php print $title ?></p>
      <p class="creator"><?php isset($item->creator) ? print t('By') . ' ' .  $item->creator : '' ?></p>
    </div>
    <div class="result-item-details">
      <h1><?php print l($title,'ting/object/' . $item->id, array('attributes' => array('title' => $item->title, 'alt' => $item->title))) ?></h1>
      <p>
        <?php if (isset($item->creator)): ?>
          <?php print t('By') ?> <span class="creator"><?php print $item->creator ?></span> <?php print $item->year ? "({$item->year})" : '' ?>
        <?php endif; ?>
      </p>
      <?php

      $description = is_array($item->description) ? join(', ', $item->description) : $item->description;

      if (drupal_strlen($description) > 275) {
        $description = drupal_substr($description, 0, 275) . '...';
      }

      ?>
      <p class="description"><?php print $description; ?></p>
      <p class="subject"><span class="hightlight"><?php print t('Subjects') ?>: </span><?php print $item->subject ?></p>
      <p class="stats">
        <span class="rating-label"><?php print t('Rating:'); ?> </span>
        <?php print $stars ?>
        <?php if ((int)$item->rating_count > 0) { ?>
        <span class="rating-count"><?php print '(' . $item->rating_count . ')'; ?></span>
        <?php } ?>
        <span class="comment-count">
          <?php
          $link = t('No user reviews');
          
          if ((int)$item->comment_count > 0) {
            $link = t('User reviews') . '(' . $item->comment_count . ')';
          }

          print l($link, 'ting/object/' . $item->id, array('attributes' => array('target' => '_blank'), 'fragment' => 'top'));
          ?>
        </span>
      </p>
      <div class="clear"></div>
      <div class="item-operations">
        <div class="operation open-item">
          <form action="/ting/object/<?php print $item->id; ?>" target="_blank">
            <input type="submit" value="<?php print t('More information'); ?>" />
          </form>
        </div>
        <div class="operation reserve-item">
            <?php print render(ding_provider_get_form('ding_reservation_reserve_form', new DingReservationReservableEntity($item), TRUE)); ?>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>
