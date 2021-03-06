---
layout: post
title: Debugging Nginx configs
tags:
- development
- efficiency
- go faster
- install
- nginx
- programming
- servers
- troubleshooting
---
Often when working with web applications you need to write some pretty complicated Nginx configs. For example, if you are needing to support a rails application that is hosted as a sub-domain. This will require some complicated nginx configurations for serving static files, and using the correct root directory for the main app, as well as the app served at the subdirectory. Or, if you are configuring a wordpress site, with all that caching craziness!

This post is about making it easier to develop your Nginx configurations, not about rails app served as a sub directory. That <a href="http://coffeencoke.com/2012/12/serving-rails-with-a-subdirectory-root-path/">post can be found here</a>.

## 1. Install Echo

> ngx_echo - Brings "echo", "sleep", "time", "exec" and more shell-style goodies to Nginx config file.

It is a whole lot easier to develop your configurations when you can echo some debugging statements, especially if you're using regular expressions in your configuration.

However, unfortunately, you need to install the `ngx_echo` module when you compile and install Nginx itself. :(

This is not terribly complicated but is something I do not encourage you to do on a server that you are actually using for productive work.

Install it on your development computer!

My notes from the <a href='http://wiki.nginx.org/HttpEchoModule#Installation'>ngx_echo installation instructions</a>:

{% highlight bash %}
wget http://nginx.org/download/nginx-1.2.7.tar.gz
tar -xzf nginx-1.2.7.tar.gz
wget https://nodeload.github.com/agentzh/echo-nginx-module/tar.gz/v0.42
tar -xzf v0.42
cd nginx-1.2.7
sudo ./configure --prefix=/etc/nginx --sbin-path=/usr/local/bin/nginx --error-log-path=/var/log/nginx/error.log --http-log-path=/var/log/nginx/access.log --pid-path=/var/run/nginx.pid --lock-path=/tmp --with-http_ssl_module --with-http_gzip_static_module  --add-module=/Users/matt/tmp/echo-nginx-module-0.42
# Read the output to make sure this is what you want!
sudo make
sudo make install
{% endhighlight %}

Read <a href='http://wiki.nginx.org/HttpEchoModule'>the echo documentation</a> and you will be able to see what you are configuring without having to steal a server and disable somebody's productivity.

Cheers.
