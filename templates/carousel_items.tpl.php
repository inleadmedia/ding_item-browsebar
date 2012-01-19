<?php
/**
 * @file
 *
 */
?>

<?php if ($carousel_items) :
  easybase_browsebar_create_missed_covers($carousel_items);
  $k = 0;
  foreach ($carousel_items as $i => $item) :
    /**
     * @todo: replace Danish used in t() with English
     */
    $stars = '';
    $image_base_path = '/' . drupal_get_path('module', 'easybase_browsebar') . '/images/';
    for ($j = 0; $j < 5; $j++) {
      $stars .= '<img src="' . $image_base_path . 'star-' . (($j < $item->rating) ? 'on' : 'off') . '.png" width="15" height="15" alt="" />';
    }
  ?>
  <div class="result-item inactive">
    <?php
    $image_vars = array(
      'style_name' => 'ding_large',
      'path' => $item->image,
      'getsize' => TRUE,
      'attributes' => array('class' => 'thumb'),
    );
    if ($item->image == easybase_browsebar_default_image()) {
      echo theme('image', $image_vars);
    }
    else {
      echo theme('image_style', $image_vars);
    }

    $title = $title_sm = $title_lr = $item->title;

    if (drupal_strlen($title) > TITLE_LARGE) {
      $title_lr = drupal_substr($title, 0, TITLE_LARGE);
    }

    if (drupal_strlen($title) > TITLE_SMALL) {
      $title_sm = drupal_substr($title, 0, TITLE_SMALL);
    }
    ?>
    <div class="item-details">
      <p class="title"><?php print $title_sm ?></p>
      <p class="creator"><?php print isset($item->creator) ? t('By') . ' ' . $item->creator : '' ?></p>
    </div>
    <div class="result-item-details">
      <h1><?php print l($title,'ting/object/' . $item->id, array('attributes' => array('title' => $item->title, 'alt' => $item->title))) ?></h1>
      <div class="author">
        <?php if (isset($item->creator)): ?>
          <?php print t('By') ?> <span class="creator"><?php print $item->creator ?></span> <?php print $item->year ? "({$item->year})" : '' ?>
        <?php endif; ?>
      </div>
      <?php

      $description = is_array($item->description) ? join(', ', $item->description) : $item->description;

      if (drupal_strlen($description) > DESCRIPTION_SMALL) {
        $description = drupal_substr($description, 0, DESCRIPTION_SMALL) . '...';
      }

      ?>
      <div class="description"><?php print $description; ?></div>
      <div class="subject"><span class="hightlight"><?php print t('Subjects') ?>: </span><?php print $item->subject ?></div>
      <div class="stats">
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
      </div>
    </div>
  </div>
  <?php endforeach; ?>
<?php endif; ?>
