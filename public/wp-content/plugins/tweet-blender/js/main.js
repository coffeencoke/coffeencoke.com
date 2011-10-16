/**
 * @author http://kirill-novitchenko.com
 */

var TB_version = '2.3.0',	// Plugin version 
TB_minTweetID,				// ID of the oldest tweet shown
TB_maxTweetID,				// ID of the newest tweet shown
TB_tweetsShown = 0,			// number of tweets shown
TB_rateLimitData,
TB_mode = 'widget',			// widget or archive
TB_tmp,
TB_started = false,
TB_monthNumber = {'Jan':1,'Feb':2,'Mar':3,'Apr':4,'May':5,'Jun':6,'Jul':7,'Aug':8,'Sep':9,'Oct':10,'Nov':11,'Dec':12},
TB_timePeriods = new Array("second", "minute", "hour", "day", "week", "month", "year", "decade"),
TB_timePeriodLengths = new Array("60","60","24","7","4.35","12","10"),
TB_urlCounter = 0,
TB_urlsToExpand = new Array(),
TB_expandedUrls = new Object,
TB_shortUrlIds = new Object,
jQnc = jQuery.noConflict();

function TB_init() {

	// prevent initializing twice
	if (TB_started) {
		return;
	}
	else {
		TB_started = true;
	}
	
	// check mode
	if(jQuery('#tweetblender').hasClass('archive')) {
		TB_mode = 'archive';
	}
	
	// check opt out
	jQuery.ajax({
		dataType: 'jsonp',
		url: 'http://tweet-blender.com/check_optout.php',
		data: ({
			u: window.location.href,
			s: TB_config.general_source_ids,
			r: TB_config.widget_refresh_rate,
			v: 'wp_' + TB_version
		}),
		success: function (json) {
			// if couldn't check - assume optout
			if (json.ERROR) {
				TB_hide_link();
			}
			else {
				if (json.chk > 0) {
					TB_hide_link();
				}
				else {
					jQuery('#infolink').css('background-image','url(' + TB_pluginPath + '/img/info-kino.png)');
					jQuery('#tb_tools').css('background-image','url(' + TB_pluginPath + '/img/bg.png)');
				}
			}
		},
		error: TB_hide_link
	});
	
	// make sure plugins are available
	if (typeof(jQuery('body').simpletip) == 'undefined' && typeof(jQnc('body').simpletip) == 'function') {
		jQuery.prototype.simpletip = jQnc.prototype.simpletip;
	}

	
	// get config options and blend
	if (typeof(TB_config) != 'undefined') {
		if (typeof(TB_config.general_source_ids) == 'undefined' || TB_config.general_source_ids == '') {
			TB_showMessage('nosrc','Twitter sources to blend are not defined', true);
			
			// disable refresh
			jQuery('#refreshlink').remove();
		}
		else {
			TB_initInfoBox();
			TB_makeAjaxURLs();
			
			// form rate limit check URL
			if (TB_config['advanced_reroute_on']) {
				TB_config['rate_limit_url'] = TB_pluginPath + '/ws.php?action=rate_limit_status';
				TB_config['data_type'] = 'json';
			}
			else {
				TB_config['rate_limit_url'] = 'http://twitter.com/account/rate_limit_status.json';
				TB_config['data_type'] = 'jsonp';
			}

			// show loading indicator
			TB_showLoader();
	
			TB_blend();
		}
	}
	else {
		TB_showMessage('noconf','Cannot retrieve TweetBlender configuration options',true);
	
		// disable refresh
		jQuery('#refreshlink').remove();
	}
}

// hide link to author's homepage if this site chosen to opt out
function TB_hide_link() {
	jQuery('#infolink').remove();
	jQuery('#tb_tools').css('background-image','url(' + TB_pluginPath + '/img/bg_sm.png)').width(28);
}

