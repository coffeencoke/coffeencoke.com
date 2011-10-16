<?php 
global $options;
foreach ($options as $value) {
	if (get_option( $value['id'] ) === FALSE) { 
		$$value['id'] = $value['std']; 
	}else{ 
		$$value['id'] = get_option( $value['id'] ); 
	}
}
get_header(); 
?>

<div id="content">
  <div id="blog" class="box rounded white">
	  <?php the_post(); ?>
		
		<?php thematic_navigation_above();?>

		<?php get_sidebar('single-top') ?>

		<?php thematic_singlepost() ?>

		<?php get_sidebar('single-insert') ?>

		<?php thematic_navigation_below();?>

		<?php thematic_comments_template(); ?>
  </div>
  
</div>

<?php get_footer(); ?>