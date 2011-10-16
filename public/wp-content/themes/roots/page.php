<?php


get_header() 

?>

<div id="container">
	<div id="content">
  	<?php the_post() ?>
  	<?php the_content() ?>
  	<?php wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number'); ?>
  	<?php edit_post_link(__('Edit', 'thematic'),'<span class="edit-link">','</span>') ?>
  </div>
</div>

<?php get_footer() ?>