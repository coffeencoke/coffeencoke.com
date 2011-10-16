<!DOCTYPE html>
<html>
<head profile="http://gmpg.org/xfn/11">

<?php 

thematic_doctitle();
thematic_create_contenttype();
thematic_show_description();
thematic_show_robots();
thematic_canonical_url();
thematic_create_stylesheet();
thematic_show_rss();

wp_head(); 

?>
  <script src='/wp-content/themes/fresh_journey/javascripts/curvycorners.js' type='text/javascript'></script>
	<script src='/wp-content/themes/fresh_journey/javascripts/cufon-yui.js' type='text/javascript'></script>
	<script src='/wp-content/themes/fresh_journey/fonts/meta_400.font.js' type='text/javascript'></script>
	<script type='text/javascript'>

	  //<![CDATA[
	    Cufon.replace('h1, h2, h3, h4, h5, h6', { fontFamily: 'Meta' });
	  //]]>

	</script>

</head>

<body class="<?php thematic_body_class() ?>">
<?php thematic_before(); ?>

<?php thematic_aboveheader(); ?>   

  <div id="header">
		
    <?//php wp_page_menu('sort_column=menu_order') ?>
    <div class="menu" class="box rounded white">
      <ul>
        <li><a href="/" title="Home"><h3>Home</h3></a></li>
        <li><a href="/blog" title="Blog"><h3>Blog</h3></a></li>
        <li><a href="/twitter" title="Twitter"><h3>Twitter</h3></a></li>
      </ul>
    </div>
  </div>
  </div>