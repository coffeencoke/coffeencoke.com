<?php

// include JSON library
class_exists('Services_JSON') || require('JSON.php');

add_action( 'admin_print_scripts', 'tb_admin_load_scripts' );
function tb_admin_load_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-tabs' );
}

function tweet_blender_admin_page() {
 
 	global $tb_refresh_periods, $tb_option_names, $tb_languages;
		 
    // Read in existing option values from database
	$tb_o = get_option('tweet-blender');
		
	// set defaults
	if ($tb_o['widget_tweets_num'] < 1) {
		$tb_o['widget_tweets_num'] = 3;
	}
	if ($tb_o['archive_tweets_num'] < 1) {
		$tb_o['archive_tweets_num'] = 20;
	}
	if (!array_key_exists('tb_check_sources',$tb_o)){
		$tb_o['general_check_sources'] = true;
	}
	if (!array_key_exists('general_tiny_urls',$tb_o)){
		$tb_o['general_tiny_urls'] = "keep";
	}

    // See if the user has posted us some information
    if( $_POST['tb_new_data'] == 'Y' ) {

		// validate input
		$errors = array();
		
		$spaces = '/\s+/';
		$_POST['general_source_ids'] = preg_replace($spaces,'',$_POST['general_source_ids']);
		$sources = split(',', $_POST['general_source_ids']);
		$sources = array_filter($sources);
		if (sizeof($sources) < 1) {
			$errors[] = 'Please provide at least one @screen_name, #hashtag, or keyword';
		}
		// check sources
		if($_POST['general_check_sources']) {
			
			$json = new Services_JSON();
			
			$source_check_result = '<br><br>Source check results:';
			$have_bad_sources = false; $log_msg = '';
			foreach ($sources as $src) {
				// if it's a screen name, use timeline API
				if (stripos($src,'@') === 0) {
					$apiUrl = 'http://twitter.com/statuses/user_timeline.json?screen_name=' . substr($src,1);
				}
				// else assume it's a hashtag or keyword
				else {
					$apiUrl = 'http://search.twitter.com/search.json?q=' . urlencode($src);
				}
				
				// try to get data from Twitter
				if ($data = tb_get_url_content($apiUrl)) {
    				$jsonData = $json->decode($data);
					if ($jsonData->{error} && strpos($jsonData->{error},"Rate limit exceeded") === false) {
						$have_bad_sources = true;
						$source_check_result .= ' ' . $src . ' - <span class="fail">FAIL</span>';
						$log_msg .= "($src) json error: " . $jsonData->{error} . "\n";
					}
					else {
						$source_check_result .= ' ' . $src . ' - <span class="pass">OK</span>';
					}
				}
				// if failed
				else {
					$have_bad_sources = true;
					$source_check_result .= ' ' . $src . ' - <span class="fail">FAIL</span>';
					list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
					$log_msg .= "($src) HTTP error: $version, $status_code, $msg\n";
				}
			}
			
			if ($have_bad_sources) {
				$errors[] = "Please remove sources that failed from the list <!-- $log_msg -->";
			}
		}

        // if all is good, save the posted value in the database
		if (sizeof($errors) < 1) {

			$_POST['general_cache_ttl'] = ceil(60*60 / 100 / sizeof($sources));
			$_POST['general_source_ids'] = join(',',$sources);
			
			foreach($tb_option_names as $post_key) {
				$tb_o[$post_key] = $_POST[$post_key];
			}
			
			// unset archive page ID if archive is disabled
			if($tb_o['archive_is_disabled']) {
				unset($tb_o['archive_page_id']);
			}
			update_option('tweet-blender',$tb_o);
	
	        // Put an options updated message on the screen
			$message = '<div class="updated"><p><strong>Settings saved.' . $source_check_result . '</strong></p></div>';
		} else {
			$message = '<div class="error"><strong><ul><li>' . join('</li><li>',$errors) . '</li></ul>' . $source_check_result . '</strong></div>';
			$tb_o = $_POST;
		}
    }
?>

<link type="text/css" href="http://jqueryui.com/latest/themes/base/ui.all.css" rel="stylesheet" /> 
<style type="text/css">
a.info-icon {
	-moz-opacity:.30; filter:alpha(opacity=30); opacity:.30;
}

a.info-icon:hover {
	-moz-opacity:1; filter:alpha(opacity=100); opacity:1;
}

a.info-icon img {
	vertical-align: middle;
}

#admin-links {
	float:right;
	display:inline;
	padding-right:15px;
	text-align:center;
}

.form-table {
	clear:none;
	display:inline;
}