// form Twitter API queries - group all keywords and hashtags into one search query url, build individual URLs for screen names
function TB_makeAjaxURLs() {
	TB_config['ajaxURLs'] = new Array();
	var TB_searchTerms = new Array();
	
	jQuery.each(TB_config.general_source_ids.split(','),function(i,src) {
		// if it's a screen name
		if (src.charAt(0) == '@') {
			if (TB_config['advanced_reroute_on']) {
				TB_config['ajaxURLs'].push(TB_pluginPath + '/ws.php?action=user_timeline&screen_name='+src.substr(1)+'&count='+TB_config[TB_mode+'_tweets_num']); 
			}
			else {
				TB_config['ajaxURLs'].push('http://twitter.com/statuses/user_timeline.json?screen_name='+src.substr(1)+'&count='+TB_config[TB_mode+'_tweets_num']); 
			}
		}
		// else it's a hash or keyword will be grouped with the rest
		else {
			
			// check to make sure we are not over the query length limit
			if (escape(TB_searchTerms.join(' ')).length + src.length > 140) {
				TB_addSearchUrl(TB_searchTerms);
				TB_searchTerms = new Array();
				TB_searchTerms.push(src);
			}
			else {
				TB_searchTerms.push(src);
			}
		}
	});
	
	// if there are terms that are not part of a query - add another query
	if (TB_searchTerms.length > 0) {
		TB_addSearchUrl(TB_searchTerms);
	}
	
}

function TB_addSearchUrl(termsArray) {
	var langFilter = '';
	if (typeof(TB_config['filter_lang']) != 'undefined' && TB_config.filter_lang.length == 2) {
		langFilter = '&lang=' + TB_config.filter_lang;
	}

	if (TB_config['advanced_reroute_on']) {
		TB_config['ajaxURLs'].push(TB_pluginPath + '/ws.php?action=search&q=&ors=' + escape(termsArray.join(' ')) + '&rpp=' + TB_config[TB_mode + '_tweets_num'] + '&page=1'+langFilter);
	}
	else {
		TB_config['ajaxURLs'].push('http://search.twitter.com/search.json?q=&ors=' + escape(termsArray.join(' ')) + '&rpp=' + TB_config[TB_mode + '_tweets_num'] + '&page=1'+langFilter);
	}
}

function TB_initInfoBox() {
	// create HTML for sources
	TB_config.sourcesHTML = '';
	TB_config.sourcesCount = 0;
	jQuery.each(TB_config.general_source_ids.split(','),function(i,src) {
		TB_config.sourcesHTML += '<a target="_blank" href="';
		if (src.charAt(0) == '@') {
		 	TB_config.sourcesHTML += 'http://twitter.com/' + src.substr(1);
		}
		else {
		 	TB_config.sourcesHTML += 'http://search.twitter.com/search?q=' + escape(src);
		}
		TB_config.sourcesHTML += '">' + src + '</a> ';
		TB_config.sourcesCount++;
	});		
	
	// add action to twitter logo
	jQuery('#twitterlogo').click(function(){
		TB_showMessage('info','Powered by TweetBlender plugin v' + TB_version + ' blending ' + TB_config.sourcesHTML,false);
	});
	
	// add automatic refresh
	if (parseInt(TB_config.widget_refresh_rate) > 0) {
		setInterval('TB_showLoader();TB_blend();',parseInt(TB_config.widget_refresh_rate) * 1000);
	}
}

function TB_blend() {
	// switch message from Initializing to Loading
	jQuery('#tb_loading').html('Loading...');
	
	// if not using cache/server then check limit for user viwing the page
	if (!TB_config.advanced_reroute_on) {
		jQuery.ajax({
			url: TB_config['rate_limit_url'],
			dataType: TB_config.data_type,
			success: function(json){
				// if can't get the limit or reached it
				if (json.ERROR || json.remaining_hits < TB_config.ajaxURLs.length) {
					
					// if cache is not disable, reroute traffic through server
					if (!TB_config.advanced_disable_cache) {
						TB_config['advanced_reroute_on'] = true;
						// regen URLs so they go to server
						TB_makeAjaxURLs();
						TB_config['data_type'] = 'json';
						TB_getTweets();
						
						// switch back to normal mode once limit has been reset
						var wait = parseInt(TB_config.widget_refresh_rate) * 1000 * 5,	// by default, try again in 5 x refresh rate
						now = new Date(),
						dateObj;
						// if we have actual reset time, use it
						if (json.reset_time) {
							dateObj = TB_str2date(json.reset_time);
							wait = Math.round(dateObj.getTime() - now.getTime());
						}
						setTimeout("TB_config.advanced_reroute_on=false;TB_config.data_type='jsonp';TB_makeAjaxURLs();TB_blend();",wait);
						//alert('switching back in ' + wait + ' microsec');
					}
					else if (TB_config.advanced_show_limit_msg) {
						TB_showMessage('limit','You reached Twitter API connection limit. Next reset ' + TB_verbalTime(TB_str2date(json.reset_time)), false);
					}
				}
				// else, get new feeds
				else {
					TB_getTweets();
				}
			},
			error: function(){
				TB_getTweets();
			}
		});
	}
	else {
		TB_getTweets();
	}
}

