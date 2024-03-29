<?php
/**
 * MyArcadePlugin Theme API helps theme developers to create MyArcadePlugin Pro compatible themes.
 *
 * Use this function only within the loop.
 *
 * @package MyArcadePlugin Theme API
 * @author Daniel Bakovic - https://myarcadeplugin.com
 * @version 3.2.0
 */

if ( ! function_exists( 'myarcade_title' ) ) {
  /**
   * Display or retrieve the title of the current post/game. The title can be cutted after $chars.
   * Words will not be cutted off (wordwrap).
   *
   * @param int $chars Optional. Max. length of the title
   * @param bool $echo Optional. default to true. Whether to display or return.
   * @return null|string Null on no title. String if $echo parameter is false.
   */
  function myarcade_title( $chars = 0, $echo = true ) {

    $chars = intval($chars);
    $title = strip_tags( the_title('', '', false) ); // before, after, echo

    if ( $chars > 0 ) {
      if ( (strlen($title) > $chars) ) {
        $title = mb_substr($title, 0, $chars);
        $title = mb_substr($title, 0, -strlen(strrchr($title, ' ')));  // Wordwrap

        if ( strlen($title) < 4 ) {
          $title = mb_substr( the_title('', '', false), 0, $chars );
        }

        $title .= ' ..';
      }
    }

    if ( $echo == true ) {
      echo $title;
    }
    else {
      return $title;
    }
  }
}

if ( ! function_exists( 'myarcade_description' ) ) {
  /**
   * Display or retrieve the description of the current game. The description can be cutted after $chars.
   * Words will not be cutted off (wordwrap).
   *
   * @param int $chars Optional. Max. length of the description
   * @param bool $echo Optional. default to true. Whether to display or return.
   * @return null|string Null on no description. String if $echo parameter is false.
   */
  function myarcade_description ($chars = 0, $echo = true) {
    global $post;

    $chars = intval($chars);
    $description = get_post_meta($post->ID, 'mabp_description', true);

    if ( $chars > 0 ) {
      if ( (strlen($description) > $chars) ) {
        $description = mb_substr($description, 0, $chars);
        $description = mb_substr($description, 0, -strlen(strrchr($description, ' ')));  // Wordwrap

        if ( strlen($description) < 4 ) {
          $description = mb_substr( get_post_meta($post->ID, 'mabp_description', true), 0, $chars );
        }

        $description .= ' ..';
      }
    }

    if ( $echo == true ) {
      echo $description;
    }
    else {
      return $description;
    }
  }
}

if ( !function_exists( 'myarcade_excerpt' ) ) {
  /**
  * Display or retrieve the excerpt of a game post. All tags will be removed.
  *
  * @param int $length Character length of the excerpt
  * @param bool $echo Optional. Return or echo the result
  */
  function myarcade_excerpt( $length = false, $echo = true ) {
    global $post;

    // Get post excerpt
    $text = strip_shortcodes( $post->post_content );
    $text = str_replace( array( '\r\n', '\r', '\n'), "", $text );
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = wp_trim_words( $text, 100, '' );

    if ( $length ) {
      if ( strlen($text) > $length ) {
        $text = mb_substr($text, 0, $length);
        $text = mb_substr($text, 0, -strlen(strrchr($text, ' ')));  // Wordwrap
        $text .= ' ...';
      }
    }

    if ( $echo ) {
      echo $text;
    }
    else {
      return $text;
    }
  }
}

if ( ! function_exists( 'myarcade_thumbnail' ) ) {
  /**
   * Display the game thumbnail of the current game.
   * If no thumbnail is available the function will display a default thumbnail located in the template directory.
   *
   * @version 3.1.0
   * @param array $args
   */
  function myarcade_thumbnail( $args = array() ) {
    global $post;

    $defaults = array(
      'width'     => 100,
      'height'    => 100,
      'class'     => false,
      'lazy_load' => false,
      'show_loading' => true,
      'lazy_placeholder' => get_template_directory_uri() . '/images/placeholder.gif',
    );

    $args = wp_parse_args( $args, $defaults );

    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail = '';

    if ( ! empty( $thumbnail_id ) ) {
      $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id );
      if ( ! empty( $thumbnail_array ) ) {
        $thumbnail = $thumbnail_array[0];
      }
    }

    if ( ! $thumbnail ) {
      $thumbnail = get_post_meta($post->ID, "mabp_thumbnail_url", true);
    }

    if ( preg_match('|^(http).*|i', $thumbnail) == 0 ) {
      // No Thumbail available.. get the default thumb
      $thumbnail = get_template_directory_uri().'/images/noimg.png';
    }

    if ( $args['lazy_load'] ) {
      if ( $args['show_loading'] ) {
        $loading_background = 'background-placeholder';
      }
      else {
        $loading_background = '';
      }

      if ( $args['class'] ) {
        $args['class'] = 'class="'.$loading_background.' '.$args['class'].'"';
      }
      else {
        $args['class'] = 'class="'.$loading_background.'"';
      }
      echo '<img src="'.$args['lazy_placeholder'].'" data-echo="'.$thumbnail.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" /><noscript><img src="'.$thumbnail.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" /></noscript>';
    }
    else {
      echo '<img src="'.$thumbnail.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" />';
    }
  }
}

