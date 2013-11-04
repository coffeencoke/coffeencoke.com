---
layout: post
title: Managing Nginx
tags:
- development
- nginx
- servers
---

## Quick note...

Perhaps you have a monitoring process managing your Nginx processes, or your init scripts are broken, or you're on a mac and have no clue how to start nginx.  Simply use the bin file.

You can find this by running the `which nginx` command. And start using it.  Go to the <a href='http://wiki.nginx.org/CommandLine'>Nginx Command Line page</a> for more details.

{% highlight bash %}
# Start nginx
nginx
# Reload nginx
nginx -s reload
# Test config but do not effect the running processes
nginx -t
{% endhighlight %}
