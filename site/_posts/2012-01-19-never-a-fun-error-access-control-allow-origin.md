---
layout: post
title: 'Never a fun error: Access-Control-Allow-Origin'
tags:
- development
- javascript
- mobile
- phone gap
- programming
status: publish
type: post
published: true
meta:
  _edit_last: '1'
  _wp_old_slug: '97'
---
If you are testing any javascript app against a web service and you run into the following error in your javascript console:

XMLHttpRequest cannot load <a title="http://localhost:3000/" href="http://localhost:3000/" target="_blank">http://localhost:3000/</a>. Origin <a title="http://guru_weight.dev" href="http://guru_weight.dev/">http://myapp.dev</a> is not allowed by Access-Control-Allow-Origin.

In this context it means that the host your are making the request from does not have permission to access the requested resource (<a href="http://www.w3.org/TR/cors/" target="_blank">it also means a lot of other things</a>).  After hunting you can do a at least 2 things:

1. Add the host to the access list by adding to the request header (http://enable-cors.org/)

2. Load the app using file:/// rather than the host.

Because I was writing this app as a native mobile app for iOS, Android, etc. I found out that PhoneGap loads the html files using the file:/// protocol.  So now, when I am developing on my computer, as long as I use the file:/// protocol, I have no problem with access to my API.
