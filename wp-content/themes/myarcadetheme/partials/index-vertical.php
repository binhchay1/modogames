<?php global $myarcadetheme_loop; ?>

<li>
  <div class="blk-cn">
    <div class="titl"><a href="<?php echo get_category_link( $myarcadetheme_loop['category']->cat_ID ); ?>"><?php echo $myarcadetheme_loop['category']->name; ?></a> <a class="botn-mrgm fa-plus" href="<?php echo get_category_link( $myarcadetheme_loop['category']->cat_ID ); ?>"><?php _e('MORE GAMES', 'myarcadetheme'); ?></a></div>
    <ul class="lst-gams-vert">
      <?php $gamecount = 0; ?>
      <?php foreach ( $myarcadetheme_loop['games'] as $post) : $gamecount++; ?>
        <?php if ( 2 == $myarcadetheme_loop['count'] && 1 == $gamecount && myarcadetheme_get_option( 'vertical_box_banner' ) ) : ?>
          <li>
            <div class="bnr-cnt">
              <div class="bnr250">
                <?php echo myarcadetheme_get_option( 'vertical_box_banner' ); ?>
              </div>
            </div>
          </li>
          <?php continue; ?>
        <?php endif; ?>

        <li>
          <div class="gmcn-midl">
            <figure class="gm-imag">
              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php myarcade_thumbnail( array( 'width' => 120, 'height' => 120, 'lazy_load' => myarcadetheme_get_option('lazy_load'), 'show_loading' => myarcadetheme_get_option( 'lazy_load_animation' ) )); ?>
              </a>
            </figure>
            <div class="gm-text">
              <div class="gm-titl">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                  <?php the_title(); ?>
                </a>
              </div>

              <?php myarcadetheme_rate_and_view(); ?>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</li>

<?php if ( $myarcadetheme_loop['count'] % 3 == 0 ) :?>
  <li class="clrmt"></li>
<?php endif; ?>