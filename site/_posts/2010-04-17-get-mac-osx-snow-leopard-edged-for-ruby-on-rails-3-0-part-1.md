---
layout: post
title: Get Mac OSX Snow Leopard edged for Ruby on Rails 3.0 - part 1
tags:
- cleaning
- go faster
- install
- mac os x
- programming
- rails
- ruby
- ruby on rails
- upgrade
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
  delicious: s:78:"a:3:{s:5:"count";s:1:"1";s:9:"post_tags";s:0:"";s:4:"time";s:10:"1273865288";}";
  reddit: s:55:"a:2:{s:5:"count";s:1:"0";s:4:"time";s:10:"1273865288";}";
---
First, why should you want to upgrade?
<blockquote>Ruby 1.9 is a new series of Ruby. It is modern, faster, with clearer syntax, multilingualized, a much improved version of Ruby.</blockquote>
<ol>
	<li>1.8 has been used since 2003, I think it's time for a new version</li>
	<li>Ruby 1.9 is is <a href="http://antoniocangiano.com/2007/12/03/the-great-ruby-shootout/" target="_blank">over 3 times faster</a> than ruby 1.8.6 see it for yourself</li>
	<li>New methods</li>
	<li>Better syntax</li>
	<li>New classes</li>
</ol>
* read this <a href="http://eigenclass.org/hiki/Changes+in+Ruby+1.9" target="_blank">great read up</a> on ruby 1.9
<h2>Install ruby 1.9.1 fresh</h2>
<address>(to upgrade skip this and see below)</address>
<h3>Download</h3>
<pre>[msimpson@dakota ~] $ mkdir src
[msimpson@dakota src] $ cd src
[msimpson@dakota src] $ curl -Ov ftp://ftp.ruby-lang.org/pub/ruby/1.9/ruby-1.9.1-p376.tar.gz
[msimpson@dakota src] $ curl -Ov http://files.rubyforge.vm.bytemark.co.uk/rubygems/rubygems-1.3.6.tgz</pre>
<h3>Unpack, Make and Install Ruby</h3>
<pre>[msimpson@dakota src] $ tar -xzvf ruby-1.9.1-p376.tar.gz
[msimpson@dakota src] $ cd ruby-1.9.1-p376
[msimpson@dakota src] $ autoconf
[msimpson@dakota src] $ ./configure --enable-shared --enable-pthread CFLAGS=-D_XOPEN_SOURCE=1 &amp;&amp; make &amp;&amp; sudo make install
[msimpson@dakota src] $ cd ..</pre>
<h3>Unpack and Install Rubygems</h3>
<pre>[msimpson@dakota src] $ tar xzvf rubygems-1.3.6.tgz
[msimpson@dakota src] $ cd rubygems-1.3.6
[msimpson@dakota src] $ sudo /usr/local/bin/ruby setup.rb
[msimpson@dakota src] $ cd ..</pre>
<h2>Or to upgrade</h2>
<h3>Download</h3>
I use the rvm gem, it freaking rocks!  It manages the versions of ruby to use.
<pre>gem install rvm
rvm-install</pre>
Follow the instructions at the end of the last command then close and open a new terminal.
<h3>Install ruby 1.9.1 and use it</h3>
<pre>[msimpson@dakota ~] $ rvm install ruby-1.9.1-p378
[msimpson@dakota ~] $ rvm use 1.9.1</pre>
<h3>Check to see that it is installed</h3>
<pre>[msimpson@dakota ~] $ ruby -v
ruby 1.9.1p378 (2010-01-10 revision 26273) [i386-darwin10.3.0]</pre>
*check out the website for rvm to see what kinds of ruby you can install (ie jruby, 1.9.2, etc.)

if all goes wrong down the road you can always switch to default
<pre>[msimpson@dakota ~] $ rvm use default</pre>
<h2>Play Around</h2>
Now that you have ruby 1.9 installed you can use some pretty rad new methods.

one of my favorites is Hash#each_with_index:
<pre>[msimpson@dakota ~] $ rvm use 1.9.1
[msimpson@dakota ~] $ irb
ruby-1.9.1-p378 &gt; hash = {:name =&gt; 'matt', :verb =&gt; "loves", :noun =&gt; "ruby 1.9" }
 =&gt; {:name=&gt;"matt", :verb=&gt;"loves", :noun=&gt;"ruby 1.9"}
ruby-1.9.1-p378 &gt; hash.each_with_index{|value, index| print "index: #{index}, key: #{value[0]}, value: #{value[1]}\n" }
index: 0, key: name, value: matt
index: 1, key: verb, value: loves
index: 2, key: noun, value: ruby 1.9
 =&gt; {:name=&gt;"matt", :verb=&gt;"loves", :noun=&gt;"ruby 1.9"}</pre>
