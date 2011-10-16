<?php

/* 
	Plugin Name: Twitter Profile Field
	Plugin URI: http://jayj.dk
	Description: Adds an additional field to the user profile page where they can enter their Twitter username.
	Author: Jayj.dk
	Version: 1.1
	Author URI: http://jayj.dk
	
	Usage:
	If you use it inside the loop just add <?php the_author_meta('twitter'); ?> to show the username.
	If it's outside the loop use <?php the_author_meta('twitter',1); ?>, where 1 is the User ID
	
	Shortcode usage:
	You can use shortcodes to display your Twitter username in posts, pages and text widgets. 
	[twitter-user] will display the username without any markup
	[twitter-user link="yes"] will display the username with a link (<a href="http://twitter.com/username">Username</a>)

*/

function twitter_field() {

	global $user_ID;
	
	if ( preg_match('&profile.php&', $_SERVER['REQUEST_URI'])) {
		$id = $user_ID;
	} elseif($_GET['user_id']) {
		$id = $_GET['user_id'];
	}
	
	$twitter = get_usermeta($id, 'twitter'); 

?>

    <!-- Twitter profile field HTML -->
    <table class="form-table">
    <h3>Twitter</h3>
    <tr>
        <th><label for="twitter">Twitter username</label></th>
        <td><input type="text" name="twitter" id="twitter" value="<?php echo $twitter; ?>" class="regular-text" />
        	<!-- <span class="description">You can write a description here if you want</span> -->
        </td>
    </tr>
    </table> 

<?php 
} // End twitter_field

function save_twitter_field() {

	global $user_ID;
	
	if (preg_match('&profile.php&', $_SERVER['REQUEST_URI'])) {
		$id = $user_ID;
		
	} elseif($_GET['user_id']) {
		$id = $_GET['user_id'];
	}
	
	$twitter = $_POST['twitter'];
	
	update_usermeta($id, 'twitter', $twitter);
}

// Add it to the profile page
add_filter('show_user_profile','twitter_field'); 
add_action('edit_user_profile', 'twitter_field');
add_action('profile_update', 'save_twitter_field');



/*** Create shortcode ***/

function twitter_field_shortcode($atts) {  
	extract(shortcode_atts(array(   
    	"link" => '' 
 	), $atts));
	
	if ( $link == "yes" ) {
		return '<a href="http://twitter.com/'. get_the_author_meta('twitter') .'" class="twitter-profile">'. get_the_author_meta('twitter') .'</a>'; 
	} 
	else {
   		return get_the_author_meta('twitter');  
	}
} 

add_shortcode('twitter-user', 'twitter_field_shortcode');
add_filter('widget_text', 'do_shortcode'); // Allows you to use the shortcode in text widgets 


/* Dashedboard widget */

function twitter_field_dashwidget() { ?>
		<style type="text/css" media="screen">
		.twitter_field  {
			border-bottom: 1px solid #dfdfdf;
			margin-bottom: 15px;
			padding-bottom: 5px;
		}

		</style>
        
	<div class="twitter_field">
        <strong>How to use Twitter Profile Field in Posts, Pages and Text Widgets:</strong>
        <p>If you want to display your Twitter Username using shortcodes in Posts, Pages and Text Widgets use the following code:
        <code>[twitter-user]</code>
        </p>
        <p>If you also want to display it with a link to your profile just use <code>[twitter-user link="yes"]</code></p>
	</div>  
     
    <div> 
    	<strong>How to use Twitter Profile Field in Template files:</strong>
        <p>If you want to display your Twitter Username in your Template files use the following code:
        <code>&#8249;?php the_author_meta('twitter'); ?></code> - if it's <strong>inside</strong> the loop
        </p>
        <p>If you want to display it outside the loop use: <code>&#8249;?php the_author_meta('twitter',1); ?></code>. 1 is the user ID</p>
     </div>
<?php }

function twitter_field_dashboard_widget() {
	wp_add_dashboard_widget( 'twitter_field_dashwidget', 'Twitter Profile Field', 'twitter_field_dashwidget' );
}

add_action('wp_dashboard_setup', 'twitter_field_dashboard_widget');
?>