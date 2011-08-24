  <div id="page-wrapper">
    <div id="page">

      <div id="header">
        <div class="bg">
          <div class="section container_20">
            <div class="grid_4" style="padding-top: 20px;">
              <?php print $easyting['header_nav']; ?>
              <?php print render($page['header']); ?>
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
            <div class="grid_15">
            </div>
          </div>
          <!-- /.section -->
        </div>
        <!-- /.bg -->
      </div>
      <!-- //#header -->

      <?php //if ($main_menu || $secondary_menu): ?>
      <div id="nav_wrapper">
        <div id="navigation">
          <div class="section container_20">
            <?php print render($page['navigation']); ?>
            <?php
              print $easyting['main_nav'];
              print $easyting['secondary_nav'];
            ?>
          </div>
          <!-- /.section -->
        </div>
        <!-- /#navigation -->
        <?php print render($page['carousel']);/*$easyting['carousel']*/ ?>
      </div>
      <?php //endif; ?>

      <div id="main-wrapper">

        <div id="main" class="container_20">
          <div id="content" class="column">
            <div class="grid_20">

              <?php if ($breadcrumb): ?>
                <div id="breadcrumb"><?php print $breadcrumb; ?></div>
              <?php endif; ?>

              <?php print $messages; ?>

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

            <div class="grid_4">
            </div>
          </div>
          <!-- /#content -->
        </div>
        <!-- /#main -->
      </div>
      <!-- /#main-wrapper -->
    </div>
    <!-- /#page -->
    <div class="footer-push"></div>
  </div>
  <!-- /#page-wrapper -->

  <div id="footer">
    <div class="section">
      <?php print render($page['footer']); ?>
    </div>
    <!-- /.section -->
  </div>
  <!-- /#footer -->
