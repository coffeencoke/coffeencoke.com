---
layout: post
title: Remove All Your Ruby Gems
tags:
- cleaning
- gems
- OCD
- programming
- rails
- ruby
- ruby on rails
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
  delicious: s:78:"a:3:{s:5:"count";s:1:"0";s:9:"post_tags";s:0:"";s:4:"time";s:10:"1273865287";}";
  reddit: s:55:"a:2:{s:5:"count";s:1:"0";s:4:"time";s:10:"1273865288";}";
---
<div id="_mcePaste">When it gets to a point to wipe out all of your gems just because you feel cluttered and you want to start fresh, this is what I did.</div>
<div id="_mcePaste">I had over 60 megabytes of gems and it was driving me kinda crazy because of my CDO.  So I wanted to remove all my gems and start fresh.</div>
<div id="_mcePaste"></div>
<pre>[msimpson@dakota test] $ sudo gem uninstall --all --ignore-dependencies `sudo gem list --no-versions`</pre>
<div id="_mcePaste"></div>
<div id="_mcePaste">Press return whenever prompted and you'll end up nothing :)  ahhhh feels nice.</div>
