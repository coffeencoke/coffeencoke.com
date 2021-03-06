---
layout: post
title: Rails 3 Finally
tags:
- programming
- ruby
- ruby on rails
status: publish
type: post
published: true
meta:
  jabber_published: '1278566226'
  _edit_last: '3545253'
  _wp_old_slug: ''
---
<p>To setup a new rails 3 app with cucumber, no prototype and mysql database using ruby 1.9.2</p>
<p>This guide assumes you have ruby 1.9.2, rubygems and bundler gem installed</p>
<pre>[msimpson@dakota ~] $ mkdir rails3
[msimpson@dakota ~] $ cd rails3
[msimpson@dakota rails3] $ git clone git://github.com/rails/rails.git rails3 .
[msimpson@dakota rails3] (master) $ ruby bin/rails new /path/to/my/new/app --dev -d mysql -J
[msimpson@dakota rails3] $ cd /path/to/my/new/app</pre>
</pre>
<p>Open and edit Gemfile so that it looks like this:</p>
<pre>source 'http://rubygems.org'

gem 'rails', :path =&gt; '/Users/mattsimpson/Projects/_resources/Code/Rails3'
gem 'arel',  :git =&gt; 'git://github.com/rails/arel.git'
gem 'mysql'

group :cucumber do
  gem 'cucumber-rails'
  gem 'cucumber'
  gem 'factory_girl'
  gem 'webrat'
  gem 'ruby-debug19'
end</pre>
<p>Install your gems</p>
<pre>[msimpson@dakota rails3] $ bundle install</pre>
<p>Install Cucumber with webrat and test unit</p>
<pre>[msimpson@dakota rails3] $ rails generate cucumber:install --webrat --testunit</pre>
<p>Open and edit config/database.yml and create your database by running the following:</p>
<pre>[msimpson@dakota app] $ rake db:create:all</pre>
<p>You are good to go!</p>
<br />
<br />
<p>Originally I was having troubles with rake test and rake cucumber, but after recreating my rails app this way it all worked great.  Hope it works for you.</p>
