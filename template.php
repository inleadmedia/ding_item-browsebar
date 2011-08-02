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
