<?php
// $Id$
/**
 * @file
 */
?>

<div class="ting-overview clearfix">
  <!-- ting_object_overview.tpl.php -->
  <div class="left-column left">
    <div class="picture">
      <?php if (isset($image)) { ?>
        <?php print render($image); ?>
      <?php } ?>
    </div>
    <?php print render($content['left']); ?>
  </div>

  <div class="right-column left">
    <div class="title">
    <?php print render($title_prefix); ?>
      <?php /* if (!$page && !$search_result): */ ?>
        <h2<?php print $title_attributes; ?>><a href="<?php print $url; ?>"><?php print $title; ?></a></h2>
      <?php /* endif; */ ?>
      <?php print render($title_suffix); ?>

      <?php if ($other_titles) { ?>
        <h2 class="other-titles"><?php print $other_titles; ?></h2>
      <?php } ?>

      <?php if ($alternative_titles) { ?>
        <?php foreach ($alternative_titles as $title) { ?>
          <h2 class="aternative-titles">(<?php print $title; ?>)</h2>
        <?php } ?>
      <?php } ?>

      <?php if ($serie_title) { ?>
        <h3 class="serie-title">
          <?php echo t('Serie title: '); print $serie_title; ?>
        </h3>
      <?php } ?>
    </div>

    <div class="creator">
      <?php if ( $creators ) { ?>
        <span class='byline'><?php echo ucfirst(t('by')); ?></span>
        <?php print $creators; ?>
      <?php } ?>
      <?php if ($date) { ?>
        <span class='date'>(<?php print $date; ?>)</span>
      <?php } ?>
    </div>

    <?php if (!$page && !$search_result) { ?>
    <?php } else { ?>
      <div class="description">
        <?php if ( isset($abstract) && $abstract ) { ?>
          <div class="abstract"><?php print $abstract; ?></div>
        <?php } ?>
      </div>
    <?php } ?>

    <?php if (!$page && !$search_result) { ?>
      <?php if ( isset($subjects) && $subjects ) { ?>
        <div class="subjects">
          <span class='subjects-label'><?php echo ucfirst(t('subjects: ')); ?></span>
          <?php print $subjects; ?>
        </div>
      <?php } ?>
    <?php } ?>

    <?php if ((isset($ratings) && $ratings) || (isset($revies) && $reviews)) { ?>
      <div class="voxb">
        <?php if ( isset($ratings) && $ratings ) { ?>
          <div class="ratings"><?php print $ratings; ?></div>
        <?php } ?>
        <?php if ( isset($revies) && $reviews ) { ?>
          <div class="reviews"><?php print $reviews; ?></div>
        <?php } ?>
      </div>
    <?php } ?>

    <div class="information">
      <div class="options">
        <ul class="options">
          <li>
            <a href="javascript:void(0);" class="button"><span class="info"><?php echo ucfirst(t('More info')); ?></span></a>
          </li>
          <li class="icon">
            <a href="#" class="button"><span class="cart"><?php echo ucfirst(t('Add to cart')); ?></span></a>
          </li>
          <li class="icon">
            <a href="#" class="button"><span class="reserve"><?php echo ucfirst(t('Reserve')); ?></span></a>
          </li>
        </ul>
      </div>
      <div class="typeavailability">
        <?php if ( isset($types) && $types ) { ?>
          <div class="types">
            <?php foreach ($types as $type) { ?>
              <p class="type"><?php print $type; ?></p>
            <?php } ?>
            <div class="clearfix"></div>
          </div>
        <?php } elseif ( isset($type) && $type ) { ?>
          <div class="types">
            <p class="type<?php /* print strtolower($type); // to-do: individual material icons */ ?>"><?php print $type; ?></p>
            <div class="clearfix"></div>
          </div>
        <?php } ?>
     </div>
    </div>

    <?php print render($content['right']); ?>
  </div>

</div>

<?php if ( isset($materials_heading) && $materials_heading ) { ?>
  <h1 class="materials-heading"><?php print $materials_heading; ?></h1>
<?php } ?>

<?php if ( isset($availability_legend) && $availability_legend ) { ?>
  <?php print $availability_legend; ?>
<?php } ?>
