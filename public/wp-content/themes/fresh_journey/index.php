<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
get_header() ?>
<div id="content">
  <div id="blog" class="box rounded white">
  	<?php thematic_navigation_above();?>
  	<?php get_sidebar('index-top') ?>
  	<?php thematic_above_indexloop() ?>
  	<?php thematic_indexloop() ?>
  	<?php thematic_below_indexloop() ?>
  	<?php get_sidebar('index-bottom') ?>
  	<?php thematic_navigation_below();?>
  </div>  
</div>

<?php get_footer() ?>