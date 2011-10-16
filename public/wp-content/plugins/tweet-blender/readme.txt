=== Tweet Blender ===
Contributors: kirilln
Tags: sidebar, twitter, tweets, multiple authors, hashtags, archive, widget, admin, AJAX, jquery, keywords
Requires at least: 2.0.2
Tested up to: 2.8.5
Stable tag: 2.3.0
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5907095

Shows your tweets in a sidebar widget. Can combine them with tweets from other authors, tweets for hashtags, and tweets for keywords and blend all of that into a single stream. Automatically adds a tweet archive page.

== Description ==

Similar in functionality to Twitter's own widget but has support for multiple authors, hashtags, and keywords all blended together. The plugin can show tweets from just one user (as all other Twitter plugins do); however, it can also show tweets for a topic which you can define via Twitter hashtag or keyword. But there is more! It can also show tweets for multiple authors AND multiple keywords AND multiple hashtags all blended together into a single stream.

Follow [TweetBlender on Twitter](http://twitter.com/tweetblender "@tweetblender")  to keep up to date on bug fixes and releases and join the conversation using [#tweetblender](http://search.twitter.com/search?q=%23tweetblender "#tweetblender") hashtag

= Features =
* Shows tweets from one or more Twitter users (e.g. [@tweetblender](http://twitter.com/tweetblender "@tweetblender"))
* Shows tweets for one or more topic defined by keywords (e.g. ['wordpress'](http://search.twitter.com/search?q=wordpress "wordpress Twitter search"))
* Shows tweets for one or more topic defined by Twitter hashtag (e.g. [#wordpress](http://search.twitter.com/search?q=%23wordpress "#wordpress Twitter hashtag search"))
* Shows tweets for multiple users, multiple topics, and multiple hashtags blended together into single stream
* Allows to turn display of user's photo ON/OFF. Photos can be OFF in the sidebar to conserve screen space and ON on the archive page.
* Allows to replace @screennames in tweets with links to user accounts (open in new window)
* Allows to replace #hastags in tweets with links to Twitter search results for that hashtag (open in new window)
* Allows to replace URLs in tweets with links to those URLs (open in new window) 
* Automatically creates a page with archive (a longer, expanded list of tweets). Can be disabled if you want to create archive manually or don't need an archive.
* Allows to override automatic archive page with a custom archive page
* Allows to specify number of tweets to show in the sidebar widget
* Allows to specify number of tweets to show on the archive page
* Provides template tag `<?php tb_widget(); ?>` to include widget on any page
* Provides template tag `<?php tb_archive(); ?>` to include archive on any page
* Provides "refresh" icon that allows users to manually refresh tweet list
* Allows to specify refresh period which turns ON automatic refresh of the tweet list
* Checks screennames, keywords, and hashtags for validity prior to saving which ensures that no protected users were specified
* Displays "reply" and "follow" links for each tweet that appear when user places mouse over the tweet area.
* Allows to create individual twitter streams for different authors by overriding sources in tb_archive() tag (e.g. `<?php tb_archive('@knovitchenko'); ?>`)
* Provides basic caching mechanism to store Twitter data and work around Twitter API's connection limit
* Allows to reroute all Twitter API requests via blog's web server to take advantage of white-listed server
* Allows to filter tweets by language (for hashtags and keyword sources only)
* NEW: allows to expand shortened URL and show them to users when mouse is over a link or special icon (in Beta). Uses [URLexpand.com](http://urlexpand.com "http://urlexpand.com").

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the entire tweet-blender directory to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use admin Settings > Tweet Blender to specify sources and other configuration options
4. Use admin Appearance > Widgets page to drop the widget in the appropriate spot on your sidebar. The archive page will be created for you automatically the first time widget is shown on the site.

= Custom Setup =
If you don't want to place the widget in the sidebar or don't want to use the automatically-created archive page you can use template tags to include Tweet Blender in your pages like this:

1. Follow steps 1-2 above to install and activate the plugin
2. Go to Settings > Tweet Blender and enter the URL of your custom archive page (e.g. 'http://your-site.com/some-custom-page-name')
3. Edit that custom page and include `<?php tb_archive(); ?>` in its HTML. Note that to make PHP work in page content you might need to add another plugin such as [PHP Execution plugin](http://wordpress.org/extend/plugins/php-execution-plugin/ "PHP Execution plugin")
4. Eidt the page where you want to include the widget and put `<?php tb_widget(); ?>` in its HTML. 

== Screenshots ==

1. Sidebar widget with tweets from several authors and hashtags. You can turn off display of pictures to conserve screen space. You can also see URLexpand.com integration that shows a small icon next to shortened URL and displays the full URL it points to when users places cursor over that icon.
2. Tweets archive page. Created automatically but you can edit title, tags, and text of the page using regular admin features
3. Admin: widgets page that shows Tweet Blender dropped into Sidebar North area and it's control options exposed.
4. Admin: general settings for the plugin. Sources can include screen names and/or hashtags. No limit on how many.
5. Admin: widget settings for the plugin
6. Admin: archive page settings
7. Admin: filtering options
8. Admin: advanced settings

== Getting Help ==

My goal is to make sure that TweetBlender works on *your* site. 

If you experience a problem please don't simply disable and delete the plugin; instead, do let me know about your issue! You'd be helping me make TweetBlender better, you'd be helping other users who could be experiencing the same issue, and you'd get a kick-ass plugin working for you as a result.

When reporting an issue please state the following things in your initial message:
1. The URL of the page where the issue can be seen
2. The version of TweetBlender you are using
3. The version of WordPress you are using
4. Your browser type and version
5. Your OS type and version
If you don't tell me these things right away I usually have to write back and ask for them and that delays the fix.

Here are the places I monitor regularly:

* Twitter: hashtag #tweetblender, mentions of @tweetblender, keywords "tweetblender" and "tweet blender" - This is the best way if your request is fairly urgent as I'm online 16 hours a day
* Facebook: [TweetBlender fan page](http://www.facebook.com/pages/Tweet-Blender/96201618006 "Facebook Fan Page") discussion board
* WordPress Support Forums: [tweet-blender tag](http://wordpress.org/tags/tweet-blender?forum_id=10 "WP forum")
* Old homepage: [http://kirill-novitchenko.com/tweet-blender](http://kirill-novitchenko.com/tweet-blender "old homepage")

Additional resources:

* New Homepage: (coming soon) [http://tweet-blender.com](http://tweet-blender.com "TweetBlender home page")
* Email: tweetblender AT gmail DOT com

*Note #1: I might not get back to you immediately.* This software is written and supported by an individual, not a company or a group. I have a demanding full time job and family with two kids. All of my free time is spent on fun projects like this one.

*Note #2: Please don't flame me for bugs.* Twitter is notoriously unstable and has some bugs in the API. On top of it, I use jQuery library that has some bugs in it as well. On top of it you might have other plugins installed that have bugs or introduce conflicts. Finally, 90% of the code works within browsers which have all sorts of different bugs of their own. Before calling TweetBlender "crap" give it a benefit of a doubt - it might not be its problem. I'm really striving to make it the best it could be

== Changelog ==

= 2.3.0 =
* New feature: option to preview/unshorten tiny urls in tweets. Full url can be shown only when you mouseover a link or it can replace the tiny url right in the text. Uses [URLexpand.com](http://urlexpand.com "http://urlexpand.com"). This is in beta. (thanks to Rick Sapir for suggesting via Facebook)
* Bug fix: no tweets showing when using custom date/time format and have other jQuery-based plugins on the site
* Bug fix: javascript error if your sources start with a number e.g. `5thround` (thanks to Tim Ngo for reporting via email)
* Bug fix: message `Warning: Invalid argument supplied for foreach() in wp-content/plugins/tweet-blender/tweet-blender.php on line 60` appears if you try to view the widget on the site before saving settings in the admin (thanks to Tamar Weinberg for reporting via Facebook)
* Bug fix: first tweet in the list is shifted to the right due to CSS conflicts (thanks to The Lucky Ladybug for reporting via email)
* Bug fix: cache failure since cached data had extra slashes in it (thanks to Zoli Erdos for reporting via Facebook)
* Improved logic for loading of javascript libraries. If you disable caching, toJSON plugin is not loaded (savings of 4Kb). If you don't use custom date format, PHPDate plugin is not loaded (savings of 4Kb)

= 2.2.3 =
* Tested with WordPress 2.8.5
* Added "Get Help!" tab to WP plugin info page
* Workaround: getting stuck on "Loading..." message due to javascript error `$.toJSON is undefined` caused by comment-validator plugin (thanks to The Lucky Ladybug for reporting via wordpress forums)
* New feature: better organized tabbed admin panel and updated admin screenshots
* New feature: attempt to create cache directory automatically to ensure it is writable
* New feature: ability to filter out tweets that are replies to other tweets (thanks to John Cappiello for contributing)

= 2.2.2 =
* Bug fix: not showing tweets for hashtags if all of them are longer than 140 character Twitter search query limit (thanks to Kensai for reporting via Facebook)
* Bug fix: not using `before_title` and `after_title` (thanks to x3r0ss and iamtakashiirie for reporting via blog)
* New feature: ability to supply custom title to the widget section of the sidebar. Every other widget asks for title, now TweetBlender does too
* Bug fix: outputting `before_widget` and `after_widget` to the sidebar of the archive page
* Bug fix: Message: `‘TB_config.filter_lang.length’ is null or not an object` (thanks to Greg for reporting via blog)
* Bug fix: erratic behavior with cache feature - cache not being saved
* Bug fix: CSS issue with tweets shifted to the bottom of in a narrow sidebar (thanks to wjwestfall for reporting via blog)

= 2.2.1 =
* Bug fix: reply and follow links were showing up even if they were turned OFF in settings (thanks to x3r0ss for reporting via blog)
* Bug fix: not able to save screenname sources in some cases while hashtags/keywords worked OK (thanks to Chad B for reporting via Facebook)
* Bug fix: getting stuck at "Initializing..." message due to javascript error "TB_pluginPath is not defined" caused by config options being inserted into page after the main plugin code loads instead of before. (thanks to David S P for reporting via Facebook)
* Bug fix: getting stuck at "Loading..." message due to javascript error "a[0] is undefined" caused by plugin trying to cache Twitter responses with error messages and no data. (thanks to Walther for reporting via blog)
* Bug fix: "c.user is undefined" javascript error that came up when connection limits were reached


= 2.2.0 =
* New feature: caching of Twitter data. Enabled by default but can be turned ON/OFF
* New feature: ability to reroute all Twitter API requests via blog's web server. To be used for white-listed servers only
* New feature: ability to turn ON/OFF the message about connection limits
* New feature: ability to filter tweets by language (for hashtags and keyword sources only)
* Bug fix: multiple clicks on Twitter logo showed multiple info messages
* Bug fix: Warning: array_key_exists() [function.array-key-exists]: The second argument should be either an array or an object in "/xxx/xxx/wp-content/plugins/tweet-blender/tweet-blender.php on line 271"
* Bug fix: message that no tweets were found did not disappear after tweets were finally found.

= 2.1.1 =
* Fixed error 'Cannot instantiate non-existent class: services_json in /home/xxxx/public_html/wp-content/plugins/tweet-blender/admin-page.php on line 37'
* Fixed bug where '@' are continually added to sources
* Fixed bug that showed one less tweet in the widget (and JavaScript error 'c.user is undefined') if you had only screen names as sources

= 2.1.0 =
* Improved performance. It's now about 60% faster!
* Added ability to specify regular keywords in addition to screen names and hashtags. More things to blend!
* Added automatic refresh feature - admin can choose refresh rate in the settings panel or in the widget configuration menu
* Added ability to specify custom URL for archive page
* Fixed bug in archive page tag that used widget's number of tweets setting instead of archive's number of tweets setting
* Fixed bug in "View All" link not pointing to automatically-created archive page. Renamed link to "view more"
* Added display of "reply" and "follow" links when user places mouse over tweet
* Added new feature that validates sources prior to saving them so that misspelled/protected screen names are not accepted (and annoying login pop-up wouldn't appear for users as a result)
* Greatly improved efficiency and speed by grouping hashtags together into single API calls
* Removed caching functionality (store/get) until next feature release as it creates too much traffic and needs careful planning/thinking through
* Removed extra AJAX request for configuration
* Fixed bug with bullets appearing for each tweet in some themes
* Added ability to over-ride sources when using tb_archive template tag - now each profile can show tweets for one user and an index page can show a regular blend from all users.
* Added better handling of connection limit - shows when it will be reset in verbal time e.g. "next reset in 12 minutes"
* Added ability to disable the archive page (note: you'll need to manually delete existing one to remove it from navigation)

= 2.0.5 =
* Created work around for widget not starting if other plugins have JavaScript errors (e.g. Flickr Manager plugin)
* Added new template tag tb_archive() that allows to manually create an archive tweet list on any page
* Fixed issue with tweet source not appearing after "from" if tweet source has un-encoded HTML in it (e.g. TweetDeck link)
* Adjusted CSS so that tweets are not shifted to the right if your theme overrides padding for list items
* Fixed "NaN years ago" error in timestamp that appeared in Internet Explorer 6, 7 and 8
* Fixed problem with archive page not being created or linked to
* Replaced jquery.timeago library with own code and reduced page load by 3Kb
* Tested and ensured compatibility with WordPress 2.8.1

= 2.0.4 =
* Fixed "Warning: Missing argument 1 for tb_widget()" error when trying to include plugin using template code instead of widget tool in the admin

= 2.0.3 =
* Fixed "Cannot retrieve Tweet Blender configuration options" error thrown on some servers

= 2.0.2 =
* Added message that's shown if sources are valid but have no tweets
* Fixed bug in links for hashtags in sources screen (shown if you click on Twitter logo)
* Added this Changelog to plugin page on WordPress
* Added feature to disable refresh button if configuration has not been loaded

= 2.0.1 =
* Fixed CSS so no border is shown around refresh icon - it appeared on some sites before
* Updated installation instructions to clarify where sources are defined

= 2.0.0 =
* Complete overhaul of the widget shifting blending functionality from PHP to JavaScript
* Added web services for configuration and cache management
* Added refresh icon for manual refresh
* Simplified CSS
* Improved loading time and decoupled widget from the rest of the page so it doesn't hold up loading
* Fixed checking for connection limit and fixed "Tweets temporary unavailable" error
* Switched to different configuration management technique
* Added Tweet Blender logo to admin page