---
layout: post
title: 'Mac Issue: AELWriter Permission denied'
status: publish
type: post
published: true
meta:
  _edit_last: '1'
  _wp_old_slug: ''
---
<p>When I was inserting a new Product Serial Number for Adobe Aperture after migrating Aperture from another computer via that mac osx migration assistant.  Apperture will spin the dreadful spinning wheel of death and spit out this in the Console:</p>
<pre>
<div id="_mcePaste">2/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter[1230]) posix_spawn("/usr/sbin/AELWriter", ...): Permission denied</div>
<div id="_mcePaste">2/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter[1230]) Exited with exit code: 1</div>
<div id="_mcePaste">2/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter) Throttling respawn: Will start in 2 seconds</div>
2/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter[1230]) posix_spawn("/usr/sbin/AELWriter", ...): Permission denied2/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter[1230]) Exited with exit code: 12/6/11 9:19:24 PM	com.apple.launchd[1]	com.apple.launchd	(com.apple.aelwriter) Throttling respawn: Will start in 2 seconds
</pre>

<p>
The fix is found here:
</p>
<p>
<a href='http://support.apple.com/kb/TS3519' target='_blank'>Apple Support Fix</a>
</p>
happy fixing.
