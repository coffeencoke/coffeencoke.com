<?php
/*
Plugin Name: Tweet Blender
Plugin URI: http://kirill-novitchenko.com/tweet-blender/
Description: Shows your tweets in a sidebar widget. Can combine them with tweets from other authors, tweets for hashtags, and tweets for keywords and blend all of that into a single stream.
Version: 2.3.0
Author: Kirill Novitchenko
Author URI: http://kirill-novitchenko.com
*/

/*  Copyright 2009  Kirill Novitchenko  (email : knovitchenko@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$tb_option_names = array(
	// general configuration options
	'general_source_ids','general_timestamp_format','general_link_screen_names','general_link_hash_tags','general_link_urls','general_check_sources','general_tiny_urls',
	// options related to widget
	'widget_show_photos','widget_show_source','widget_tweets_num','widget_refresh_rate','widget_view_more_url','widget_show_reply_link','widget_show_follow_link',
	// options related to archive page
	'archive_show_photos','archive_show_source','archive_tweets_num','archive_is_disabled','archive_show_reply_link','archive_show_follow_link',
	// special option for data migration
	'upgraded',
	// advanced options
	'advanced_reroute_on','advanced_show_limit_msg','advanced_disable_cache',
	// filtering
	'filter_lang','filter_hide_replies'
);

// register settings page
add_action('admin_menu', 'tweet_blender_admin_menu');
function tweet_blender_admin_menu() {
  add_options_page('Tweet Blender Settings', 'Tweet Blender', 8, __FILE__, 'tweet_blender_admin_page');
}

// generate config
add_action('wp_head', 'add_header_config', 1);
function add_header_config() {

	$tb_o = get_option('tweet-blender');
	
	$settings = array();
	if(is_array($tb_o)) {
		
		// remove options not used by widget/archie
		unset($tb_o['general_check_sources']);
		unset($tb_o['archive_page_id']);
		unset($tb_o['upgraded']);
		unset($tb_o['widget_title']);
		unset($tb_o['tb_check_sources']);
		
		foreach($tb_o as $opt => $val) {
			if ($val == 'on') {
				$settings[] = "'$opt':true";
			}
			elseif ($val == '') {
				$settings[] = "'$opt':false";
			}
			else {
				$settings[] = "'$opt':'$val'";
			}
		}
	}
	else {
		$settings[] = "general_source_ids:''";		
	}

	echo '<script type="text/javascript">';
	echo "\nvar TB_pluginPath = '" . plugins_url('/tweet-blender') . "';\n";
	echo "var TB_config = {\n" . join(",\n",$settings) . "\n}</script>";
}

// register stylesheet
add_action('wp_head', 'add_header_css', 100);
function add_header_css() {
	echo '<link type="text/css" media="screen" rel="stylesheet" href="' . plugins_url('tweet-blender/css/tweets.css') . '" />' . "\n";
}

// add javascript with dependency on jQuery to public pages only
add_action("template_redirect","tb_load_js");
function tb_load_js() {

	$dependencies = array('jquery');	
	$tb_o = get_option('tweet-blender');
	// load PHPDate only if have a custom date
	if ($tb_o['general_timestamp_format'] != '') {
		wp_enqueue_script('phpdate', '/' . PLUGINDIR . '/tweet-blender/js/jquery.phpdate.js', array('jquery'));
		$dependencies[] = 'phpdate';
	}
	// load JSON plugin only if caching is enabled
	if ($tb_o['advanced_disable_cache'] != 'on') {
		wp_enqueue_script('tojson', '/' . PLUGINDIR . '/tweet-blender/js/jquery.json-2.2.min.js', array('jquery'));
		$dependencies[] = 'tojson';
	}
	// load Simpletip plugin only if tooltip for URL expand are needed
	if ($tb_o['general_tiny_urls'] == 'showicon') {
		wp_enqueue_script('simpletip', '/' . PLUGINDIR . '/tweet-blender/js/jquery.simpletip-1.3.1.min.js', array('jquery'));
		$dependencies[] = 'simpletip';
	}
	// load main JS code
	wp_enqueue_script('tbmain', '/' . PLUGINDIR . '/tweet-blender/js/main.min.js', $dependencies);
}

// register the widget and its control panel
add_action("widgets_init", "tb_init_widget");
function tb_init_widget(){
	register_sidebar_widget("Tweet Blender", "tb_widget");
	register_widget_control('Tweet Blender', 'tb_widget_control_panel');
}

// hookup filter to add tweet list to the content of archive page
add_filter('the_content', 'tb_add_archive_page_content');
function tb_add_archive_page_content($content = '') {
	global $post;
	
	// do nothing if archive page is disabled
	$tb_o = get_option('tweet-blender');
	if ($tb_o['archive_is_disabled']) {
		return $content;	
	}
	else {
		// work with pages only, ignore blog posts
		if ($post->post_type != 'page') {
			return $content;
		}
		
		// if looking at archive page, apend list of tweets to content
		if ($post->ID == tb_get_archive_post_id()) {
			$archive_html = '<div id="tweetblender" class="archive">';
			$archive_html .= tb_create_markup();
			$archive_html .= '</div>';
		
			return $content . $archive_html;
		}
		// else, do nothing
		else {
			return $content;
		}
	}
}

function tb_widget_control_panel() {
	global $tb_refresh_periods;
	$tb_o = get_option('tweet-blender');

	$cp_html = '<input type="hidden" name="tb_new_data" value="Y">';

	// specify title
	$cp_html .= '<label for="widget_title">Title:</label><br/>';
	$cp_html .= '<input type="text" class="widefat" name="widget_title" value="' . $tb_o['widget_title'] . '"><br/><br/>';

	// specify refresh
	$cp_html .= '<label for="widget_refresh_rate">Refresh </label>';
	$cp_html .= '<select name="widget_refresh_rate">';
		
	foreach ($tb_refresh_periods as $name => $sec) {
		$cp_html .= '<option value="' . $sec . '"';
		if ($sec == $tb_o['widget_refresh_rate']) {
			$cp_html .= ' selected';
		}
		$cp_html .= '>' . $name . '</option>';
	}
	$cp_html .= '</select><br>';
	
	// select tweets num
	$cp_html .= '<label for="widget_tweets_num">Show <select name="widget_tweets_num">';
	for ($i = 1; $i <= 10; $i++) {
		$cp_html .= '<option value="' . $i . '"';
		if ($i == $tb_o['widget_tweets_num']) {
			$cp_html .= ' selected';
		}
		$cp_html .= '>' . $i . '</option>';
	}
	$cp_html .= '</select> tweets</label><br>';
	
	// show photos checkbox
	$cp_html .= '<label for="widget_show_photos"><input type="checkbox" name="widget_show_photos"';
	if ($tb_o['widget_show_photos']) {
		$cp_html .= " checked";
	}
	$cp_html .= '> Show user\'s photo</label><br>';
	
	// show source checkbox
	$cp_html .= '<label for="widget_show_source"><input type="checkbox" name="widget_show_source"';
	if ($tb_o['widget_show_source']) {
		$cp_html .= " checked";	
	}
	$cp_html .= '> Show tweet source</label><br>';
	
	// show reply link checkbox
	$cp_html .= '<label for="widget_show_reply_link"><input type="checkbox" name="widget_show_reply_link"';
	if ($tb_o['widget_show_reply_link']) {
		$cp_html .= " checked";	
	}
	$cp_html .= '> Show reply link for each tweet</label><br>';

	// show follow link checkbox
	$cp_html .= '<label for="widget_show_follow_link"><input type="checkbox" name="widget_show_follow_link"';
	if ($tb_o['widget_show_follow_link']) {
		$cp_html .= " checked";	
	}
	$cp_html .= '> Show follow link for each tweet</label>';
	
	echo $cp_html; 
 
    // See if the user has posted us some information
    if( $_POST['tb_new_data'] == 'Y' ) {
    	$tb_o['widget_title'] = $_POST['widget_title'];
	   	$tb_o['widget_show_photos'] = $_POST['widget_show_photos'];
		$tb_o['widget_show_source'] = $_POST['widget_show_source'];
		$tb_o['widget_show_reply_link'] = $_POST['widget_show_reply_link'];
		$tb_o['widget_show_follow_link'] = $_POST['widget_show_follow_link'];
		$tb_o['widget_tweets_num'] = $_POST['widget_tweets_num'];
		$tb_o['widget_refresh_rate'] = $_POST['widget_refresh_rate'];
		update_option('tweet-blender',$tb_o);
  	}
}

/**
 * Create HTML for the sidebar widget
 *
 * @uses tb_get_archive_post_id()
 * @uses tb_make_tweet_list()
 */
