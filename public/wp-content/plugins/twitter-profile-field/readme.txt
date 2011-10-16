=== Twitter Profile Field ===
Contributors: Jayjdk
Donate link: None
Tags: twitter, profile, field, username, user
Requires at least: 2.8
Tested up to: 2.9-rare
Stable tag: 1.1

Adds an additional field to the user profile page where they can enter their Twitter username.

== Description ==

Twitter Profile Field is a simple WordPress plugin there gives you a new box in your profile admin to add in your Twitter username. 
It does also include a shortcode to allow you to display your Twitter username in posts, pages and text widgets. 


== Installation ==

Installation Instructions:

1. Download the plugin and unzip it.
2. Put the twitter-field folder into the <code>wp-content/plugins/</code> directory.
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' next to Twitter Profile Field.
5. Go to your Profile page and at the bottom of the page is a new input field called Twitter username. Add your username in there.
6. If you want to add the function to your theme file(s) then use

<code><?php the_author_meta('twitter'); ?></code> if it's INSIDE the loop or use
<code><?php the_author_meta('twitter',1); ?></code> if it's OUTSIDE the loop. 1 is the User ID

7. If you want the username to be showed in posts, pages or text widgets then use
<code>[twitter-user]</code> It will display the username without any markup
<code>[twitter-user link="yes"]</code> will display the username with a link and the class <code>twitter-profile</code> (<code><a href="http://twitter.com/username" 

class="twitter-profile">Username</a></code>)


== Frequently Asked Questions ==

= It don't work - What should I do? =

First of all, make sure that the plugin is activated. If you add the to your theme file(s) when make sure that you use <code><?php the_author_meta('twitter',1); ?></code> if 

it's OUTSIDE the loop.

== Screenshots ==

1. The Profile page
2. How to use shortcodes in posts, pages and text widgets

== Changelog ==
= 1.0 =
* Initial Release
= 1.1 =
* Adds a Dashboard widget

== Support ==

Support is provided at http://jayj.dk/forum/viewtopic.php?t=143