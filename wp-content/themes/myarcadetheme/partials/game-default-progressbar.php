<?php
/**
 * Default Progressbar
 *
 * @package WordPress
 * @subpackage MyArcadeTheme
 */
?>
<script type="text/javascript">
  var counter = 1;
  var progress_width;

  function loadgame(wait_time) {
    var percentlimit = <?php echo myarcadetheme_get_option( 'loaded_text_limit', 25 ); ?>;
    var speedindex = <?php echo myarcadetheme_get_option( 'loading_speed', 10 ); ?>;
    var percentlimitstatus = "<?php echo myarcadetheme_get_option( 'loaded_text' ); ?>";
    speedindex = speedindex * 2;
    if ( counter < wait_time) {
      counter = counter + 1;
      document.getElementById("progressbarloadbg").style.width = counter + "px";
      var percentage = Math.round( counter / wait_time * 100);
      window.setTimeout("loadgame('" + wait_time + "')", speedindex );
      if ( (percentage >= percentlimit) && percentlimitstatus ) {
        jQuery("#progressbarloadtext span.gameloading").remove();
        jQuery("#progressbarloadtext span.gameloaded").show();
      }
    }
    else {
      counter = 1;
      window.show_game();
    }
  }

  function show_game() {
    jQuery("#progressbar_wrap, #progressbarloadtext").remove();
    jQuery("#myarcade_game, .game-ctrl").show();
    if (typeof myarcadetheme !== "undefined") {
      myarcadetheme.intrinsicRatioGames.init();
    }
    counter = progress_width;
  }

  jQuery(document).ready( function() {
    progress_width = jQuery("#progressbar").width();
    setTimeout('loadgame(progress_width)', <?php echo myarcadetheme_get_option( 'start_delay', 0 ); ?>);
  });
</script>
<center>
  <div id="progressbar_wrap">
    <?php
    // Show the progress bar banner if available
    $banner_progress = stripslashes( myarcadetheme_get_option( 'preloader_banner' ) );
    if ( !empty($banner_progress) ) {
      ?>
      <div id="loadinggame_ad" style="margin: 15px auto;">
        <?php echo $banner_progress; ?>
      </div>
      <?php
    }
    ?>

    <?php // Display the progress bar ?>
    <div id="progressbar">
      <div id="progressbarloadbg">&thinsp;</div>
    </div>

    <div id="progressbarloadtext">
      <span class="gameloading"><?php _e("Loading ...", 'myarcadetheme' ); ?></span>
      <span class="gameloaded" onclick="window.show_game();"><?php echo myarcadetheme_get_option( 'loaded_text' ); ?></span>
    </div>
  </div>
</center>