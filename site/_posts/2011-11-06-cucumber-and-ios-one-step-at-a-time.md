---
layout: post
title: Cucumber and iOS - one step at a time
tags:
- cucumber
- install
- iOS
- programming
- Series
- TDD
- test driven development
- tools
status: publish
type: post
published: true
meta:
  _edit_last: '1'
  _wp_old_slug: ''
---
I have begun writing my first iOS application.  I come from a ruby background and for the past 2 years I have written everything test first starting with cucumber scenarios all the way down to unit tests.  The problem with starting a brand new language for me is I wanted to dive straight in to writing the production code.

WRONG.

That would not be test driven and the very fact that I wanted to do that made me throw out my core principles of writing solid quality software.

So I started looking into how I could write Acceptance Tests or Integration tests to drive my development and ultimately drive my learning of how to write an iOS application.

After browsing for a bit I found <a href="https://github.com/unboxed/icuke" target="_blank">iCuke</a> which was quite out of date.  If you look at the github page for this app it has not been touched since June 30, 2010! So I browsed a bit more and found <a href="https://github.com/moredip/Frank" target="_blank">Frank</a> which was updated a blazing 3 days ago!  Much better.

So, keep in mind that I have absolutely zero amount of knowledge on how to write an iOS application.  The tutorial for setting up Frank for an iOS application was point blank easy.  Follow the guide at this tutorial and you'll be good to go.  There is also <a href="http://vimeo.com/27691115" target="_blank">this video</a> that steps through that guide so you can visually double check that you set it up correctly!

How great is that!?

So far I am very excited to work on this application, I was bummed thinking that I will not be able to apply my core principles of a software craftsman for a new language but having found Frank, I will be able to drive my learning by writing very high level test scenarios for what I want to learn.  One step at a time.

The only addition I made is because I am from a ruby development background I used <a href="http://beginrescueend.com/" target="_blank">rvm</a> and <a href="http://gembundler.com/" target="_blank">bundler</a> to manage the gem.  The instruction in the tutorial is to run the following:

<code>$ sudo gem install frank-cucumber</code>

To do it the current way.  Use bundler (view the bundler website or view some of my bundler articles on how to get running with bundler).  The quick addition I made is to add a file named .rvmrc at the project root with the following content:

<code>rvm use 1.9.2@my_great_ios_app --create</code>

create a file named Gemfile with the following content:

<code> source :rubygems
</code><span style="font-family: monospace;">gem 'frank-cucumber'</span>

open a new shell or cd out of the directory and back in to accept the rvmrc file

<code> $ cd ..
$ cd -
</code>

Read and approve the instructions to accept the rvmrc file.  Basically it will just create a gem set named my_great_ios_app within my ruby 1.9.2 installation.  After that, install the gems:

<code>$ bundle install </code>

Now that this is completed, you will not have any other gems for this project except what it needs and you will not have any gems for any other project except for what those projects need.  Excellent way to have multiple projects on multiple versions of ruby and still be able to manage the gems at the application level.

Keep checking in to see more articles on how I am learning how to write an iOS application.  If you have any comments, questions or suggestions, please drop me a comment or email.  I'd love to hear from you.
