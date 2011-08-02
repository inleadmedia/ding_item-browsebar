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
    $markup = '<ul id="m-nav">';

    foreach($menu as $key => $value) {
      $markup .= '<li>
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>
        <img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="24"  alt="" /></li>';
    }
    
    $markup .= '</ul>';
    $variables['easyting']['main_nav'] = theme('main_nav', array('menu' => $markup));

    // Preprocess secondary navigation menu
    $menu = menu_navigation_links('menu-easyscreen-secondary-menu');

    // This menu contains images... so define them here
    $images = array('icons/book.png', 'icons/movie.png', 'icons/music.png', 'icons/cd.png');
    $markup = '<ul id="s-nav">';
    $i = 0;
    
    foreach($menu as $key => $value) {
      $markup .= '<li>
        <img src="/' . drupal_get_path('theme', 'easyting') . '/images/' . $images[$i] . '" width="16" height="16"  alt="" />
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>';

      // We don't need a separator after last item
      if ($i < 3) {
        $markup .= '<img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="24"  alt="" />';
      }

      $markup .= '</li>';
    
      $i++;
    }

    $markup .= '</ul>';

    $variables['easyting']['secondary_nav'] = theme('secondary_nav', array('menu' => $markup));

    // Preprocess header navigation menu
    $menu = menu_navigation_links('menu-easyscreen-header-menu');

    $markup = '<ul id="h-nav">';
    $i = 0;

    foreach($menu as $key => $value) {
      $markup .= '<li>
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>';

      // We don't need a separator after last item
      if ($i < 3) {
        $markup .= '<img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="14"  alt="" />';
      }

      if ($i == 3) {
        $markup .= '<a href="#"><img style="float:left; margin: 1px 0 0 5px;" src="/' . drupal_get_path('theme', 'easyting') . '/images/icons/more.png" width="10" height="10"  alt="" /></a>';
      }

      $markup .= '</li>';

      $i++;
    }

    $markup .= '</ul>';

    $variables['easyting']['header_nav'] = theme('header_nav', array('menu' => $markup));
    // @todo
    // Carousel items stub
    $result = array();
    for($i = 0; $i < 6; $i++) {
      $result[$i] = new stdClass();
      $result[$i]->image = 'ting_item.jpg';
      $result[$i]->title = 'Sumobrodre - ' . $i;
      $result[$i]->creator = 'Morten Ramsland';
    }

    // Create items markup
    $markup = '';
    foreach($result as $key => $value) {
      $markup .= '<div class="result-item">';
      $markup .= '<img src="/' . drupal_get_path('theme', 'easyting') . '/images/' . $value->image . '" width="120" height="160" alt="" />';
      $markup .= '<p class="title">' . $value->title . '</p>';
      $markup .= '<p class="creator">' . $value->creator . '</p>';
      $markup .= '</div>';
    }
    $variables['easyting']['carousel'] = theme('carousel', array('carousel_items' => $markup));
  }


  if ($hook == 'search_result') {

    require_once('fb.php');
    fb($variables, 'qwe');

    // watchdog('qwe','<pre>'.print_r($variables,1).'</pre>');
    ;
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

  $hooks['carousel'] = array(
    'variables' => array('carousel_items' => NULL),
    'template' => 'easyting_carousel',
    'path' => $path . '/templates',
  );

  return $hooks;
}

function easyting_preprocess_ting_object(&$variables) {
echo "<pre>";


  if (isset($variables['content']['ting_type'])) {
    $variables['content']['ting_type'][0]['#attributes']['class'][] = 'clearfix';
  }

  $places = array(
    'ting_cover' => 'left',
    'ting_title' => 'right',
    'ting_abstract' => 'right',
    'ting_author' => 'right',
    'ting_type' => 'right',
    'ting_subjects' => 'right',
    'ding_availability_item' => 'right',
  );
  $variables['content']['left'] = array();
  $variables['content']['right'] = array();

  foreach ($variables['content'] as $name => $render) {
    if (isset($places[$name])) {
      $variables['content'][$places[$name]][] = $render;
      unset($variables['content'][$name]);
    }
  }
  $variables['content']['ting_details']['#title'] = t("Detaljer");


//$variables['elements']['actions']['reserve']['submit']['#value'] = t("Reserver Tak");



//var_dump(array_keys($variables['elements']['actions']['reserve']));
//var_dump($variables['elements']['actions']['reserve']['submit']);


//var_dump($variables['content']['actions']['reserve']['#action']['reservable']['server']['submit']);
//var_dump($variables['elements']['ting_cover']['#formatter']['actions']['reserve']['#action']['reservable']);
echo "</pre>";
}


?>
