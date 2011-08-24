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

  if ($form_id == 'search_controls_form') {
    // $form['size']['#type'] = 'select';
    // $form['size']['#attributes'] = array('onchange' => 'var i = this.selectedIndex; extendSearch("controls_search_size",this[i].value)');
    // $form['size']['#attributes'] = array('onchange' => 'extendSearch("controls_search_size",this.value)');
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
  }

  // if ($hook == 'search_result') {
    // require_once('fb.php');
    // fb($variables, 'qwe');
    // watchdog('qwe','<pre>'.print_r($variables,1).'</pre>');
  // }
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

  $hooks['main_content'] = array(
    'variables' => array('content' => NULL),
    'template' => 'easyting_main_page',
    'path' => $path . '/templates',
  );

  return $hooks;
}

function easyting_preprocess_ting_object(&$variables) {

  if (arg(0) == 'ting' && arg(1) == 'object') {
    $variables['content']['actions']['reserve']['submit']['#value'] = '';
    $variables['content']['actions']['reserve']['submit']['#attributes'] = array(
      'class' => array('reserve-button')
    );

//  drupal_add_css('css/ui-lightness/jquery-tabs.css');
    //drupal_add_js('js/jquery-ui-1.8.14.custom.min.js');
    drupal_add_js('js/item.tabs.js');

    $variables['content']['ting_details']['#title'] = t("Detaljer");

    $variables['easyting']['ting_cover'] = $variables['content']['ting_cover'];
    $variables['easyting']['ting_object'] = render($variables['content']['ting_title']);
    $variables['easyting']['ting_author'] .= render($variables['content']['ting_author']);
    $variables['easyting']['ting_abstract'] .= render($variables['content']['ting_abstract']);
    $variables['easyting']['availability'] = $variables['content']['ding_availability_item'];
    $variables['easyting']['ting_details'] = $variables['content']['ting_details'];
    $variables['easyting']['relations'] = $variables['content']['relations'];
    $variables['easyting']['voxb'] = $variables['content']['voxb'];
  }

  if (arg(0) == 'search' && arg(1) == 'ting') {

    // require_once('fb.php');
    // fb($variables['content'],'');


    // $variables['easyting']['ting_cover'] = $variables['content']['ting_cover'];
    // $variables['easyting']['ting_object'] = render($variables['content']['ting_title']);
    // $variables['easyting']['ting_author'] .= render($variables['content']['ting_author']);
    // $variables['easyting']['ting_abstract'] .= render($variables['content']['ting_abstract']);
    // $variables['easyting']['availability'] = $variables['content']['ding_availability_item'];
    // $variables['easyting']['ting_details'] = $variables['content']['ting_details'];
    // $variables['easyting']['relations'] = $variables['content']['relations'];
    // $variables['easyting']['voxb'] = $variables['content']['voxb'];


    $variables['easyting']['ting_collection_types'] = $variables['content']['ting_collection_types'];
    unset($variables['content']['ting_collection_types']);
    $variables['easyting']['ting_cover'] = $variables['content']['ting_cover'];
    unset($variables['content']['ting_cover']);
    $variables['easyting']['ting_object'] = render($variables['content']['ting_title']);
    unset($variables['content']['ting_title']);
    $variables['easyting']['ting_object'] .= render($variables['content']['ting_author']);
    unset($variables['content']['ting_author']);
    $variables['easyting']['ting_object'] .= render($variables['content']['ting_abstract']);
    unset($variables['content']['ting_abstract']);
    //-$variables['easyting']['ting_object'] .= render($variables['content']['ting_subjects']);
    unset($variables['content']['ting_subjects']);

  }

}
?>
