<?php

/**
 * Template file to hande promoted games / Friv-Style loop
 */

$category = false;
$paged_string = '';

if (myarcadetheme_get_option('promoted_games', 1)) {
  $count = myarcadetheme_get_option('promoted_gamecount', 10);
  $category_array = myarcadetheme_get_option('promoted_categories');
  if (!empty($category_array)) {
    $category = '&cat=' . implode(',', $category_array);
  }
}
if (strpos(myarcadetheme_get_option('box_design'), 'friv') !== false) {
  $count = myarcadetheme_get_option('posts_per_page_home', 30);
  $category_array = myarcadetheme_get_option('excludecat');
  if (!empty($category_array)) {
    $category = '&cat=-' . implode(',-', $category_array);
  }

  // Try to dererminate pagination var on Friv-Style layout
  $action = filter_input(INPUT_POST, 'action');

  if ('myarcadetheme_ajax_action' == $action) {
    $page = filter_input(INPUT_SERVER, 'HTTP_REFERER');
    if (preg_match("^/page/(.*)/^", $page, $matches)) {
      if (!empty($matches[1]) && intval($matches[1]) > 0) {
        $paged_string = '&paged=' . intval($matches[1]);
      }
    }
  }
}

// Enable output buffering
ob_start();


// Generate the query string
if (!$paged_string) {
  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $paged_string = '&paged=' . $paged;
}

if (!isset($promoted_order)) {
  $promoted_order = filter_input(INPUT_COOKIE, 'promoted_order', FILTER_VALIDATE_INT, array("options" => array("default" => myarcadetheme_get_option('promoted_order', 1))));
}

$query = $paged_string . myarcadetheme_get_order($promoted_order) . myarcadetheme_mobile_tag() . '&posts_per_page=' . $count . $category . myarcadetheme_exclude_blog();

$the_query = new WP_Query($query);

if ($the_query->have_posts()) {
  while ($the_query->have_posts()) :
    $the_query->the_post();

    $meta = get_post_meta(get_the_ID());
?>
    <li>
      <div class="gmcn-midl css-hzvvev" id="thumb-<?php echo get_the_ID() ?>" onclick="window.location = '<?php the_permalink(); ?>'">
        <figure class="gm-imag">
          <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php myarcade_thumbnail(array('width' => 148, 'height' => 148, 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option('lazy_load_animation'))); ?>
          </a>
        </figure>

        <div class="css-46c6u3" id="pre-video-<?php echo get_the_ID() ?>">
          <?php if (!empty($meta['mabp_pre_video'][0])) { ?>
            <img src="<?php echo $meta['mabp_pre_video'][0] ?>" title="<?php the_title_attribute(); ?>">
          <?php } ?>
        </div>
        <div class="css-2cdjcp"></div>
      </div>

    </li>

  <?php
  endwhile;
  // Restore original Post Data
  wp_reset_postdata();
} else {
  ?>
  <li id="notfoundpromotedgames"><?php _e('No games found', 'myarcadetheme'); ?></li>
<?php
}

ob_end_flush();
