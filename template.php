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

function easyting_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['#prefix'] = '<div id="search_form">';
    $form['#suffix'] = '</div><div class="clear"></div>';

    $form['actions']['#weight'] = '10';
    $form['search_block_form']['#weight'] = '11';
  }

  if ($form_id == 'search_controls_form') {
    $form['size']['#type'] = 'select';
    // $form['size']['#attributes'] = array('onchange' => 'var i = this.selectedIndex; extendSearch("controls_search_size",this[i].value)');
    // $form['size']['#attributes'] = array('onchange' => 'extendSearch("controls_search_size",this.value)');
  }
}

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
    $menu = menu_navigation_links('menu-easyting-header-menu');

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
    $variables['easyting']['carousel'] = '';
    if ($variables['is_front']) {
      // @todo
      // Carousel items stub
      $result = array();
      for($i = 0; $i < 23; $i++) {
        $result[$i] = new stdClass();
        $result[$i]->image = 'ting_item.jpg';
        $result[$i]->title = 'Sumøbrødre - ' . $i;
        $result[$i]->creator = 'Morten Ramsland';
        $result[$i]->year = mt_rand(1990, 2011);
        $result[$i]->description = 'Første bind i trilogien Ringenes Herre.<br />Hobbitten Frodo forsøger at bringe en magisk ring, der giver uindskrænket magt, frem til Dommedagsbjerget, hvor den skal ødelægges. I eventyrets og mytens form skildres kampen mellem det gode og onde...';
        $result[$i]->subject = 'Ringenes Herre 2. del / 3 del';
        $result[$i]->rating = mt_rand(0, 5);
        $result[$i]->rating_count = mt_rand(100, 5000);
        $result[$i]->comment_count = mt_rand(10, 1000);
        $result[$i]->type = 1;
        $result[$i]->is_new = mt_rand(0, 1);
      }

      // Create items markup
      $markup = '';
      $i = 0;
      foreach($result as $key => $value) {

        $stars = '';
        for($j = 0; $j < 5; $j++) {
          $stars .= '<img src="/' . path_to_theme() . '/images/carousel-star-' . (($j <= $value->rating) ? 'on' : 'off') . '.png" width="15" height="15" alt="" />';
        }

        $markup .= '<div class="result-item' . (($i == 2) ? ' active' : ' inactive') . '">';
        $markup .= '<img src="/' . drupal_get_path('theme', 'easyting') . '/images/' . $value->image . '" width="120" height="160" alt="" />';
        $markup .= '<p class="title">' . $value->title . '</p>';
        $markup .= '<p class="creator">' . $value->creator . '</p>';
        $markup .= '<div class="item-overlay"></div>';
        $markup .= '<div class="item-overlay-details">';
        $markup .= '<p class="title">' . $value->title . '</p>';
        $markup .= '<p class="creator">' . t('Af') . ' ' .  $value->creator . '</p>';
        $markup .= '</div>';
        $markup .= '<div class="result-item-details">';
        $markup .= '<h1>' . $value->title . '</h1>';
        $markup .= '<p>' . t('Af') . ' <span class="creator">' . $value->creator . '</span> (' . $value->year . ')</p>';
        $markup .= '<p class="description">' . $value->description . '</p>';
        $markup .= '<p class="subject"><span class="hightlight">' . t('Emner') . ': </span>' . $value->subject . '</p>';
        $markup .= '<p class="stats"><span class="rating-label">Rating: </span>' . $stars . ' <span class="rating-count">(' . $value->rating_count . ')</span><span class="comment-count">' . t('Anmeldelser') . ' (' . $value->comment_count . ')</span></p>';
        $markup .= '</div>';
        $markup .= '</div>';
        $i++;
      }

      $variables['easyting']['carousel'] = theme('carousel', array('carousel_items' => $markup));

      $variables['page']['content'] = theme('main_content');
    }

    $variables['page']['footer_menu'] = theme('footer_menus');
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

  $hooks['carousel'] = array(
    'variables' => array('carousel_items' => NULL),
    'template' => 'easyting_carousel',
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

  if (arg(0) == 'search' && arg(1) == 'ting') {

    require_once('fb.php');
    fb($variables['content'], '');

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
