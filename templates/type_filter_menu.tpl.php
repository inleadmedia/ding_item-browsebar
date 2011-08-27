<?php
/**
 * @file
 *
 */
?>    
<div class="nav" id="secondary-nav">
  <?php
    $images = array('icons/book.png', 'icons/movie.png', 'icons/music.png', 'icons/cd.png');
    echo '<ul id="s-nav">';
    $i = 0;

    foreach ($menu as $key => $value) {
      echo '<li>
        <img src="/' . drupal_get_path('theme', 'easyting') . '/images/' . $images[$i] . '" width="16" height="16"  alt="" />
        <a href="' . $value['href'] . '" class="use-ajax">' . $value['title'] . '</a>';

      // We don't need a separator after last item
      if ($i < 3) {
        echo '<img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="24"  alt="" />';
      }
      echo '</li>';
      $i++;
    }
    echo '</ul>';
  ?>
</div>
