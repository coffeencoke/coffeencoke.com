---
layout: post
title: Develop Locally - keep production happy
tags:
- DWDF
- apache
- nginx
- wordpress
- ruby
- efficiency
- go faster
- tools
- troubleshooting
- tutorials
---

## And Keep Your Customers Happy!

A hack safe local development environment, means...

* More experiments, which could lead to better ways to do things
* Faster development, which allows time to improve your software
* Better software, because of the freedom it gives you
* Happier developer, because of all of the things above
* Happier customer, because of all of the things above

I think it is very important to continually be thinking about how you can improve the development process of a project. Your process may be so beautifully finely tuned, or it may be developing live code on the production server, or anything in between.  The truth is, there is never "nothing" to learn, and there is always something you can do, or stop doing, to improve your process.

It's important to invest in your development process

## Dear Web Design Freelancer

This post is the second topic of the [Dear Web Design Freelancer](/blog/2013/10/25/dear-web-design-freelancer/) series.

This topic is about creating a development environment for your projects on *your* computer! No more need to develop over FTP in <Dreamweaver, Eclipse, Fillin FTP IDE Here>. No more need to setup a development environment and waste money on a server, and to maintain that sucker, either.

Similar to my [post about software source control](/blog/2013/10/29/introduction-to-software-source-control/), there are many many excellent tutorials and resources out in the intertubes as it is. I do not wish to add to the heap of tutorials, but simply want to provide some direction to help you improve your lives.

*Take note, that [this series](/blog/2013/10/25/dear-web-design-freelancer/) is best to follow in order, and by applying each of these practices and tools, you will get the optimal result.  However, if you choose to only apply a subset, you will still improve your current process.*

## Wordpress Offline

*Or any kind of PHP project*

Here are some easy, beginner tutorials to setup an offline wordpress development workstation:

* [MAMP - Mac Apache MySQL PHP](http://codex.wordpress.org/Installing_WordPress_Locally_on_Your_Mac_With_MAMP)
* [MAMP Tutorial](https://www.youtube.com/watch?v=gP4E3KT12Zg)
* [WAMP - Windows Apache MySQL PHP](http://www.wampserver.com/en/)
* [WAMP Tutorial](https://www.youtube.com/watch?v=MHMV6tUuadA)

As you become more fluent with servers, you become more opinionated with what you use. My personal preference is to use the following:

* Develop on a mac, because you get unix, and a heavily invested operating system.
* [Nginx Web Server](http://wiki.nginx.org/Main) - I uninstall the built in apache, and install nginx with home brew.
* [MySQL](http://www.mysql.com/) - Also installed with homebrew.
* [POW](http://soderlind.no/wordpress-and-pow/) - Takes care of starting up servers, and setting up web server virtual hosts.,
* [VIM & MacVIM](https://code.google.com/p/macvim/) as my editor.

## Ruby Offline

* [RVM](http://rvm.io/)
* [Bundler](http://bundler.io/)
* [Rubygems](http://rubygems.org/)
* [POW](http://pow.cx/)
* [PostgreSQL](http://www.postgresql.org/)
* [MongoDB](http://www.mongodb.org/)

There is no need to use a web server like Nginx, or Apache, because you can use a very lightweight application server like [webrick](http://rubygems.org/gems/webrick), [thin](http://rubygems.org/gems/thin), [Jetty](http://rubygems.org/gems/jetty), [Glassfish](http://rubygems.org/gems/glassfish), [Puma](http://rubygems.org/gems/puma), etc.

## Wrap Up

If you would like some help setting up your development environment, please let me know, I'd be happy to help you out.

You should truly give this a try, and begin developing on your local computer. The next post in this series is about how to deploy your software to your server, which will enrich the local development lifestyle.

### More Info

* [12 factor application](http://12factor.net/)
* [introduction to software source control](/blog/2013/10/29/introduction-to-software-source-control/)