function TB_checkComplete() {
	if (TB_config.urlsDone == TB_config.ajaxURLs.length) {
		// if nothing added after we are through all sources let user know
		if(jQuery('#tweetlist').children('li').size() == 0) {
			TB_showMessage('notweets','No tweets found for ' + TB_config.sourcesHTML, true);
		}
		else {
			TB_hideMessage('notweets');
		}
	}
}
	
function TB_getTweets() {
	// iterate over AJAX URLs
	TB_config['urlsDone'] = 0;
	
	// switch message from Initializing to Loading
	jQuery('#tb_loading').html('Loading...');
	
	jQuery.each(TB_config.ajaxURLs,function(i,url) {
		TB_getFreshTweets(url);
	});
}

function TB_getFreshTweets(url) {
	jQuery.ajax({
		dataType: TB_config.data_type,
		url: url,
		success: function (json) {
			if (json.ERROR) {
				TB_config.urlsDone++;
				TB_checkComplete();
			}
			else {
				// if we got data from Twitter and caching not disabled then store data
				if (TB_config.data_type == 'jsonp' && !TB_config.disable_cache) {
					TB_cacheData(json);
				}
				TB_addTweets(json);
			}
		},
		error: function() {
			TB_config.urlsDone++;
			TB_checkComplete();
		}
	});
}

function TB_showFullUrl(shortUrlId,fullUrl) {

	if (fullUrl == '') return;
	if (jQuery('#tb_url_' + shortUrlId + 'e').length > 0) return;

	var linkEl = jQuery('#tb_url_' + shortUrlId);
	switch(TB_config.general_tiny_urls) {
		case "showicon":
			linkEl.after('<span><img class="urlexpand" src="' + TB_pluginPath + '/img/urlexpand-icon.png" alt="' + fullUrl + '"></span>');
			TB_addTooltip(linkEl.next());
			break;
		case "showhint":
			linkEl.attr('title',fullUrl);
			break;
		case "replace":	
			linkEl.html(fullUrl);
			break;
	}
	
	// mark it as expanded
	jQuery('#tb_url_' + shortUrlId).attr('id','tb_url_' + shortUrlId + 'e');
}

function TB_expandUrls() {

	// go through URLs list and see which ones need to be expanded
	while(shortUrl = TB_urlsToExpand.shift()) {
		jQuery.ajax({
			dataType: 'jsonp',
			url: 'http://urlexpand.com/json',
			data: {
				u:shortUrl,
				k:'853548444daf0029003a5211c313e924'
			},
			success: function (jsonData) {
				// if we have full url
				if (jsonData.e) {
					// find ID of the short url and expand it
					TB_expandedUrls[jsonData.u] = jsonData.e;
					TB_showFullUrl(TB_shortUrlIds[jsonData.u],jsonData.e);
				}
				else {
					return false;
				}
			},
			error: function() {
				return false;
			}
		});
	}
}

function TB_cacheData(jsonData) {
	
	// if it's an error - don't cache it
	if (jsonData.error) {
		return;
	}

	var source = "", dataAsJSON = "";
	//if it's a result of the search
	if (jsonData.query) {
		source = "search";
	}
	// else it's probably a single user's timeline
	else {
		// if there are no tweets in data - don't cache it
		if (typeof(jsonData[0]) == 'undefined') {
			return;
		}
		source = jsonData[0].user.screen_name;
	}
	
	if (typeof(jQuery.toJSON) != 'undefined') {
		dataAsJSON = jQuery.toJSON(jsonData);
	}
	else if (typeof(jQnc.toJSON) != 'undefined') {
		dataAsJSON = jQnc.toJSON(jsonData);
	}
	
	jQuery.ajax({
		url: 		TB_pluginPath + '/ws.php?action=cache_data',
		type:		'POST',
		dataType: 	'json',
		data: ({
			source: source,
			data: dataAsJSON
		})
	});
}

