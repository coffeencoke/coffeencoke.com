<?php 
@header("HTTP/1.1 404 Not found", TRUE, 404);
get_header() 
?>

<div id="content">
  <div class="box rounded white">
  	<?php thematic_404() ?>
  </div>
</div>

<?php get_footer() ?>
