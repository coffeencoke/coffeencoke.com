---
layout: post
title: Phone Gap Whitelist Rejection Error
tags:
- api
- development
- iOS
- javascript
- mobile
- phone gap
- ruby on rails
status: publish
type: post
published: true
meta:
  _edit_last: '1'
  _wp_old_slug: ''
---
My mobile app continues.  As I was testing my registration API through the iOS emulator I got the following error:

{% highlight xml %}
MyApp [97185:15603] ERROR whitelist rejection: url='http://localhost:3000'
{% endhighlight %}

After some quick google searching, I discovered that in order to make requests outside of the file system I had to add the host to the phone gap's plist file.  For my project this file is located at <code>/MyApp/PhoneGap.plist</code>.  You can either edit this file with a text editor or edit it in Xcode.  The end result for me to be able to hit localhost within the app looks like this:

{% highlight xml %}
<?xml version="1.0" encoding="UTF-8"?>
...
<key>ExternalHosts</key>
<array>
<string>localhost</string>
</array>
...
{% endhighlight %}

After I made that change, I restarted my app through Xcode and the app was able to hit the rails server.