if ( ! function_exists( 'myarcade_thumbnail_url' ) ) {
  /**
   * Display the url of the current game thumbnail
   *
   * @return string
   */
  function myarcade_thumbnail_url() {
    global $post;

    $thumbnail_id = get_post_thumbnail_id();
    $thumbnail = '';

    if ( ! empty( $thumbnail_id ) ) {
      $thumbnail_array = wp_get_attachment_image_src( $thumbnail_id );
      if ( ! empty( $thumbnail_array ) ) {
        $thumbnail = $thumbnail_array[0];
      }
    }

    if ( ! $thumbnail ) {
      $thumbnail = get_post_meta($post->ID, "mabp_thumbnail_url", true);
    }

    if ( preg_match('|^(http).*|i', $thumbnail) == 0 ) {
      // No Thumbail available.. get the default thumb
      $thumbnail = get_template_directory_uri().'/images/noimg.png';
    }

    return $thumbnail;
  }
}

if ( ! function_exists('myarcade_instructions') ) {
  /**
   * Display or retrieve the game instructions
   * @since 1.0
   */
  function myarcade_instructions($echo = true) {
    global $post;
    $instructions = get_post_meta($post->ID, "mabp_instructions", true);
    if ($echo == true) { echo $instructions; } else { return $instructions; }
  }
}

if ( ! function_exists( 'myarcade_count_screenshots' ) ) {
  /**
   * Retrieve the number of available screenshots for the current game.
   *
   * @return int
   */
  function myarcade_count_screenshots () {
    global $post;

    $screen_count = 0;

    for ($screen_nr = 1; $screen_nr <= 4; $screen_nr++) {
      if ( preg_match('|^(http).*|i', get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true)) ) {
        $screen_count++;
      }
    }

    return intval($screen_count);
  }
}

if ( ! function_exists( 'myarcade_screenshot' ) ) {
  /**
   * Display the given screen shot of the current game.
   *
   * @param array $args
   * @return string
   */
  function myarcade_screenshot ( $args = array() ) {
    global $post;

    $defaults = array(
      'width'     => 450,
      'height'    => 300,
      'screen_nr' => 1,
      'class'     => false,
      'echo'      => true,
      'lazy_load' => false,
      'lazy_placeholder' => get_template_directory_uri() . '/images/placeholder.gif',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( $args['class'] ) { $args['class'] = 'class="'.$args['class'].'"'; }

    $output = false;

    $screenshot = get_post_meta( $post->ID, "mabp_screen".$args['screen_nr']."_url", true );

    if ( strpos( $screenshot, 'http' ) !== false ) {
      if ( $args['lazy_load'] ) {
      $output = '<img src="'.$args['lazy_placeholder'].'" data-echo="'.$screenshot.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" /><noscript><img src="'.$screenshot.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" /></noscript>';
      }
      else {
        $output = '<img src="'.$screenshot.'" width="'.$args['width'].'" height="'.$args['height'].'" '.$args['class'].' alt="'.the_title_attribute( array( 'echo' => false ) ).'" />';
      }
    }

    if ( $args['echo'] ) {
      echo $output;
    }
    else {
      return $output;
    }
  }
}

if ( ! function_exists('myarcade_get_screenshot_url') ) {
  /**
   * Retrieves the url of a screenshot
   *
   * @param int $screen_nr Optional. The number of the screen (1..4). Default 1
   * @param bool $echo Optional. Return or echo the result
   */
  function myarcade_get_screenshot_url ( $screen_nr = 1, $echo = true ) {
    global $post;

    $screenshot = get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true);

    if ( $echo == true ) {
      echo $screenshot;
    }
    else {
      return $screenshot;
    }
  }
}

