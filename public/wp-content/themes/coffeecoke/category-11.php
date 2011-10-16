<?php get_header(); ?>	

<div id="wrapper">
	<div id="content-wrapper">
		<div id="content">
			
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
			<div class="post-wrapper" id="portfolio_page">
				<table border=0 cellpadding=5>
					<tr>
						<td valign="top" class="thumbnail">
							<a href="<?php echo post_custom('thumbnail'); ?>"><img src="<?php echo post_custom('thumbnail'); ?>" width="300px" /></a>				
						</td>
						<td valign="top" class="content">
							<div class="portfolio_header">
								<span class="titles">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
								</span>
								<?php edit_post_link('Edit',''); ?> 
								<div class="post_meta">
									Added at <?php the_time('g:i a') ?> by <?php the_author() ?>
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
							<div class="post">
								<?php the_content('Read the rest of this entry &raquo;'); ?>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<?php comments_template(); ?>
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