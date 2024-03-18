      </div>
      <!--</bdcn>-->
      <?php
      // Do some actions before the footer
      do_action('myarcadetheme_before_footer');
      ?>
      <div style="text-align: center; margin-left: auto;margin-right: auto; padding: 20px 20px;position: relative;">
        <?php if (is_home() and is_front_page()) { ?>
          <div>
            <p style="font-size: 30px; font-weight: bold;">
              About us
            </p>
            <p><?php echo get_option('about_us_seo') ?></p>
          </div>
        <?php } ?>

        <?php if (is_category() and !is_category(array(1))) { ?>
          <?php $category = get_category(get_query_var('cat'));
          $cat_id = $category->cat_ID;
          $description = category_description($cat_id);
          if (!empty($description)) {
          ?>
          <?php } ?>
          <div id="content-footer" class="rounded bg-white">
            <?php echo $description ?>
          </div>
        <?php } ?>

      </div>
      <!--<ftcn>-->
      <footer class="ftcn" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
        <?php if (myarcadetheme_get_option('footer_widgets', 1) && !(myarcadetheme_get_option('mobile_footer_sidebar', 0) && wp_is_mobile())) : ?>
          <div class="ftcn-1">
            <div class="cont">
              <div class="cntcls">
                <?php
                if (is_active_sidebar('footer-sidebar')) {
                  dynamic_sidebar('footer-sidebar');
                }
                ?>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="ftcn-2">
          <div class="cont" itemprop="text">
            <p>
              <?php
              $copyright = myarcadetheme_get_option('footer_copyright');
              if (empty($copyright)) {
                $copyright = sprintf(__('Proudly powered by %sMyArcadePlugin%s', 'myarcadetheme'), '<a href="http://myarcadeplugin.com/" title="WordPress Arcade" rel="noopener" itemprop="url">', '</a>');
              }

              echo $copyright;
              ?>
            </p>
          </div>
        </div>
      </footer>
      <!--</ftcn>-->

      <?php
      // Do some actions after the footer
      do_action('myarcadetheme_after_footer');
      ?>
      </div>
      <!--</all>-->

      <?php if (myarcadetheme_get_option('back_top', 1)) : ?>
        <a href="#hd" class="botn-gtop fa-chevron-up" title="<?php _e("Back to Top", 'myarcadetheme'); ?>"></a>
      <?php endif; ?>

      <?php get_template_part("partials/footer", "modal"); ?>

      <?php wp_footer(); ?>
      <!--[if lt IE 9]><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/lib/css3mq.js"></script><![endif]-->
      <!--[if lte IE 9]><script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/lib/ie.js"></script><![endif]-->
      </body>

      </html>