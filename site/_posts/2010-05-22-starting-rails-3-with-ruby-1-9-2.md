---
layout: post
title: Starting Rails 3 with Ruby 1.9.2
tags:
- gems
- install
- rails
- ruby
- ruby on rails
- rvm
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
---
<div id="_mcePaste">First things first, if you are going to run rails 3 you may as well us ruby 1.9.x.  The problem however is that rails 3 currently does not work well with ruby 1.9.1 so you must first install and use ruby 1.9.2.</div>
<div id="_mcePaste">I'm installing ruby 1.9.2 using RVM, ruby version manager.  You can read up on how to use this from me <a href="/2010/04/17/get-mac-osx-snow-leopard-edged-for-ruby-on-rails-3-0-part-1/" target="_blank">earlier blog post</a></div>
<pre>[msimpson@dakota Code] (master) $ rvm install 1.9.2
[msimpson@dakota Code] (master) $ rvm use 1.9.2</pre>
<div id="_mcePaste">now if you go into irb you will see that you are using ruby 1.9.2 and you can use the new cool methods.</div>
<pre>[msimpson@dakota Code] (master) $ irb
&gt; RUBY_VERSION
=&gt; "1.9.2"
&gt; hash = { :first =&gt; "the first value", :second =&gt; "the second value" }
=&gt; {:second=&gt;"the second value", :first=&gt;"the first value"}
&gt; hash.each_with_index.collect{|array, index| "key: #{array[0]} | value: #{array[1]} | index: #{index}"}
=&gt; ["key: second | value: the second value | index: 0", "key: first | value: the first value | index: 1"]</pre>
<div id="_mcePaste">Install Rails 3</div>
<pre>[msimpson@dakota Code] (master) $ sudo gem install rails --prerelease</pre>
<div id="_mcePaste">Create a new rails 3 app strait from the rails 3 git repository so that you can always pull new updates as bugs get fixed</div>
<pre>[msimpson@dakota Code] (master) $ rails . --edge</pre>
<div id="_mcePaste">Obviously, you can specify the rails app name, but I was already in the directory I wanted to be in so I used .</div>
<div id="_mcePaste"></div>
<div>Now you are good to go!  Have fun and report any bugs you find with Rails 3, or fork it and fix it so you can contribute.</div>
