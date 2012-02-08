<?php
/**
 * @file
 * 
 */
?>
<ul class="search-controller">
  <?php foreach ($views as $i => $view) : ?>
  <li class="<?php echo ($i == 0) ? 'active' : ''; ?>">
    <a class="use-ajax" href="/ding/easybase_browsebar/view/<?php echo $i; ?>"><?php echo $view['title'] ?></a>
  </li>
  <?php endforeach; ?>
</ul>
