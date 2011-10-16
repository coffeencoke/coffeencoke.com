<?php get_header(); ?>	
<div id="wrapper">
	<div id="content-wrapper">
		<div id="content">
			
			
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<?php 
			# Exclude specific categories, some categories are used for their own specific pages
			if(!in_category(wp_list_excluded_category_ids())){ 
			?>
			<div class="post-wrapper">
				<div class="post_header">
					<span class="titles">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
					</span>
					<?php edit_post_link('Edit',''); ?> 
					<div class="post_meta">
						Added at <?php the_time('g:i a') ?> by <?php the_author() ?>
						<br />
						Posted in <?php the_category(', ') ?>
						<br />
						Tagged with <?php the_tags(''); ?>
						<br />
						<img src="<?php bloginfo('stylesheet_directory'); ?>/images/icon3.gif" alt="icon3" />
						<?php comments_popup_link('Be the first to comment &raquo;', '1 Comment &raquo;', '% Comments &raquo;'); ?>
					</div>
				</div>
				<div class="date">
					<span class="month"><?php the_time('M') ?></span>
					<span class="day"><?php the_time('j') ?></span>
				</div>
				<div style="clear: both;"></div>
				<div class="post">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>
			</div>
			<?php comments_template(); ?>
			<?php } ?>
			<?php endwhile; ?>

			<p class="pagination">
				<?php next_posts_link('&laquo; Previous Entries') ?> 
				<?php previous_posts_link('Next Entries &raquo;') ?>
			</p>

			<?php else : ?>

			<h2 align="center">Not Found</h2>
			<p align="center">Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>
		</div>
	</div>
	<?php get_sidebar(); ?>    
	<?php get_footer(); ?>   
</body>
</html>