if ( ! function_exists( 'myarcade_all_screenshots' ) ) {
  /**
   * Display all available screen shot of the current game.
   *
   * @param int $width Optional. Width of the screen shot in px. Default: 450
   * @param int $height Optional. Height of the screen shot in px. Default: 350
   * @param int $screen_nr Optional. The number of the screen (1..4). Default 1
   * @param string $class Optional. CSS class fot the image tag
   */
  function myarcade_all_screenshots ($width = 450, $height = 300, $class = '') {
    global $post;

    if ( !empty($class) ) { $class = 'class="'.$class.'"'; }

    for ($screen_nr = 1; $screen_nr <= 4; $screen_nr++) {
      $screenshot = get_post_meta($post->ID, "mabp_screen".$screen_nr."_url", true);

      // MyArcadeTheme
      if ( preg_match( '|^(http).*|i', $screenshot ) ) {
        ob_start();
        ?>
        <!--<game>-->
        <li>
          <div class="gmcn-smal-3">
            <figure class="gm-imag">
              <a href="#">
                <span class="fa-gamepad"><?php _e("<strong>PLAY</strong> <span>NOW!</span>", 'myarcadetheme' ); ?></span>
              </a>
            </figure>
            <figure class="gm-imag">
              <a href="<?php echo $screenshot ?>" rel="lightbox">
                <img src="<?php echo $screenshot ?>"  width="<?php echo $width ?>" height="<?php echo $height ?>" <?php echo $class ?> alt="<?php printf( __('Image %s', 'myarcadetheme'), $post->post_title); ?>" /><span class="fa-search" title="<?php _e('Zoom', 'myarcadetheme'); ?>"><strong><?php _e('Zoom', 'myarcadetheme'); ?></strong></span>
              </a>
            </figure>
          </div>
        </li>
        <!--</game>-->
        <?php
        ob_end_flush();
      }
    }
  }
}

if ( ! function_exists( 'myarcade_video' ) ) {
  /**
   * Display (Embed) the gameplay video of the current game.
   *
   * @param int $width Optional. Width of the video in px. Default: 450
   * @param int $height Optional. Height of the video in px. Default: 350
   * @return string Video embed code
   */
  function myarcade_video( $width = 400, $height = 336 ) {
    global $post;

    $video_url = get_post_meta( $post->ID, "mabp_video_url", true );

    if ( $video_url ) {
      // Get the embed code
      return wp_oembed_get( $video_url, array( 'width' => $width, 'height' => $height ) );
    }

    return false;
  }
}

if ( ! function_exists( 'myarcade_has_video' ) ) {
  /**
   * Check if a vide is available
   *
   * @version 3.1.0
   * @since   3.1.0
   * @access  public
   * @return  bool True if a video is available
   */
  function myarcade_has_video() {
    global $post;

    if ( get_post_meta( $post->ID, "mabp_video_url", true ) ) {
      return true;
    }

    return false;
  }
}

if ( ! function_exists( 'myarcade_category') ) {
  /**
   * Get game categories as links.
   * 
   * @param bool $single Optional. True if only the fist category link should be generated.
   * @param string $separator Optional. Separator between the categories. By default, the links are separated
   *                          by spaces.
   * @param string $parents Optional. How to display the parents. (see get_the_category_list)
   * @return string
   */
  function myarcade_category( $single = true, $separator = ' ', $parents = '' ) {

    $output = '';
    
    if ( ! $single ) {
      $output = get_the_category_list( $separator, $parents );
    }
    else {
      // Get only the first category
      $category = get_the_category();
      
      if ( $category ) {
        $output = '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" rel="category tag">' . $category[0]->name . '</a>';

      }
    }

    return $output;
  }
}

if ( ! function_exists( 'myarcade_format_number' ) ) {
  /**
   * Facebook like number formatting
   *
   * @param   int $n number
   * @return  string number
   */
  function myarcade_format_number( $n ) {
    $s = array("K", "M", "G", "T");
    $out = "";

    while ($n >= 1000 && count($s) > 0) {
      $n = $n / 1000.0;
      $out = array_shift($s);
    }

    return round($n, max(0, 3 - strlen((int)$n))) ."$out";
  }
}