.setting-description {
	font-style:italic;
	font-size:80%;
}
.pass {
	color:#00FF00;
}
.fail {
	color:#FF0000;
}

.ui-tabs .ui-tabs-hide {
     display: none;
}

#icon-tweetblender {
	-moz-background-clip:border;
	-moz-background-inline-policy:continuous;
	-moz-background-origin:padding;
	background:transparent url(<?php bloginfo('wpurl'); ?>/wp-content/plugins/tweet-blender/img/tweetblender-logo_32x32.png) no-repeat;
}

</style>

<script type="text/javascript">
  
  // make tabs
  jQuery(document).ready(function(){
    var tabsElement = jQuery("#tabs").tabs({
	    show:function(event, ui) {
			
			// find out index
			var tabsEl = jQuery('#tabs').tabs();
			var selectedTabIndex = tabsEl.tabs('option', 'selected');

	        jQuery('#tb_tab_index').val(selectedTabIndex);
	        return true;
	    }
	});
	
	// reopen last used tab
    tabsElement.tabs('select', <?php if($_POST['tb_tab_index']) { echo $_POST['tb_tab_index']; } else { echo 0; } ?>);

  });

</script>

<div class="wrap">
	<div id="icon-tweetblender" class="icon32"><br/></div><h2><?php _e('Tweet Blender', 'mt_trans_domain' ); ?></h2>

	<?php echo $message; ?>
	 
	<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" id="tb_new_data" name="tb_new_data" value="Y">
	<input type="hidden" id="tb_tab_index" name="tb_tab_index" value="">

	<div id="tabs">
    <ul style="height:35px;">
        <li><a href="#tab-1"><span>General</span></a></li>
        <li><a href="#tab-2"><span>Widget</span></a></li>
        <li><a href="#tab-3"><span>Archive</span></a></li>
        <li><a href="#tab-4"><span>Filters</span></a></li>
        <li><a href="#tab-5"><span>Advanced</span></a></li>
        <li><a href="#tab-6"><span>Help</span></a></li>
    </ul>

    <div id="tab-1">
    	<!-- General settings -->
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="general_source_ids"><?php _e('Twitter Sources', 'mt_trans_domain' ); ?>: 
			</label><br>
			<input type="checkbox" name="general_check_sources"<?php if ($tb_o['general_check_sources']) echo " checked"; ?>> Validate when saving
			</th>
			<td valign="top">
				<textarea name="general_source_ids" rows=2 cols=60 wrap="soft"><?php echo $tb_o['general_source_ids']; ?></textarea> 
				<br/>
				<span class="setting-description">Keywords, @screen_names or #hashtags separated with commas. e.g. <b>development</b>, <b>#tweetblender</b>, <b>@knovitchenko</b>, <b>#twitter</b></span>
			</td>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="general_link_urls">
			<input type="checkbox" name="general_link_urls"<?php if ($tb_o['general_link_urls']) echo " checked"; ?>>
			<?php _e("Link http &amp; https URLs insde tweet text", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="general_tiny_urls"><?php _e('Tiny/shortened URLs', 'mt_trans_domain' ); ?>: </label></th>
			<td valign="top">
				<input type="radio" name="general_tiny_urls" value="keep"<?php if ($tb_o['general_tiny_urls'] == "keep") echo ' checked="checked"'; ?>> <?php _e('Keep as is', 'mt_trans_domain' ); ?><br/>
				<input type="radio" name="general_tiny_urls" value="showicon"<?php if ($tb_o['general_tiny_urls'] == "showicon") echo ' checked="checked"'; ?>> Place <img src="<?php bloginfo('wpurl'); ?>/wp-content/plugins/tweet-blender/img/urlexpand-icon.png"> icon next to link and show full/expanded url when mouse is over the icon<br/>
				<input type="radio" name="general_tiny_urls" value="showhint"<?php if ($tb_o['general_tiny_urls'] == "showhint") echo ' checked="checked"'; ?>> <?php _e('Show full/expanded url when mouse is over the link', 'mt_trans_domain' ); ?><br/>
				<input type="radio" name="general_tiny_urls" value="replace"<?php if ($tb_o['general_tiny_urls'] == "replace") echo ' checked="checked"'; ?>> <?php _e('Replace with full/expanded url', 'mt_trans_domain' ); ?><br/>
				<span class="setting-description">Note: url expand feature uses <a href="http://urlexpand.com" target="_blank">http://urlexpand.com</a></span>
			</td>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="general_link_screen_names">
			<input type="checkbox" name="general_link_screen_names"<?php if ($tb_o['general_link_screen_names']) echo " checked"; ?>>
			<?php _e('Link @screenname inside tweet text', 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="general_link_hash_tags">
			<input type="checkbox" name="general_link_hash_tags"<?php if ($tb_o['general_link_hash_tags']) echo " checked"; ?>>
			<?php _e("Link #hashtags insde tweet text", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		</table>
	</div>

    <div id="tab-2">
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="widget_tweets_num"><?php _e('Refresh', 'mt_trans_domain' ); ?>:
			</label></th>
			<td>
			<select name="widget_refresh_rate">
				<?php
				foreach ($tb_refresh_periods as $name => $sec) {
					echo '<option value="' . $sec . '"';
					if ($sec == $tb_o['widget_refresh_rate']) {
						echo ' selected';
					}
					echo '>' . $name . '</option>';
				}
			?></select></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="widget_tweets_num"><?php _e('Maximum number of tweets to show', 'mt_trans_domain' ); ?>:
			</label></th>
			<td>
			<select name="widget_tweets_num">
				<?php
				for ($i = 1; $i <= 10; $i++) {
					echo '<option value="' . $i . '"';
					if ($i == $tb_o['widget_tweets_num']) {
						echo ' selected';
					}
					echo '>' . $i . '</option>';
				}
			?></select></td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="widget_view_more_url"><?php _e('URL for &quot;view more&quot; link', 'mt_trans_domain' ); ?>:
			</label></th>
			<td><input size="40" type="text" name="widget_view_more_url" value="<?php echo $tb_o['widget_view_more_url']; ?>"><br/>
				<?php
					if ($archive_post = tb_get_archive_post_id()) {
						echo '<span class="setting-description">Leave blank to use <a href="page.php?action=edit&post=' . $archive_post . '" target="_blank">existing automatically-created page</a></span>';
					}
				?>
			</td>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="widget_show_photos">
			<input type="checkbox" name="widget_show_photos"<?php if ($tb_o['widget_show_photos']) echo " checked"; ?>>
			<?php _e("Show user's photo for each tweet", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="widget_show_source">
			<input type="checkbox" name="widget_show_source"<?php if ($tb_o['widget_show_source']) echo " checked"; ?>>
			<?php _e("Show tweet source", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="widget_show_reply_link">
			<input type="checkbox" name="widget_show_reply_link"<?php if ($tb_o['widget_show_reply_link']) echo " checked"; ?>>
			<?php _e("Show reply link for each tweet (on mouse over)", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="widget_show_follow_link">
			<input type="checkbox" name="widget_show_follow_link"<?php if ($tb_o['widget_show_follow_link']) echo " checked"; ?>>
			<?php _e("Show follow link for each tweet (on mouse over)", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		</table>
	</div>
	
    <div id="tab-3">
	<!-- Archive Page Settings -->
		<table class="form-table">
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="archive_is_disabled">
			<input type="checkbox" name="archive_is_disabled"<?php if ($tb_o['archive_is_disabled']) echo " checked"; ?>>
			<?php _e('Disable archive page', 'mt_trans_domain' ); ?> 
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="archive_tweets_num"><?php _e('Maximum number of tweets to show', 'mt_trans_domain' ); ?>:
			</label></th>
			<td>
			<select name="archive_tweets_num">
				<?php
				for ($i = 10; $i <= 80; $i+=10) {
					echo '<option value="' . $i . '"';
					if ($i == $tb_o['archive_tweets_num']) {
						echo ' selected';
					}
					echo '>' . $i . '</option>';
				}
			?></select></td>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="archive_show_photos">
			<input type="checkbox" name="archive_show_photos"<?php if ($tb_o['archive_show_photos']) echo " checked"; ?>>
			<?php _e("Show user's photo for each tweet", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="archive_show_source">
			<input type="checkbox" name="archive_show_source"<?php if ($tb_o['archive_show_source']) echo " checked"; ?>>
			<?php _e("Show tweet source", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="archive_show_reply_link">
			<input type="checkbox" name="archive_show_reply_link"<?php if ($tb_o['archive_show_reply_link']) echo " checked"; ?>>
			<?php _e("Show reply link for each tweet (on mouse over)", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="archive_show_follow_link">
			<input type="checkbox" name="archive_show_follow_link"<?php if ($tb_o['archive_show_follow_link']) echo " checked"; ?>>
			<?php _e("Show follow link for each tweet (on mouse over)", 'mt_trans_domain' ); ?>
			</label>
			</th>
		</tr>
		</table>
	</div>
	
	<div id="tab-4">
	<!-- Filtering -->
		<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="filter_lang"><?php _e('Show only tweets in ', 'mt_trans_domain' ); ?>:</label></th>
			<td>
			<select name="filter_lang">
				<?php
				foreach ($tb_languages as $code => $lang) {
					echo '<option value="' . $code . '"';
					if ($code == $tb_o['filter_lang']) {
						echo ' selected';
					}
					echo '>' . $lang . '</option>';
				}
			?></select>
			<span class="setting-description">
				Applies to #hashtags and keywords only. Not applicable to @screennames
			</span>
			</td>
		</tr>
		<tr valign="top">
	 		<th class="th-full" colspan="2" scope="row">
			<input type="checkbox" name="filter_hide_replies"<?php if ($tb_o['filter_hide_replies']) echo " checked"; ?>>
			<label for="filter_hide_replies"><?php _e("Hide tweets that are in reply to other tweets", 'mt_trans_domain' ); ?></label>
			</th>
		</tr>
		</table>
	</div>
	
	<div id="tab-5">
	<!-- Advanced Settings -->
		<table class="form-table">
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="advanced_reroute_on">
			<input type="checkbox" name="advanced_reroute_on"<?php if ($tb_o['advanced_reroute_on']) echo " checked"; ?>>
			<?php _e('Re-route Twitter traffic through this server', 'mt_trans_domain' ); ?> 
			</label><br/>
			<span class="setting-description">This option allows you to reroute all API calls to Twitter via your server. This is to be used ONLY if your server is a white-listed server that has higher connection allowance than each individual user.  Each user can make up to 150 Twitter API connections per hour. Each visitor to your site will have their own limit i.e. their own 150. Checking the box will make all visitors to the site use your server's connection limit, not their own limit. If you did not prearranged with Twitter to have that limit increased that means that it will be 150 for ALL visitors - be careful.</span>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="advanced_show_limit_msg">
			<input type="checkbox" name="advanced_show_limit_msg"<?php if ($tb_o['advanced_show_limit_msg']) echo " checked"; ?>>
			<?php _e('Notify user when Twitter API connection limit is reached', 'mt_trans_domain' ); ?> 
			</label><br/>
			<span class="setting-description">
				When the API connection limit is reached and there is no cached data Tweet Blender can't show new tweets. If you check this box the plugin will show a message to user that will tell them that limit has been reached. In addition, the message will show how soon fresh tweets will be available again. If you don't check the box the message will not be shown - the tweets just won't be refreshed until plugin is able to get fresh data.
			</span>
			</th>
		</tr>
		<tr valign="top">
			<th class="th-full" colspan="2" scope="row">
			<label for="advanced_disable_cache">
			<input type="checkbox" name="advanced_disable_cache"<?php if ($tb_o['advanced_disable_cache']) echo " checked"; ?>>
			<?php _e('Disable data caching', 'mt_trans_domain' ); ?> 
			</label><br/>
			<span class="setting-description">
				Every time TweetBlender refreshes, it stores data it receives from Twitter into a special cache on your server. Once a user reaches his API connection limit TweetBlender starts using cached data. Cached data is centralized and is updated by all users so even if one user is at a limit s/he can still get fresh tweets as cache is updated by other users that haven't yet reached their limit. If you don't want to cache data (to save bandwidth or for some other reason) then check this box.
			</span>
			</th>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="general_timestamp_format"><?php _e('Timestamp Format', 'mt_trans_domain' ); ?>:
			</label></th>
			<td><input type="text" name="general_timestamp_format" value="<?php echo $tb_o['general_timestamp_format']; ?>"> <span class="setting-description"><br/>
				leave blank = verbose from now ("4 minutes ago")<br/>
				h = 12-hour format of an hour with leading zeros ("08")<br/>
				i = Minutes with leading zeros ("01")<br/>
				s = Seconds, with leading zeros ("01")<br/>
				<a href="http://kirill-novitchenko.com/2009/05/configure-timestamp-format/">additional format options &raquo;</a>
			</span></td>
		</tr>	
		</table>
	</div>

	<div id="tab-6">
	
	Facebook Fan Page: <a href="http://www.facebook.com/pages/Tweet-Blender/96201618006">http://www.facebook.com/pages/Tweet-Blender/96201618006</a><br/>
	Twitter: <a href="http://twitter.com/tweetblender">http://twitter.com/tweetblender</a><br/>
	Homepage: <a href="http://tweet-blender.com">http://tweet-blender.com</a><br/>
	</div>

	</div>

	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'mt_trans_domain' ) ?>" />
	</p>
</form>
</div>

<?php
 
}

?>
