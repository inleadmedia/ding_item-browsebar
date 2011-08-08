<?php
// $Id$
/**
 * @file ting_object.tpl.php
 *
 * Template to render objects from the Ting database.
 *
 * Available variables:
 * - $object: The TingClientObject instance we're rendering.
 * - $content: Render array of content.
 */
?>


<?php if (arg(0) == 'ting' && arg(1) == 'object') { ?>

<!-- ting_object.tpl.php ? -->
<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
<!--
  <div class="ting-object-overview">
    <?php echo render($content['overview']); ?>
  </div>
  <div class="ting-object-details">
    <?php echo render($content['details']); ?>
  </div>
-->
  <!--<div class="ting-object-additional">
    <?php echo render($content); ?>
  </div>-->
  <div class="item-container">
    <div class="item-header">
      <div class="social-icons">
        <div class="social-icon facebook">Like</div>
        <div class="social-icon twitt">Twitt</div>
        <div class="social-icon rss">Rss</div>
        <div class="social-icon print">Print</div>
      </div>
      <div class="tab-container">
        <div class="tab-header active description-tab-header">
          <div class="tab-inner"><?php print(t('Beskrivelse')); ?></div>
        </div>
        <div class="tab-header details-tab-header">
          <div class="tab-inner"><?php print(t('Detaljer')); ?></div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <div class="ting-object-additional">
      <div class="cover"><?php print render($easyting['ting_cover']); ?></div>

      <div class="tab description">
        <?php print render($easyting['ting_object']); ?>
        <div class="author"><?php print render($easyting['ting_author']); ?></div>
        <div class="description-content"><?php print render($easyting['ting_abstract']); ?></div>
        <div class="clear"></div>
      </div>

      <div class="tab details" style="display: none;">
        <div class="details-content"><?php print render($easyting['ting_details']); ?></div>
      </div>
      <div class="clear"></div>
      <?php print render($easyting['ting_actions']) ;?>
      <?php print render($easyting['ting_availability']) ;?>
      <?php print render($content); ?>
    </div>
    <div class="clear"></div>

    
  </div>
  <br />
  <br />
  <br />

  <!--?php dpm($content); ?-->
</div>

<?php } if (arg(0) == 'search' && arg(1) == 'ting') { ?>

  <div class="ting-object-search-result-additional">
    <div class="ting-cover-main">
      <?php print render($easyting['ting_cover']); ?>
    </div>
    <div class="ting-title">
      <?php print render($easyting['ting_title']); ?>
    </div>
    <div class="ting-author">
      <?php print render($easyting['ting_author']); ?>
    </div>
    <div class="ting-abstract">
      <?php print render($easyting['ting_abstract']); ?>
      <div class="clear"></div>
      <div class="ting-actions">
        <?php print render($easyting['ting_actions']); ?>
      </div>
      <div class="ting-collection-types">
        <?php print render($easyting['ting_collection_types']); ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>

<?php } ?>