function TB_addTweets(jsonData) {

	// hide loader and show tweet list
	TB_showTweetList();

	var tweets = jsonData;
	if (typeof(jsonData.results) != 'undefined') {
		tweets = jsonData.results;
	}
	
	jQuery.each(tweets,function(i,tweet) {
		// if we don't show replies and this is a reply, skip it
		if (TB_config.filter_hide_replies && tweet.in_reply_to_user_id) {
			return true;
		}
		// if this tweet already in the set, skip it
		if (jQuery('#' + tweet.id).length > 0) {
			return true;
		}
		// if this is the first tweet, just add it and set it to be both min and max
		else if (TB_tweetsShown == 0) {
			TB_tweetsShown++;
			TB_minTweetID = tweet.id;
			TB_maxTweetID = tweet.id;			

			// add at the end
			jQuery('#tweetlist').append(TB_makeHTML(tweet));
		}
		// if tweet older than the oldest
		else if (TB_minTweetID > 0 && tweet.id < TB_minTweetID) {
			// if we are at max already, no need to work through the rest of this set as the rest will be older
			if (TB_tweetsShown >= TB_config[TB_mode+'_tweets_num']) {
				return false;
			}
			else {
				TB_tweetsShown++;

				// add at the end
				jQuery('#tweetlist').append(TB_makeHTML(tweet));

				// make it the oldest
				TB_minTweetID = tweet.id;
			}
		}
		// if tweet is newer than the newest
		else if (TB_maxTweetID > 0 && tweet.id > TB_maxTweetID) {
			// if we are at max already, remove bottom tweet
			TB_enforceLimit();
			
			// add in the beginning
			jQuery('#tweetlist').prepend(TB_makeHTML(tweet));
			TB_tweetsShown++;

			// make it the newest
			TB_maxTweetID = tweet.id;
		}
		// if tweet is in the middle
		else {
			// if we are at max already, remove bottom tweet
			TB_enforceLimit();

			// traverse currently shown tweets and insert in the appropriate spot
			var prevTweetID = TB_maxTweetID;
			jQuery('#tweetlist li').each(function(i,nextTweet){
				if (tweet.id < prevTweetID && tweet.id > nextTweet.id) {
					jQuery('#'+prevTweetID).after(TB_makeHTML(tweet));
					TB_tweetsShown++;
					return false;
				}
				prevTweetID = nextTweet.id;
			});
			
			// if got to here and tweet still not there, make it the last
			if (jQuery('#'+tweet.id).length <= 0) {
					jQuery('#'+TB_minTweetID).after(TB_makeHTML(tweet));
					TB_minTweetID = tweet.id;
					TB_tweetsShown++;
			}
		}
		
		// wire mouseover action items
        if(TB_config[TB_mode + '_show_reply_link'] || TB_config[TB_mode+'_show_follow_link']) {
			jQuery('#'+tweet.id).hover(
			      function () {
					jQuery(this).find("div:last").slideDown()
			      }, 
			      function () {
			        jQuery(this).find("div:last").slideUp();
			      }
			);
		}		
	});

	if (tweets.length > 0 && TB_mode != 'archive' && TB_config.archive_is_disabled == '') {
		jQuery('#archivelink').show();
	}
	
	TB_config.urlsDone++;
	TB_checkComplete();
	TB_expandUrls();
	TB_addTooltips();
}

function TB_enforceLimit() {
	if (TB_tweetsShown == TB_config[TB_mode+'_tweets_num']) {
		var lastTweet = jQuery('#' + TB_minTweetID),
		nextToLastTweet = lastTweet.prev('li');
		
		// remove last tweet
		lastTweet.remove();
		TB_tweetsShown--;
		
		// make next to last to be last now
		TB_minTweetID = parseInt(nextToLastTweet.attr('id'));
	}
}

