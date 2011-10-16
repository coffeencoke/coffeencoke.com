<?php

// include WP functions
require_once("../../../wp-blog-header.php");

// include TB library
include_once('lib.php');

// include JSON library
class_exists('Services_JSON') || require('JSON.php');
$json = new Services_JSON();

$tb_o = get_option('tweet-blender');
 
if ($_GET['action'] == 'get_config') {
	// remove options not used by widget/archie
	unset($tb_o['general_check_sources']);
	unset($tb_o['archive_page_id']);
	unset($tb_o['widget_view_more_url']);
	// return the rest to client
	echo $json->encode($tb_o);
}

// get search results
elseif ($_GET['action'] == 'search') {

	// check if there is a cache file
	$cache_file = dirname(__FILE__) . '/cache/search.json';
	if (!$tb_o['advanced_disable_cache'] && file_exists($cache_file)) {
		// make sure it's fresh enough
		if ($tb_o['widget_refresh_rate']) {
			$cache_ttl = $tb_o['widget_refresh_rate'];
		}
		else {
			$cache_ttl = 300;	// default to 5 mins
		}
		
		if (time() - filemtime($cache_file) < $cache_ttl) {
			echo file_get_contents($cache_file);
			return;
		}
	}

 	// if we could get it, return data
	if (($jsonData = tb_get_url_content('http://search.twitter.com/search.json?q=&ors=' . urlencode($_GET['ors']) . '&rpp=' . $_GET['rpp'] . '&page=1')) != false) {
		echo $jsonData;

		// update cache
		if (!$tb_o['advanced_disable_cache']) {
			tb_save_cache_file($cache_file, stripslashes($jsonData));
		}
	}
	// else, report an error
	else {
		list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
		echo $json->encode(array('ERROR' => $status_code . " " . $msg));
	}
}

// get user's timeline
elseif ($_GET['action'] == 'user_timeline') {

	// check if there is a cache file
	$cache_file = dirname(__FILE__) . '/cache/' . $_GET['screen_name'] . '.json';
	if (!$tb_o['advanced_disable_cache'] && file_exists($cache_file)) {
		// make sure it's fresh enough
		
		if ($tb_o['widget_refresh_rate']) {
			$cache_ttl = $tb_o['widget_refresh_rate'];
		}
		else {
			$cache_ttl = 300;	// default to 5 mins
		}
		
		if (time() - filemtime($cache_file) < $cache_ttl) {
			echo file_get_contents($cache_file);
			return;
		}
	}
	
 	// if we could get it, return data
	if (($jsonData = tb_get_url_content('http://twitter.com/statuses/user_timeline.json?screen_name=' . $_GET['screen_name'] . '&count=' . $_GET['count'])) != false) {
		echo $jsonData;
		
		// update cache
		if (!$tb_o['advanced_disable_cache']) {
			tb_save_cache_file($cache_file, stripslashes($jsonData));
		}
	}
	// else, report an error 
	else {
		list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
		echo $json->encode(array('ERROR' => $status_code . " " . $msg));
	}
}

// check rate limit
elseif ($_GET['action'] == 'rate_limit_status') {
  // if we could get it, return the actual number
  if (($jsonData = tb_get_url_content('http://twitter.com/account/rate_limit_status.json')) != false) {
    echo $jsonData;
  }
  // else, assume nothing is left 
  else {
    list($version,$status_code,$msg) = explode(' ',$http_response_header[0], 3);
  	echo $json->encode(array('ERROR' => 1, 'msg' => $status_code . " " . $msg));
  }
}

// cache data
elseif($_GET['action'] == 'cache_data') {

	// make sure request came from valid source
	if (array_key_exists('HTTP_REFERER', $_SERVER)) {
		$referer = parse_url($_SERVER['HTTP_REFERER']);
		if ($referer['host'] != $_SERVER['SERVER_NAME']) {
			echo $json->encode(array('ERROR' => 1, 'msg' => "Request from unauthorized page. \n" . $_SERVER['SERVER_NAME'] . "\n" . $referer['host']));
			exit;
		}
	}
	
	// make sure source is in the admin-defined set
	$config = get_option('tweet-blender');
	$sources = 	split(',',$config['general_source_ids']);
	if ($_POST['source'] != "search" && !in_array("@" . $_POST['source'], $sources)) {
		echo $json->encode(array('ERROR' => 1, 'msg' => 'Invalid source. Not in ' . $config['general_source_ids']));
		exit;
	}
	
	// make sure data is realy JSON
	$data = stripslashes($_POST['data']);
	if($decoded = $json->decode($data)) {
		if ($_POST['source'] == "search") {
  			if (!is_array($decoded->{'results'})) {
				echo $json->encode(array('ERROR' => 1, 'msg' => 'Invalid data for search cache ' . gettype($decoded->{'results'})));
				exit;
			}
 		}
		elseif (!is_array($decoded)) {
			echo $json->encode(array('ERROR' => 1, 'msg' => 'Invalid data for screen name cache' . gettype($decoded)));
			exit;
		}
	}
	else {
		echo $json->encode(array('ERROR' => 1, 'msg' => 'Invalid data format'));
		exit;
	}
	
	// make sure cache directory exists
	$cache_dir = dirname(__FILE__) . '/cache';
	if (!is_dir($cache_dir)) {
		if(!mkdir($cache_dir)) {
			echo $json->encode(array('ERROR' => 1, 'msg' => 'Cannot create cache dir'));
			exit;
		}
	}

	$cache_file = $cache_dir . '/' . $_POST['source'] . '.json';

	// save file
	if(!tb_save_cache_file($cache_file, $data)) {
		echo $json->encode(array('ERROR' => 1, 'msg' => 'Cannot save cache file'));
		exit;
	}
	
	// return OK
	echo $json->encode(array('OK' => 1));
}

function tb_save_cache_file($cache_file,$data) {
	if ($cf = @fopen($cache_file,'w')) {
		fwrite($cf,$data);
		fclose($cf);
		return true;
	}
	else {
		return false;
	}
}

?>