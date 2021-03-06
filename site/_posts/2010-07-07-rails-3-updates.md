---
layout: post
title: Rails 3 Updates
tags:
- gems
- programming
- ruby
- ruby on rails
- rvm
- troubleshooting
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
  jabber_published: '1278478841'
  _wp_old_slug: ''
---
In this I will explore and solve issues I had in upgrading rails 3 to the latest rails 3 version.

Following the rails 3 update saga continues.  After taking a break to make some leaps in the design process on an application, I came back to programming the app.  After writing some cucumber tests I received a series of deprecated messages.  One thing I would like to note is that rails 3 is very good at letting you know what is going on and what you need to do.  Let's get started:

My gemfile for cucumber looks like this:
<pre>group :cucumber do
  gem 'capybara'
  gem 'database_cleaner'
  gem 'cucumber-rails'
  gem 'cucumber'
  gem 'spork'
  gem 'launchy'    # So you can do Then show me the page
  gem 'factory_girl'
  gem 'webrat'
end</pre>
When I tried to run my cucumber test I got this message:  "undefined method `config' for nil:NilClass (NoMethodError)"

So I updated my gems via bundle:
<pre>
<pre>[msimpson@dakota Code] $ bundle install</pre>
</pre>
and I got the message:
<pre>No compatible versions could be found for required dependencies:
Conflict on: "bundler":
* bundler (0.9.25) activated by bundler (= 0.9.25, runtime)
* bundler (&gt;= 1.0.0.beta.2, runtime) required by rails (&gt;= 0, runtime)
All possible versions of origin requirements conflict.</pre>
so I installed the new bundler
<pre>[msimpson@dakota Code] $ sudo gem install bundler -v 1.0.0.beta.2</pre>
reran the cucumbers and got this:
<pre>
<pre>    Rails 3 doesn't officially support Ruby 1.9.1 since recent stable
    releases have segfaulted the test suite. Please upgrade to Ruby 1.9.2
    before Rails 3 is released!
    You're running
      ruby 1.9.1p378 (2010-01-10 revision 26273) [i386-darwin10.3.0]</pre>
so I noticed I needed to install the new ruby 1.9.2 release candidate.  Since I use rvm I had to update rvm, remove my old ruby 1.9.2, re-install it and reinstall bundler:
<pre>[msimpson@dakota Code] $rvm update
[msimpson@dakota Code] $rvm reload
[msimpson@dakota Code] $rvm remove 1.9.2
[msimpson@dakota Code] $rvm install 1.9.2
[msimpson@dakota Code] $rvm use 1.9.2
[msimpson@dakota Code] $sudo gem install bundler -v 1.0.0.beta.2
[msimpson@dakota Code] $ bundle install</pre>
I didn't get all the way through but I'm pretty sure I got closer ;), currently I'm working on getting cucumber to install and run.  Hope this helps, if anyone gets any further let me know.</pre>
