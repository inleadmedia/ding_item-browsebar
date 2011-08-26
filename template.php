<?php
/**
 * @file
 *
 */

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

/**
 * Altering search form
 * 
 * @param type $form
 * @param type $form_state
 * @param type $form_id 
 */
function easyting_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['#prefix'] = '<div id="search_form">';
    $form['#suffix'] = '</div><div class="clear"></div>';

    $form['actions']['#weight'] = '10';
    $form['search_block_form']['#weight'] = '11';
  }

  if ($form_id == 'search_controls_form') {
    $form['size']['#type'] = 'select';
  }
  elseif ($form_id == 'ding_reservation_reserve_form') {
    $form['submit']['#prefix'] = '<div class="button plus reserve">';
    $form['submit']['#suffix'] = '</div>';
  }
}

/**
 * Preprocess template hook
 * 
 * @param type $variables
 * @param type $hook 
 */
function easyting_preprocess(&$variables, $hook) {
  if ($hook == 'page') {
    // Preprocess main navigation menu
    $menu = menu_navigation_links('menu-easyting-main-menu');
    $markup = '<ul id="m-nav">';

    foreach($menu as $key => $value) {
      $markup .= '<li>
        <a href="' . ($value['href'] == '<front>' ? 'index.php' : $value['href']) . '">' . $value['title'] . '</a>
        <img class="separator" src="/' . drupal_get_path('theme', 'easyting') . '/images/nav_separator.png" width="1" height="24"  alt="" /></li>';
    }

    $markup .= '</ul>';
    $variables['easyting']['main_nav'] = theme('main_nav', array('menu' => $markup));

    // Preprocess secondary navigation menu
    $menu = menu_navigation_links('menu-easyting-secondary-menu');

    $variables['easyting']['secondary_nav'] = theme('secondary_nav', array('menu' => $menu));

    // Preprocess header navigation menu
    $menu = menu_navigation_links('menu-easyting-header-menu');

    // Hardcoded html represents language menu item.
    $language_menu_html = '
      <a class="subnav-trigger" href="#popup-language-menu">English</a>
      <ul id="popup-language-menu" class=subnav-popup language-list>
        <li class="dk first"><a href="/">Danish</a></li>
        <li class="en actvie"><a href="/">English</a></li>
        <li class="de last"><a href="/">German</a></li>
      </ul>
    ';

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
    // Last item always will be choose language item
    $markup .= '<li>' . $language_menu_html . '</li>';

    $markup .= '</ul>';

    $variables['easyting']['header_nav'] = theme('header_nav', array('menu' => $markup));

    $variables['page']['footer_menu'] = theme('footer_menus');
  }
}

/**
 * Theme hooks
 * @param type $existing
 * @param type $type
 * @param type $theme
 * @param type $path
 * @return array 
 */
function easyting_theme($existing, $type, $theme, $path) {
  $hooks = array();

  $hooks['main_nav'] = array(
    'variables' => array('menu' => NULL),
    'template' => 'easyting_main_nav',
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

  $hooks['footer_menus'] = array(
    'variables' => array(),
    'template' => 'easyting_footer_menu',
    'path' => $path . '/templates',
  );

  return $hooks;
}

function easyting_preprocess_ting_object(&$variables) {
  // for landing page only
  if (arg(0) == 'ting' && arg(1) == 'object') {
    $variables['content']['actions']['reserve']['submit']['#value'] = '';
    $variables['content']['actions']['reserve']['submit']['#attributes'] = array(
      'class' => array('reserve-button')
    );

    drupal_add_js('js/item.tabs.js');

    $variables['content']['ting_details']['#title'] = t("Detaljer");

    $items = array(
      'ting_cover',
      'ting_title',
      'ting_author',
      'ting_abstract',
      'ding_availability_item',
      'ding_availability_holdings',
      'ting_details',
      'relations',
      'ting_type',
      'ting_subjects',
      'actions',
    );

    $locations = array(
      'ting_cover',
      'ting_object',
      'ting_author',
      'ting_abstract',
      'ting_availability',
      'ting_holdings',
      'ting_details',
      'ting_relations',
      'ting_type',
      'ting_subjects',
      'ting_actions',
    );

    foreach($items as $key => $value) {
      if (isset($variables['content'][$value])) {
        $variables['easyting'][$locations[$key]] = $variables['content'][$value];
        unset($variables['content'][$value]);
      }
    }
  }

  // for collection page only
  if (arg(0) == 'ting' && arg(1) == 'collection') {
    //require_once('fb.php');

    if (isset($variables['content']['ting_entities'])) {
      //fb($variables['content']);
      // Prepare primary collection item for render
      $variables['primary_item'] = $variables['content']['ting_entities'][0];

      // Prepare other items for render
      $variables['related_items'] = $variables['content'];

      // Shift label into separate variable
      $variables['related_items_label'] = $variables['related_items']['ting_entities']['#title'];
      $variables['related_items']['ting_entities']['#label_display'] = 'hidden';

      // Get availability legent block
      $ding_availability_legend_block = module_invoke('ding_availability','block_view');
      $variables['availability_legend'] = $ding_availability_legend_block['content'];

      unset($variables['content']);
    }
    
  }

  // for search result only
  if (arg(0) == 'search' && arg(1) == 'ting') {
    if (isset($variables['content']['ting_primary_object'])) {

      $locations = array_keys($variables['content']['ting_primary_object'][0]);

      foreach($locations as $key => $value) {
        if (isset($variables['content']['ting_primary_object'][0][$value])) {
          $variables['easyting'][$locations[$key]] = $variables['content']['ting_primary_object'][0][$value];
          unset($variables['content']['ting_primary_object'][0][$value]);
        }
      }

      $variables['easyting']['ting_collection_types'] = $variables['content']['ting_collection_types'];
      unset($variables['content']['ting_collection_types']);
    }

    print render($content);
  }
}
?>
