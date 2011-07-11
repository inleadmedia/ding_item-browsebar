<?php

/* Put Breadcrumbs in a ul li structure */
function easyting_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
      $crumbs = '<ul class="breadcrumbs">';

      foreach($breadcrumb as $value) {
           $crumbs .= '<li>'.$value.'</li>';
      }
      $crumbs .= '</ul>';
    }
      return $crumbs;
  }


?>
