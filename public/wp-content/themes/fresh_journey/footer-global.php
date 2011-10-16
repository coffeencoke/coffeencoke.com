<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
    
<?php thematic_abovefooter(); ?>    

	<div id="prefooter">
		<div id='contact' class='box rounded black'>
			<h1 class='number'>814.753.4951 - </h1>
			<h1>
				<a href='mailto:info@westarete.com'>info@westarete.com</a>
			</h1>
			<h2>
				<a href='http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=west+arete+computing&amp;sll=40.790709,-77.838877&amp;sspn=0.010413,0.022724&amp;ie=UTF8&amp;ll=40.792921,-77.857511&amp;spn=0.010413,0.022724&amp;z=16&amp;iwloc=A' target='_blank'>
					301 S Allen St. Suite 107 - State College, PA 16801
				</a>
			</h2>
		</div>

		<div id='planet' class='box rounded white'>
			<div id='picture'>
				<a href='http://www.onepercentfortheplanet.org' title='One Percent for the Planet' target='_blank'>
					<img src='/wp-content/uploads/2009/08/one_percent_logo.png' title='One Percent for the Planet' alt='One Percent for the planet' />
				</a>
			</div>
			<div id='description'>
				<h3>
					West Arete Computing has always donated at least 1% of sales to
					local nonprofit environmental groups, and is a proud member of 1%
					For The Planet.
				</h3>
			</div>
		</div>
	</div>
	
<?php thematic_belowfooter(); ?>  

<?php wp_footer(); ?>

<?php thematic_after(); ?>
