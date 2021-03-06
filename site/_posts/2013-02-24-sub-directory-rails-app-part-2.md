---
layout: post
title: Sub Directory Rails App - Part 2
tags:
- development
- nginx
- programming
- ruby
- ruby on rails
- rvm
- troubleshooting
---
Recently I <a href="/blog/2012/12/31/serving-rails-with-a-subdirectory-root-path/">wrote about serving rails at a sub directory within another app</a>. I've recently deployed a new Rails 3 application with this and have discovered a few modifications to this. I've been maintaining a <a href="https://gist.github.com/coffeencoke/4422617">gist of my own</a> to contain the changes required to serve a rails app at a subdirectory. I was having a hard time getting all of the following cases to succeed: 1. Serve static files of root app and sub app through Nginx. 2. Serve rails requests for the appropriate app 3. Generate the correct paths via Rails 3 asset pipeline so that an app at /subdir generated assets with linking to images at /subdir/assets rather than /assets If you follow the template laid out in

<a href="https://gist.github.com/coffeencoke/4422617">the gist</a> you should have no problems. Pay close attention to the README as well as the other files in the gist! I'd love to see other people's implementations and challenges they faced and how they solved them. Let me know if you have any feedback or improvements.
