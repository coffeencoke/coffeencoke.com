---
layout: post
title: Hotspots not working... Figured it out!
tags:
- hotspots
- internet
- macbook pro
- peer guardian
- troubleshooting
- wifi
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
---
<strong><em><a href="http://coffeencoke.com/wp-content/uploads/2009/06/wifi_yuck.png"><img class="alignleft size-full wp-image-15" style="border:0 none;margin:5px;" title="wifi_yuck" src="http://coffeencoke.com/wp-content/uploads/2009/06/wifi_yuck.png" alt="wifi_yuck" width="295" height="280" /></a>If you want to know how, just skip to the bottom :)</em></strong>

So I have been having issues where my <strong>macbook pro</strong> running Mac OSX 10.5 <strong>would not connect to hotspots</strong> at coffee shops, hotels and the like!  Very frustrating because <strong>it used to work</strong> and I could not figure out why it wouldn't work all of the sudden.  <strong>I could connect to the router</strong> and I received an IP Address but when I opened Firefox or Safari the landing page for that hotspot, you know: the page where you either enter a hotspot login or just click go, well, it never loaded.  It would time out :(

I am at a hotel in Penn State hoping to do some blogging and searching and a little research / unplugagoogling and really wanted to get this internet thing to work.  Luckily I had my iPhone and could browse with the 3G network and I had the patience (rare in times of needing internet).  So I browsed on my iphone while applied changes to my macbook pro.

The odd thing was that I could send / receive emails, login to my chat clients, load my dashboard data. <strong> I could ping but not browse</strong> in firefox or safari.  Yuck!

Looking at the logs in console didn't help, I removed my Cisco VPN Client because I read a few things about that client installing a kernal module that breaks that functionality, I opened up my firewall and all of this did not solve the issue.
<h2>Solution</h2>
Finally, I realized I installed <strong>Peer Guardian</strong>, which is a great application, but it was blocking all access for that landing page (I could see it blocking from the peer guardian log output).  So <strong>I disabled the Peer Guardian filters</strong> and refreshed google and vualah! <strong>it worked</strong> :)... now to figure out how to add this situation to the allow / exception list, a task for another day.

This may not be the solution for you, if it didn't work then hopefully it's at the very least some direction to get you moving toward the solution.
