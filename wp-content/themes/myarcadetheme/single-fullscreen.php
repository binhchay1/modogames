<html>
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>

    <title><?php bloginfo('name'); ?> - <?php _e('Playing game:', 'myarcadetheme'); ?> - <?php single_post_title(); ?></title>

    <?php wp_head(); ?>
  </head>

  <body>
    <center>
      <?php if ( ! wp_is_mobile() ) : ?>
        <div id="gamecntmt" style="width: 100%;background:#C9CCD3;">
          <a href="javascript:history.go(-1)">&laquo; <?php _e('Go back to', 'myarcadetheme'); ?>: <?php bloginfo('name'); ?></a>
        </div>
        <?php
        add_filter( 'myarcade_fullscreen_width', 'myarcadetheme_fullscreen_width' );
        add_filter( 'myarcade_fullscreen_height', 'myarcadetheme_fullscreen_height' );
        ?>
      <?php endif; ?>

      <?php
      global $mypostid, $post;
      $mypostid = $post->ID;
      // overwrite the post id
      $post->ID = $mypostid;
      if ( function_exists('myarcade_get_leaderboard_code') )  {
        echo myarcade_get_leaderboard_code();
      }
      echo get_game($mypostid, $fullsize = false, $preview = false, $fullscreen = true);
      ?>
    </center>

    <?php
      wp_footer();
    ?>
  </body>
</html>