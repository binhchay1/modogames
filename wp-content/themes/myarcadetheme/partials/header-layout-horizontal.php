<header class="hdcn" id="header_horizontal" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
  <div class="cont">
    <button class="menu-botn"><span class="fa-bars fa-2x"></span></button>

    <div class="logo">
      <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name');?>" itemprop="url">
        <?php
        $logo = myarcadetheme_get_option( 'logohd' );
        if ( empty( $logo['url'] ) ) {
          $logo['url'] = get_template_directory_uri() .' /images/my-arcade-theme.png';
        }
        ?>
        <img src="<?php echo $logo['url']; ?>" alt="<?php bloginfo('blogname'); ?>" title="<?php bloginfo('blogname'); ?>" itemprop="image"/>
      </a>
      <meta itemprop="name" content="<?php bloginfo('blogname'); ?>">
    </div>

    <nav class="menu">
      <button class="menu-botn button-close"><span class="fa-close fa-2x"></span></button>
      <ul class="nav_menu">
        <?php wp_nav_menu( array(
          'container' => false,
          'theme_location' => 'primary',
          'items_wrap' => '%3$s',
          'fallback_cb' => 'myarcadetheme_default_menu')
        );

        if ( myarcadetheme_get_option( 'horizontal_header_login', '1' ) !== '0' ) {
          if ( ! is_user_logged_in() ) {
            if ( myarcadetheme_get_option( 'horizontal_header_login' ) == '1' ) {
              // Modal
              $data = 'href="#" data-toggle="modal" data-target="#modl-logi"';
            }
            else {
              // Link
              $data = 'href="'.wp_login_url( myarcadetheme_get_current_url() ).'"';
            }
            ?>
            <li class="user_panel"><a class="fa-sign-in" <?php echo $data; ?>><?php _e('LOGIN', 'myarcadetheme'); ?></a></li>
            <?php
          }
          else {
            global $current_user;
            ?>
            <li class="user_panel">
              <span class="fa-user"><?php printf( __( 'Hello, <strong>%s</strong>', 'myarcadetheme' ), $current_user->display_name ); ?></span>
              <ul>
                <li class="avatar-cn"><?php echo get_avatar( $current_user->ID, 85 ); ?></li>
                <li><a href="<?php if(defined('BP_VERSION')){ global $bp; echo $bp->loggedin_user->domain; }else{ echo home_url().'/wp-admin/profile.php'; } ?>" class="fa-user"><?php _e('My account', 'myarcadetheme'); ?></a></li>
                <li><a href="<?php echo wp_logout_url(  home_url() ); ?>" class="fa-power-off"><?php _e('Logout', 'myarcadetheme'); ?></a></li>
              </ul>
            </li>
            <?php
          }

          if ( ! is_user_logged_in() && myarcadetheme_get_option( 'topbar_register', '1' ) !== '0' ) {
            if ( get_option('users_can_register') ) {
              if ( myarcadetheme_get_option( 'topbar_register' ) == '1' ) {
              // Modal
              $data = 'href="#" href="#" data-toggle="modal" data-target="#modl-regi""';
              }
              else {
                // Link
                $data = 'href="'.wp_registration_url().'"';
              }
              ?>
              <li class="user_panel"><a class="fa-sign-out" <?php echo $data; ?>><?php _e('REGISTER', 'myarcadetheme'); ?></a></li>
            <?php
            }
          }
        }
        ?>
      </ul>
    </nav>

    <a class="fa-search fa-2x" href="#" data-toggle="modal" data-target="#modl-srch"></a>
  </div>

  <?php get_template_part( "partials/header", "carousel" ); ?>

  <?php get_template_part( "partials/header", "news" ); ?>
</header>