---
layout: post
title: Ruby Midwest Conf - Day 1 Part 1
tags:
- efficiency
- programming
- ruby
- ruby on rails
- rvm
- tools
status: publish
type: post
published: true
meta:
  _edit_last: '1'
---
So far the day has been filled with great pastries, excellent coffee, typically frustrated conference wifi, and fantastic talks about Ruby and craftsmanship.

The day started off with the why you should not use sudo, for most things.  Your ruby development computer should be setup using a number of tools that should not be installed with sudo, simply because with most if the tools, they can’t.  Your development environment should be isolated in your profile, one step deeper though; isolated in your project.

<strong>Use RVM .</strong>
<strong> Ro</strong>

RVM is a ruby version master (err, manager).  It allows you to install multiple versions of Ruby, JRuby, Rubinius, etc. on the same computer.  Further yet, it allows you to have completely separate gems for each project by using gemsets.

<strong>The Ruby Safari
Ola</strong>

Ola did a great job throwing out some technical intricacies which really pushed me to get to know my language more.  As I develop using Ruby I use and reuse the same methods and classes.  His talk has encouraged me to look into deeper implementation of Ruby and to ‘play’ with creative patterns.

One thing I particularly liked is commenting and writing Regular Expressions with group names.  However, the big bang from his talk for me was requiring a fake library.  I am constantly growing and learning (trying to) and one place I have been focusing on is speed of tests and design of tests, unit tests to be more specific.  With rails, it is very difficult to write true unit specs that are blazing fast.  More to come on this in future posts.