function TB_makeHTML(tweet) {
		
	var tweetHTML = '',
	tweetDate,
	shortUrls;
	
	// add screen name if from_user is given
	if (typeof(tweet.user) == 'undefined') {
		if (tweet.from_user) {
			tweet.user = {
				screen_name: tweet.from_user
			};
		}
		else {
			tweet.user = {
				screen_name: ''
			};
		}
	}
	
	tweetHTML += '<li id="' + tweet.id + '">';
	
	// show photo if requested
	if (TB_config[TB_mode+'_show_photos']) {

		// add image url
		if (!tweet.user.profile_image_url && tweet.profile_image_url) {
			tweet.user.profile_image_url = tweet.profile_image_url;
		}

		tweetHTML += '<a class="tb_photo" href="http://twitter.com/' + tweet.user.screen_name + '" target="_blank">';
		tweetHTML += '<img src="' + tweet.user.profile_image_url + '" alt="' + tweet.user.screen_name + '"/>';
		tweetHTML += '</a>';
	}

	// show author
	tweetHTML += '<span class="tb_author"><a href="http://twitter.com/' + tweet.user.screen_name + '" target="_blank">' + tweet.user.screen_name + '</a>: </span> ';

	// if we are expanding URLs
	if (TB_config.general_tiny_urls != "keep") {
		
		if (shortUrls = tweet.text.match(/http\:\/\/[a-z0-9]+\.[a-z]+\/[a-z0-9]+/gi)) {
			jQuery.each(shortUrls,function(i,shortUrl) {
				shortUrl = jQuery.trim(shortUrl);
				
				// if we don't have expanded url already -> use it
				if (TB_expandedUrls[shortUrl]) {
					fullUrl = 	TB_expandedUrls[shortUrl];

					switch(TB_config.general_tiny_urls) {
						case "showicon":
							tweet.text = tweet.text.replace(shortUrl, '<a href="' + shortUrl + '" target="_blank">' + shortUrl + '</a><span><img class="expandicon" src="' + TB_pluginPath + '/img/urlexpand-icon.png" alt="' + fullUrl +'"></span>');
							break;
						case "showhint":
							tweet.text = tweet.text.replace(shortUrl, '<a href="' + shortUrl + '" target="_blank" title="[' + fullUrl + '] by URLexpand.com">' + shortUrl + '</a>');
							break;
						case "replace":	
							tweet.text = tweet.text.replace(shortUrl, '<a href="' + shortUrl + '" target="_blank">' + fullUrl + '</a>');
					}
				}
				// else tag it for future expansion
				else {
					TB_urlsToExpand.push(shortUrl);
					TB_shortUrlIds[shortUrl] = TB_urlCounter;
					tweet.text = tweet.text.replace(shortUrl, '<a id="tb_url_' + TB_urlCounter + '" href="' + shortUrl + '" target="_blank">' + shortUrl + '</a>');
					TB_urlCounter++;
				}

			});
		}
	}
	// if we are not expanding but still linking
	else if (TB_config.general_link_urls) {
		tweet.text = tweet.text.replace(/(https?:\/\/\S+)/gi, '<a href="$1" target="_blank">$1</a>');
	}

	// screen names
	if (TB_config.general_link_screen_names) {
		tweet.text = tweet.text.replace(/\@([^\s\.\:]+)/gi,'<a href="http://twitter.com/$1" target="_blank">@$1</a>'); 
	}
	if (TB_config.general_link_hash_tags) {
		tweet.text = tweet.text.replace(/\#([^\s\,]+)/gi,'<a href="http://search.twitter.com/search?q=%23$1" target="_blank">#$1</a>'); 
	}
	tweetHTML += '<span class="tb_msg">' + tweet.text + '</span><br/>';

	// start tweet footer with info
	tweetHTML += ' <span class="tb_tweetinfo">';
	
	// show timestamp
	tweetHTML += '<a href="http://twitter.com/' + tweet.user.screen_name + '/statuses/' + tweet.id + '">';
	tweetDate = TB_str2date(tweet.created_at);
	if (TB_config.general_timestamp_format) {
		if (typeof(jQuery.PHPDate) != 'undefined') {
			tweetHTML += jQuery.PHPDate(TB_config.general_timestamp_format,tweetDate);
		}
		else if (typeof(jQnc.PHPDate) != 'undefined') {
			tweetHTML += jQnc.PHPDate(TB_config.general_timestamp_format,tweetDate);
		}
	}
	else {
		tweetHTML += TB_verbalTime(tweetDate);		//jQuery.timeago(tweetDate);
	} 
	tweetHTML += '</a>';
	
	// show source if requested
	if (TB_config[TB_mode+'_show_source'] && tweet.source) {
		tweetHTML += ' from ';
		// if source is url encoded -> decode
		if (tweet.source.indexOf('&lt;') >= 0) {
			tweetHTML += jQuery('<textarea/>').html(tweet.source).val();
		}
		// else use as is
		else {
			tweetHTML += tweet.source;
		}
	}
	
	// end tweet footer
	tweetHTML += '</span>';
	
	// add tweet tools
	tweetHTML += '<div class="tweet-tools" style="display:none;">' +
				'<a href="http://twitter.com/home?status=@' + tweet.user.screen_name + '%20&in_reply_to_status_id=' + tweet.id + '&in_reply_to=' + tweet.user.screen_name + '" target="_blank">reply<a/>' + 
				' | <a href="http://twitter.com/' + tweet.user.screen_name + '" target="_blank">follow ' + tweet.user.screen_name + '</a>' +
				'</div>'; 
		
	// end tweet	
	tweetHTML += "</li>\n";

	return tweetHTML;
}

function TB_addTooltips() {
	jQuery('img.urlexpand').each(function(){
		TB_addTooltip(jQuery(this).parent());
	});
}

function TB_addTooltip(imgEl) {
	imgEl.simpletip({
		content: imgEl.contents().attr('alt'),
		fixed: true,
		position: ["-20","-16"]
	});
}

function TB_showLoader() {
	jQuery('#refreshlink img').attr('src',TB_pluginPath + '/img/ajax-refresh.gif');
	jQuery('#refreshlink').addClass('loading');
}

function TB_hideLoader() {
	jQuery('#tb_loading').hide();
	jQuery('#refreshlink img').attr('src',TB_pluginPath + '/img/ajax-refresh-icon.gif');
	jQuery('#refreshlink').removeClass('loading');
}

function TB_showTweetList() {
	TB_hideLoader();
	jQuery('#tweetlist').show();
}

function TB_showMessage(id, msg, keepOnScreen){
	TB_hideLoader();
	// if it doesn't exist
	if (!jQuery('#msg_' + id).length) {
		jQuery('#tweetlist').before('<div id="msg_' + id + '" class="tb_msg" style="display:none;">' + msg + '</div>');
		jQuery('#msg_' + id).slideDown();
		if (!keepOnScreen) {
			setTimeout('TB_hideMessage("' + id + '")', 8000);
		}
	}
	// else if it's hidden
	else if (jQuery('#msg_' + id).is(':hidden')) {
		jQuery('#msg_' + id).slideDown();
	}
}

function TB_hideAllMessages() {
	jQuery('div.tb_msg').slideUp(1000,function(){jQuery('div.tb_msg').remove()});
}

function TB_hideMessage(id) {
	jQuery('#msg_' + id).slideUp(1000,function(){jQuery('#msg_' + id).remove()});
}

// search: Wed, 27 May 2009 15:52:40 +0000
// user feed: Thu May 21 00:09:16 +0000 2009
function TB_str2date(dateString) {
	
	var dateObj = new Date(),
	dateData = dateString.split(/[\s\:]/);
	
	// if it's a search format
	if (dateString.indexOf(',') >= 0) {
		// $wday,$mday, $mon, $year, $hour,$min,$sec,$offset
		dateObj.setUTCFullYear(dateData[3],TB_monthNumber[""+dateData[2]]-1,dateData[1]);
		dateObj.setUTCHours(dateData[4],dateData[5],dateData[6]);
	}
	// if it's a user feed format
	else {
		// $wday,$mon,$mday,$hour,$min,$sec,$offset,$year
		dateObj.setUTCFullYear(dateData[7],TB_monthNumber[""+dateData[1]]-1,dateData[2]);
		dateObj.setUTCHours(dateData[3],dateData[4],dateData[5]);
	}

	return dateObj;
}

function TB_verbalTime(dateObj) {
   
    var j,
	now = new Date(),
	difference,
	verbalTime,
	prefix = '',
	postfix = '';
	
	if (now.getTime() > dateObj.getTime()) {
		difference = Math.round((now.getTime() - dateObj.getTime()) / 1000);
		postfix = ' ago';
	}
	else {
		difference = Math.round((dateObj.getTime() - now.getTime()) / 1000);
		prefix = 'in ';
	}
		
   
    for(j = 0; difference >= TB_timePeriodLengths[j] && j < TB_timePeriodLengths.length; j++) {
        difference = difference / TB_timePeriodLengths[j];
    }
    difference = Math.round(difference);
   
    verbalTime = TB_timePeriods[j];
    if (difference != 1) {
        verbalTime += 's';
    }
   
    return prefix + difference + ' ' + verbalTime + postfix;
}

jQuery(document).ready(function() {
	TB_init();
});

// backup firing of init in 4 seconds
TB_tmp = setTimeout('TB_init()',4000);
