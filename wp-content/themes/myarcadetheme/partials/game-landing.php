<?php
/**
 * The Template for displaying the pre-game (game landing) page
 *
 * @package WordPress
 * @subpackage MyArcadeTheme
 */
?>
<div class="cont">
  <?php myarcadetheme_breadcrumb(); ?>

  <?php
  if ( myarcadetheme_get_option( 'myscorepresenter_widget', 1 ) ) {
    global $mypostid; $mypostid = $post->ID;
  }
  ?>

  <div class="cntcls <?php echo 'sidebar_' . myarcadetheme_get_option( 'sidebar_position', 'right' ); ?>">
    <main class="main-cn cols-n9">
      <article>
        <div class="post-sngl post-game">
          <header>
            <h1 itemprop="name"><?php the_title(); ?></h1>

            <?php if ( function_exists('the_ratings') ) { ?>
            <div class="gm-vote">
                <div><?php the_ratings(); ?></div>
            </div>
            <?php } ?>

            <?php if (
              myarcadetheme_get_option( 'pregame_meta_category', 1) ||
              myarcadetheme_get_option( 'pregame_meta_author', 1) ||
              myarcadetheme_get_option( 'pregame_meta_date', 1) ||
              myarcadetheme_get_option( 'pregame_meta_comment_count', 1)
            ): ?>
            <p class="game_post_meta_data">
              <?php if ( myarcadetheme_get_option( 'pregame_meta_category', 1) ): ?>
              <span class="gm-cate"><?php echo get_the_category_list(' '); ?></span>
              <?php endif; ?>

              <?php if ( myarcadetheme_get_option( 'pregame_meta_author', 1) ): ?>
              <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php printf( esc_attr__( 'View all posts by %s', 'myarcadetheme' ), get_the_author() ); ?>" itemscope="itemscope" itemtype="http://schema.org/Person" >
               <span class="fa-user" itemprop="name"> <?php the_author(); ?> </span>
              </a>
              <?php endif; ?>

              <?php if ( myarcadetheme_get_option( 'pregame_meta_date', 1) ): ?>
              <span class="fa-calendar" itemprop="datePublished"><?php echo get_the_date('d'); ?> <?php echo get_the_date('M'); ?> , <?php echo get_the_date('Y'); ?></span>
              <?php endif; ?>

              <?php if ( myarcadetheme_get_option( 'pregame_meta_comment_count', 1) ): ?>
              <span class="fa-comments" itemprop="commentCount"><?php echo number_format_i18n( get_comments_number() ); ?></span>
              <?php endif; ?>
            </p>
            <?php endif; ?>

            <figure itemprop="image"><?php myarcade_thumbnail( array( 'width' => 58, 'height' => 58, 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) ) ); ?></figure>
          </header>

          <div class="game_content">
            <div class="post-bnr">
              <?php if ( myarcadetheme_get_option( 'pre_game_banner' ) ) { ?>
              <div class="bnr200" itemprop="http://schema.org/WPAdBlock">
                <?php echo myarcadetheme_get_option( 'pre_game_banner' ); ?>
              </div>
              <?php } ?>
              <?php myarcadetheme_play_link(); ?>
            </div>

            <div class="game_info">
              <h2><?php _e('GAME INFO', 'myarcadetheme'); ?></h2>

              <?php echo myarcadetheme_content(); ?>

              <?php
              // Display some manage links if logged in user is an admin
              myarcadetheme_admin_links();
              ?>
            </div>
          </div>
        </div>

        <footer>
          <?php echo get_the_tag_list('<p><span class="fa-tag">'.__('Tags:', 'myarcadetheme').'</span> ', ', ','</p>'); ?>
          <div class="pst-shr">
            <a class="fa-share-alt" href="#"><strong><?php _e('SHARE', 'myarcadetheme'); ?></strong></a>
            <ul class="lst-social">
              <li><a rel="nofollow" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');" href="javascript: void(0);" class="fa-facebook"><span><?php _e('Facebook', 'myarcadetheme'); ?></span></a></li>
              <li><a rel="nofollow" onclick="window.open ('https://www.twitter.com/share?url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');" href="javascript: void(0);" class="fa-twitter"><span><?php _e('Twitter', 'myarcadetheme'); ?></span></a></li>
              <li><a rel="nofollow" onclick="window.open ('https://www.addthis.com/bookmark.php?source=bx32nj-1.0&v=300&url=<?php the_permalink(); ?>');" href="javascript: void(0);" class="fa-plus-square"></a></li>
            </ul>
          </div>
        </footer>
      </article>

      <?php
      if ( myarcadetheme_get_option('myarcadecontrols', 1 ) ) {
        // Display Game Controls if enabled
        get_template_part( "partials/game", "controls" );
      }

      if ( myarcadetheme_get_option('display_video', 1 ) ) {
        // Display game video if enabled
        get_template_part( "partials/game", "video" );
      }

      if ( myarcadetheme_get_option( 'veedi', 0 ) ) {
        // Display Veedi walktrough video
        get_template_part( "partials/game", "veedi" );
      }

      if ( myarcadetheme_get_option( 'display_screenshots', 1 )  ) {
        // Display game screenshots if enabled
        get_template_part( "partials/game", "screenshots" );
      }

      if ( myarcadetheme_get_option( 'game_embed_box', 1 ) ) {
        // Display game embed box if enabled
        get_template_part( "partials/game", "embed-box" );
      }

      if ( myarcadetheme_get_option( 'game_related_games', 0 ) ) {
        // Display related games if enabled
        myarcadetheme_related();
      }

      if ( myarcadetheme_get_option( 'game_comments', 1 ) ) {
        myarcadetheme_comments();
      }
      ?>
    </main>

    <?php get_sidebar(); ?>
  </div>
</div>