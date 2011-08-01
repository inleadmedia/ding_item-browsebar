<?php


/* Put Breadcrumbs in a ul li structure */
function easyting_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    $crumbs = '<ul class="breadcrumbs">';
    $array_size = count($breadcrumb);
    $i = 0;
    while ( $i < $array_size) {
      $crumbs .= '<li class="';
      if ($i == 0) {
	$crumbs .= ' home';
      }
      if ($i+1 == $array_size) {
	$crumbs .= ' active';
      }
      $crumbs .=  '">' . $breadcrumb[$i] . '</li>';
      $i++;
    }
    $crumbs .= '</ul>';
    return $crumbs;
  }
}

function easyting_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['#prefix'] = '<div id="search_form">';
    $form['#suffix'] = '</div><div class="clear"></div>';

    $form['actions']['#weight'] = '10';
    $form['search_block_form']['#weight'] = '11';
  }
}

function easyting_preprocess(&$variables, $hook) {
  if ($hook == 'page') {
    // Preprocess main navigation menu
    $menu = menu_navigation_links('menu-easyscreen-main-menu');
    
    $markup = '<ul>';

    foreach($menu as $key => $value) {
      $markup .= '<li>
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>
        <img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="16"  alt="" /></li>';
    }
    
    $markup .= '</ul>';
    $variables['easyting']['main_nav'] = theme('main_nav', array('menu' => $markup));

    // Preprocess secondary navigation menu
    $menu = menu_navigation_links('menu-easyscreen-secondary-menu');

    // This menu contains images... so define them here
    $images = array('icons/book.png', 'icons/movie.png', 'icons/music.png', 'icons/cd.png');
    $markup = '<ul>';
    $i = 0;
    
    foreach($menu as $key => $value) {
      $markup .= '<li>
        <img src="/' . drupal_get_path('theme', 'easyting') . '/images/' . $images[$i] . '" width="16" height="16"  alt="" />
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>';

      // We don't need a separator after last item
      if ($i < 3) {
        $markup .= '<img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="16"  alt="" />';
      }

      $markup .= '</li>';
    
      $i++;
    }

    $markup .= '</ul>';

    $variables['easyting']['secondary_nav'] = theme('secondary_nav', array('menu' => $markup));

    // Preprocess header navigation menu
    /*$menu = menu_navigation_links('menu-easyscreen-header-menu');
    $variables['easyting']['header_nav'] = theme('secondary_nav', $menu);*/
  }
}

function easyting_theme($existing, $type, $theme, $path) {
  $hooks = array();

  $hooks['main_nav'] = array(
    'variables' => array('menu' => NULL),
    'template' => 'easyting_main_nav',
    'path' => $path . '/templates',
  );

  $hooks['secondary_nav'] = array(
    'variables' => array('menu' => NULL),
    'template' => 'easyting_secondary_nav',
    'path' => $path . '/templates',
  );

  $hooks['header_nav'] = array(
    'variables' => array('menu' => NULL),
    'template' => 'easyting_header_nav',
    'path' => $path . '/templates',
  );

  return $hooks;
}


?>
