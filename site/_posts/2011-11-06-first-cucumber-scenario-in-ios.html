---
layout: post
title: First Cucumber Scenario in iOS
tags:
- iOS
- iPhone
- programming
- Series
- TDD
- test driven development
- tools
status: draft
type: post
published: false
meta:
  _edit_last: '1'
---
In my previous post, I installed and configured Frank in my new iOS app.  To recap, I have not developed an iOS application before and I do not know what classes to write, where to put them and what they are even called.  This is a pretty fun experiment for a few reasons.
<ol>
	<li>Gets me out of my comfort zone</li>
	<li>Helps me learn how to teach others who are new to a language</li>
	<li>Improves my core principles of Test Driven Development</li>
</ol>
First things first; because the app root is not where our cucumber is, I don't like to leave my app root from the terminal, and we are using bundler, I need to run cucumber with a few customizations (make sure the Frank emulator is running):

<code>$ bundle exec cucumber Frank/features/my_first.feature --require Frank/features/</code>

You could bypass the require by the following:

<code>
$ cd Frank
$ bundle exec cucumber features/my_first.feature
</code>

and what I get is a beautiful message telling me that my APP_BUNDLE_PATH is not set. So I read on and add the recommended path in the config file (great help message).  Now that that is in place, I run it again.  After watching the emulator and getting 5 timeout error messages I dig into the wiki pages and how to's and found that I need to turn on Accessibility on the iPhone.  Because I don't like typing more than I need, go to <a href="https://github.com/moredip/Frank/wiki/Getting-started-with-Frank" target="_blank">this page</a> to read about what to do for that.

After applying those changes and rerunning the cucumber command I still get the timeout:

<code>Encountered 4 timeouts in a row while trying to launch the app. (RuntimeError)</code>

Because I am not getting any feedback from cucumber for this error I started looking at the logs in Xcode and found this 4 times:

<code>
2011-11-06 00:15:44.319 SherpaWeight copy[6095:f803] Checking for static file at /Users/matt/Library/Application Support/iPhone Simulator/5.0/Applications/46E81C98-C49A-4A60-B5BA-94BC7C42154D/SherpaWeight copy.app/frank_static_resources.bundle/favicon.ico
2011-11-06 00:15:44.320 SherpaWeight copy[6095:f803] HTTP Server: Error 404 - Not Found
</code>

Makes me think there's a problem here.
