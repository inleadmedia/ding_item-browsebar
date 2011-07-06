  <div id="page-wrapper">
    <div id="page">

      <div id="header">
        <div class="bg">
          <div class="section clearfix">

            <div class="oneBlock" style="padding-top: 20px;>
              <?php if ($logo): ?>
                <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                  <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
                </a>
              <?php endif; ?>
              <?php if ($site_name || $site_slogan): ?>
                <div id="name-and-slogan">
                  <?php if ($site_name): ?>
                    <?php if ($title): ?>
                      <div id="site-name"><strong>
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                      </strong></div>
                    <?php else: /* Use h1 when the content title is empty */ ?>
                      <h1 id="site-name">
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                      </h1>
                    <?php endif; ?>
                  <?php endif; ?>

                  <?php if ($site_slogan): ?>
                    <div id="site-slogan"><?php print $site_slogan; ?></div>
                  <?php endif; ?>
                </div>
                <!-- /#name-and-slogan -->
              <?php endif; ?>
            </div>
            <div class="threeBlocks">
              <?php print render($page['header']); ?>
            </div>
          </div>
          <!-- /.section -->
        </div>
        <!-- /.bg -->
      </div>
      <!-- //#header -->

      <?php if ($main_menu || $secondary_menu): ?>
        <div id="navigation">
          <div class="section">
            <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links', 'inline', 'clearfix')), 'heading' => t('Main menu'))); ?>
            <?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix')), 'heading' => t('Secondary menu'))); ?>
          </div>
          <!-- /.section -->
        </div>
        <!-- /#navigation -->
      <?php endif; ?>

      <div id="main-wrapper">
        <div id="main" class="clearfix">

          <div id="content" class="column">
            <div class="fourBlocks">
              <?php if ($breadcrumb): ?>
                <div id="breadcrumb"><?php print $breadcrumb; ?></div>
              <?php endif; ?>

              <?php print $messages; ?>
            </div>

            <div class="fourBlocks">
              <?php if ($tabs): ?>
                <div class="tabs"><?php print render($tabs); ?></div>
              <?php endif; ?>
              <?php print render($page['help']); ?>
              <?php if ($action_links): ?>
                <ul class="action-links">
                  <?php print render($action_links); ?>
                </ul>
              <?php endif; ?>
              <?php print render($page['content']); ?>
            </div>
          </div>
          <!-- /#content -->
        </div>
        <!-- /#main -->
      </div>
      <!-- /#main-wrapper -->
    </div>
    <!-- /#page -->
  </div>
  <!-- /#page-wrapper -->

  <div id="footer">
    <div class="section">
      <?php print render($page['footer']); ?>
    </div>
    <!-- /.section -->
  </div>
  <!-- /#footer -->
