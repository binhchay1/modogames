<div class="blk-cn post-list">
  <?php if ( myarcadetheme_get_option( 'pregame', 1 ) ) : ?>
  <div class="titl"><?php _e('GAME INSTRUCTIONS', 'myarcadetheme'); ?></div>
  <?php else: ?>
		<div class="titl"><h2>
			<?php _e('Detailed description of the ', 'myarcadetheme'); ?> <?php echo the_title() ?>
			</h2></div>
  <?php endif; ?>
  <div class="txcn" itemprop="text">
    <?php
    $banner = myarcadetheme_get_option( 'game_content_banner' );
    if ( $banner ) : ?>
      <div class="contentbnr300">
        <?php echo $banner; ?>
      </div>
    <?php endif ?>
	  <?php 
	  $get_post_meta = get_post_meta(get_the_ID());
	  $date = get_the_modified_date('F j, Y', get_the_ID());
	  $dateTime = get_the_modified_date('Y-m-d', get_the_ID());
	  
	  ?>
		<style>
			.stats-wrapper {
    			display: flex;
    			flex-wrap: wrap;
    			margin: 0 10px;
			}
			
			.game-meta {
    			display: table;
    			flex-grow: 1;
    			line-height: 2;
			}
			
			.meta-row {
    			display: table-row;
    			width: 100%;
			}
	
			.meta-label {
				border-top: #ddd solid 1px;
			}
			
			.meta-value {
    			display: table-cell;
    			border-top: #ddd solid 1px;
    			padding: 0 10px;
    			text-align: left;
    			width: 50%;
			}
		</style>
		<div class="stats-wrapper">
			<ul class="game-meta info" style="margin-top:15px !important;">
				<li class="meta-row">
					<div class="meta-label subtle">Game Type</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_game_type'][0] ?></div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Technology</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_technology'][0] ?></div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Supported Devices</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_supported'][0] ?></div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Game Resolution</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_width'][0] ?> x <?php echo $get_post_meta['mabp_height'][0] ?></div>
				</li>
			</ul>
			<ul class="game-meta info">
				<li class="meta-row">
					<div class="meta-label subtle">Last Updated</div>
					<div class="meta-value">
						<time datetime="<?php echo $dateTime ?>"><?php echo $date ?></time>
					</div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Play Count</div>
					<div class="meta-value"><?php echo $get_post_meta['myarcade_plays'][0] ?></div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Platform</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_platform'][0] ?></div>
				</li>
				<li class="meta-row">
					<div class="meta-label subtle">Rating</div>
					<div class="meta-value"><?php echo $get_post_meta['mabp_rating'][0] ?>%</div>
				</li>
			</ul>
		</div>
    <p>
      <?php
      $instructions = myarcade_instructions(false);
      if ( ! empty( $instructions ) ) {
        if ( ! myarcadetheme_get_option( 'pregame', 1 ) ) {
          // Display game description
          echo myarcadetheme_content();

          $myarcade_general = get_option( 'myarcade_general' );
          if ( strpos( $myarcade_general['template'], '%INSTRUCTIONS%' ) !== false ) {
            // Display game instructions, too
            echo "<p>". $instructions . "</p>";
          }
        }
        else {
          echo $instructions;
        }
      }
      else {
		?>
	  <?php
        echo myarcadetheme_content();
      }
      ?>
    </p>

    <?php
    // Display some manage links if logged in user is an admin
    myarcadetheme_admin_links();
    ?>
  </div>
</div>