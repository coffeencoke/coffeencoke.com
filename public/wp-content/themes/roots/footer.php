<?php
global $options;
foreach ($options as $value) {
    if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_option( $value['id'] ); }
    }
?>
    </div><!-- #main -->
    </div><!-- #main_wrapper -->
<?php thematic_abovefooter(); ?>    

	<div id="footer">
    <div class="left"></div>
    <div class="center"></div>
    <div class="right"</div>
	</div><!-- #footer -->
	
<?php thematic_belowfooter(); ?>  

</div><!-- #wrapper .hfeed -->

<?php wp_footer(); ?>

<?php thematic_after(); ?>
</body>
</html>