function tb_widget($args = array()) {

	global $post;
	$tb_o = get_option('tweet-blender');

	
	// don't show widget on the archive page
	$archive_post_id = tb_get_archive_post_id();
	$archive_page_url = $tb_o['widget_view_more_url'];
	
	if ($post->ID != $archive_post_id && $archive_page_url != "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) {
	
	    echo $args['before_widget'];
		if ($tb_o['widget_title']) {
		    echo $args['before_title'] . $tb_o['widget_title'] . $args['after_title'];
		}

		$widget_html .= '<div id="tweetblender">';
		$widget_html .= tb_create_markup();
		if(!$tb_o['archive_is_disabled']) {
			if ($archive_page_url != '') {
				$widget_html .= '<a id="archivelink" href="' . $archive_page_url . '" style="display:none;">view more &raquo;</a>';
			}
			elseif ($archive_post_id > 0) {
				$widget_html .= '<a id="archivelink" href="' . get_permalink($archive_post_id) . '" style="display:none;">view more &raquo;</a>';
			}
		}
		$widget_html .= '</div>';

		echo $widget_html;

		echo $args['after_widget'];
	}
}

function tb_archive($sources = '') {
	$archive_html = '';
	if ($sources != '') {
		$archive_html .= '<script type="text/javascript">TB_config.general_source_ids = "' . $sources . '";</script>';
	}
	$archive_html .= '<div id="tweetblender" class="archive">';
	$archive_html .= tb_create_markup();
	$archive_html .= '</div>';

	echo $archive_html;
}

