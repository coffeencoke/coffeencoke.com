---
layout: post
title: Rails 3 update
tags:
- install
- programming
- ruby
- ruby on rails
- rvm
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
---
<div id="_mcePaste">Took me a few tweeks to get rails 3 working on my mac.  Recently I've made some posts to get your setup ready for Rails 3 but have just recently, with the tweeks I'm going to share here, now got rails 3 working with mysql.</div>
I've had to revert from ruby 1.9.2-preview to ruby 1.9.1 p378.
<pre>[msimpson@dakota Code] (master) $ rvm install 1.9.1
[msimpson@dakota Code] (master) $ rvm use 1.9.1
<span style="font-family:Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;line-height:19px;white-space:normal;font-size:13px;">Install rails 3 with the new ruby install</span>
[msimpson@dakota Code] (master) $ sudo gem install rails --prerelease</pre>
Create a new rails app using mysql
<pre><span style="font-family:Consolas, Monaco, 'Courier New', Courier, monospace;line-height:18px;font-size:12px;white-space:pre;">[msimpson@dakota Code] (master) $ </span>rails myapp --edge -d mysql</pre>
Now you will be able to create your db and start your app
<pre style="font:normal normal normal 12px/18px Consolas, Monaco, 'Courier New', Courier, monospace;">[msimpson@dakota Code] (master) $ rake db:create:all
[msimpson@dakota Code] (master) $ rails server</pre>
<pre style="font:normal normal normal 12px/18px Consolas, Monaco, 'Courier New', Courier, monospace;"></pre>
<pre style="font:normal normal normal 12px/18px Consolas, Monaco, 'Courier New', Courier, monospace;">Yay!!  Rails 3, here we go!</pre>
