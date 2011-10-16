<?php
include ABSPATH . 'wp-includes/twitter.php';

$lastposts = get_posts('numberposts=3');
$tweets = get_west_arete_tweets(4);

include 'footer-global.php';
?>

<div id="footer_ground">
      <?php get_sidebar('subsidiary'); ?>
      <div id="siteinfo">        
  		<?php 
				/* footer text set in theme options in admin */ 
				# echo do_shortcode(__(stripslashes(thematic_footertext($thm_footertext)), 'thematic'));
			?>
	</div><!-- #siteinfo -->
	<div id='footer_content'>
	  <div id='blog'>
	    <h3>Our Thoughts</h3>
			<div class='latest_posts'>
				<?php
				foreach($lastposts as $post) :
			  setup_postdata($post);
				?>
				<a href="<?php the_permalink(); ?>">
				<div class='post' id="post-<?php the_ID(); ?>">
					<span class='title'><h2><?php the_title(); ?></h2></span>
					<span class='date'><?php the_time('m.d.y @ g:i a') ?></span>
					<span class='content'><?php the_excerpt(); ?></span>
				</div>
				</a>
				<?php endforeach; ?>
				<div id='view_all'><a href='/blog'>view all</a></div>
			</div>
  	</div>
		<div class='twitter' id='latest_tweets'>
  	  <h3>What We're Up To</h3>
			<?php display_follow_us_on_twitter_button();  ?>
			<?php display_tweets($tweets); ?>
			<div id='view_all'><a href='/twitter'>view all</a></div>
  	</div>
  </div>
</div><!-- #footer -->

	
	<script src='http://www.google-analytics.com/urchin.js' type='text/javascript'></script>
	<script type='text/javascript'>
	  _uacct = "UA-426568-6";
	  urchinTracker();
	</script>

</body>
</html>