function tb_create_markup() {
	$html = '<div id="tbheader">';
	$html .= '<img id="twitterlogo" src="' . plugins_url('tweet-blender/img/twitter-logo.png') . '" alt="Twitter Logo">';
	$html .= '<div id="tb_tools"><a id="infolink" href="http://kirill-novitchenko.com" target="_blank" title="TweetBlender by Kirill Novitchenko"> </a>';
	$html .= '<a id="refreshlink" href="javascript:TB_showLoader();TB_blend();" title="Refresh Tweets"><img src="' . plugins_url('tweet-blender/img/ajax-refresh-icon.gif') . '" alt="Refresh"></a></div></div>';
	$html .= '<div id="tb_loading">Initializing...</div>';
	$html .= '<ol id="tweetlist" style="display:none"></ol>';
	return $html;
}

function tb_get_archive_post_id() {
	$tb_o = get_option('tweet-blender');
	// if archive is disabled return null
	if($tb_o['archive_is_disabled']) {
		return null;
	}

	// if we already have page id saved as option, return it
	if ($tb_o && array_key_exists('archive_page_id',$tb_o) && $tb_o['archive_page_id'] > 0) {
		return $tb_o['archive_page_id'];
	}
	// else if we have such a page already, get its id and store as option
	else if ($post = get_page_by_path('tweets-archive')) {
		$tb_o['archive_page_id'] = $post->ID;
		update_option('tweet-blender',$tb_o);
		return $tb_o['archive_page_id'];
	}
	// else create such a page (unless an over-ride by user is provided)
	else if ($tb_o['widget_view_more_url'] == '') {
		if ($post_id = wp_insert_post(array(
			  'post_status' => 'publish',
			  'post_type' => 'page',
			  'post_author' => 1,
			  'post_title' => 'Twitter Feed',
			  'post_content' => 'Our twitter feed.',
			  'post_name' => 'tweets-archive'
		))) {
			$tb_o['archive_page_id'] = $post_id;
			update_option('tweet-blender',$tb_o);
			return $tb_o['archive_page_id'];
		}
		else {
			return null;
		}
	}
	else {
		return null;
	}
}

include_once('admin-page.php');
include_once('lib.php');
?>
