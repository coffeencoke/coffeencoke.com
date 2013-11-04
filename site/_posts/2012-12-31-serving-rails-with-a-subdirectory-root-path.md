---
layout: post
title: Serving Rails with a Subdirectory Root Path
tags:
- development
- hosting
- install
- linux
- nginx
- programming
- ruby
- ruby on rails
- servers
- unicorn
---
<strong>View the <a href="/blog/2013/02/24/sub-directory-rails-app-part-2/">Sub Directory Rails App – Part 2</a></strong> post for an update on this topic. I have recently had the pleasure of serving a rails application where the root url is a subdirectory so that instead of <code>myapp.company.com</code> or <code>myapp.com</code> it is <code>company.com/myapp</code>. The web is full of guides for how to do this, but I <strong>did not</strong> find a guide that was specific to <strong>Nginx, Unicorn, Ruby 1.9.3, and Rails 3</strong>. <strong>You can view all files to configure this by <a href="https://gist.github.com/4422617" title="Coffeencoke Gist" target="_blank">viewing this gist</a>.</strong> First, you must be serving your unicorn workers using a unicorn socket. Point your Nginx configuration to use the unicorn sock

{% highlight nginx %}
upstream unicorn_socket_for_myapp {
  server unix:/home/coffeencoke/apps/myapp/current/tmp/sockets/unicorn.sock fail_timeout=0;
}
{% endhighlight %}

Next, setup your Nginx config to receive requests for the domain your app will be within:

{% highlight nginx %}
server {
  listen          80;
  server_name     coffeencoke.com www.coffeencoke.com;
}
{% endhighlight %}

Then, add a location block for the subdirectory you want your rails app to live. This should go inside of the server block.

{% highlight nginx %}
  # If static file exists, load directly from Nginx, bypass Rails
  # Otherwise, pass request off to unicorn proxy
  location /myapp/ {
    try_files $uri @unicorn_proxy;
  }

  location @unicorn_proxy {
    proxy_pass http://unix:/home/coffeencoke/apps/myapp/current/tmp/sockets/unicorn.sock;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header Host $http_host;
    proxy_redirect off;
    proxy_set_header X-Forwarded-Proto $scheme;
  }
{% endhighlight %}

Now you need to update your rails application so that it uses that subdirectory when generating urls and mapping to Actions and Controllers. Add a scope to your routes file like so:

{% highlight ruby %}
MyApp::Application.routes.draw do
  scope '/myapp' do
    root :to => 'registrations#new'

    # other routes are always inside this block
    # ...
  end
end
{% endhighlight %}

Your rails app will now map to

`/myapp/registrations/new`, instead of `/registrations/new` The problem however, is that when I am developing I do not want to write dependencies on this path structure, in case the application some day is not in a sub domain, also because it's annoying. Therefor, I created a module and included it into the routes file and used it like so:

{% highlight ruby %}
require_relative '../lib/route_scoper'

MyApp::Application.routes.draw do
  scope RouteScoper.root do
    root :to => 'registrations#new'

    # other routes are always inside this block
    # ...
  end
end
{% endhighlight %}

the module looks like this:

{% highlight ruby %}
require 'rails/application'

module RouteScoper
  def self.root
    Rails.application.config.root_directory
  rescue NameError
    '/'
  end
end
{% endhighlight %}

Pretty simple, if the environment has configured a specific root directory, then use that, otherwise, use '/', which is the same as not specifying anything. Now in my config/environments/production.rb file I have the following:

{% highlight ruby %}
MyApp::Application.configure do
  # Contains configurations for the production environment
  # ...

  # Serve the application at /myapp
  config.root_directory = '/myapp'
end
{% endhighlight %}

And in my config/environments/development.rb file, I do not specify

<code>config.root_directory</code> so that it uses the normal url root.
