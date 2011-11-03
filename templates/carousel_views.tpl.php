<?php
/**
 * @file
 * 
 */
?>
<ul class="search-controller">
  <?php foreach ($views as $i => $view) : ?>
  <li class="<?php echo ($i == 0) ? 'active' : ''; ?>">
    <a href="#"><?php echo $view['title'] ?></a>
  </li>
  <?php endforeach; ?>
</ul>
