---
layout: post
title: How To make a Time Capsule with Ubuntu
status: draft
type: post
published: false
meta:
  _edit_last: '1'
---
I did not feel like buying a time capsule so that I can wirelessly backup my laptops with Time Machine.  I already have a 500Gb External HDD but I had to plug it in to my macbook pro every time I wanted to back it up.  So I installed ubuntu on one of my old computers, hooked it up and configured it to work with time machine automatically through my network.  Now, everytime my macbook pro is connected to my network and time machine starts up, it will backup to my external harddrive connected to my ubuntu box.

Here's what we'll install:

- Ubuntu 9.10
- openssh-server
- tightvnc
- netatalk
- avahi

Mac version is Mac OSX Snow Leopard 10.6.3

After you have ubuntu installed, I like to enable the ssh server and vnc so that I don't have to be at the box to work on it, but I want the ease of use that Mac provides through Snow Leopard screen sharing.

Install ssh and Screen Sharing

$ sudo apt-get install ssh

now you can ssh into the ubuntu box from your macbook pro by opening a terminal

$ ssh matt@descartes.local

Note: matt is my user and descartes is my hostname.  *.local is for local connection to that box

Now we want to install vnc so that we can access the desktop remotely:

$ sudo apt-get install tightvncserver

Start the vncserver with dimension 1280 x 800, depth 24 (better coloring), name Time Capsule and xserver 1.  To read up on the details on the options you can type $ man tightvncserver

$ tightvncserver -name "Time Capsule" -geometry 1280x800 -depth 24 :1

To make it easier I made a bash alias called timemachine_vnc_start so that you can just type that in (autocomplete by pressing tab) everytime you login.

in ~/.bash_aliases throw this in there:

alias timemachine_vnc_start='tightvncserver -name "Time Capsule" -geometry 1280x800 -depth 24 :1'

It may prompt you to set a password, so do that and you'll be good to go.  You can now go to "Connect to Server" from finder on your mac or press [command + k] and enter "vnc://descartes.local:5901" as the server address, press connect and you should now be logged in to your ubuntu desktop.

Map your External Harddrive

On your ubuntu box install gparted to partition your harddrive.  I find it best to do this from the Synaptic Package Manager: on the ubuntu desktop go to "System" -&gt; "Administration" -&gt; "Synaptic Package Manager".  Once this is open type "gparted" in the search box, check "Gparted" from the list and install.  After this is installed go to "System" -&gt; "Administration" -&gt; "GParted" and format your external harddrive as ext3 primary partition named "Time Capsule".

After it is formatted, unplug the harddrive and plug it back in so it mounts.  After it mounts open a terminal and type the following:

$ ls -lha /media

and you should see a folder "Time Capsule".  Now we want to make a symbolic link to that folder in your home directory.

$ ls -n /media/Time\ Capsule ~/TimeCapsule

And now we want to change the permissions of that directory so that your user can read and write to the drive:

$ sudo chown -R &lt;user&gt;:&lt;user&gt; /media/Time\ Capsule

Your drive should now be mapped to a folder in your home directory.

Install Netatalk

Now we need to install netatalk so that your mac can talk to your ubuntu box.

$ sudo apt-get install netatalk

configure it by telling netatalk which folders to share for which user.  Edit the file: /etc/natatalk/ so that it has this (replacing &lt;user&gt; with your user, and notice the spaces - very important those spaces...)
<div id="_mcePaste">~/ "Home Directory"</div>
<div id="_mcePaste">~/ "$u" allow:&lt;user&gt; cnidscheme:cdb</div>
<div id="_mcePaste">/home/&lt;user&gt;/TimeCapsule TimeCapsule allow:&lt;user&gt; cnidscheme:dbd options:usedots,upriv</div>
restart netatalk

$ sudo /etc/init.d/netatalk restart

Install Avahi

Avahi is used to initiate the "bonjour" functionality that Mac uses.  You may have noticed that whenever you are on your mac and in the presence of another mac, that other mac is automatically detected by your computer and visa versa.  You can connect to it and even access the screen sharing very easily from the finder.  This is because it uses bonjour to tell other computers of their presence.

Run the following:

$ sudo apt-get install avahi-daemon

We need to add a tool in a config file: add the following to the file /etc/nsswitch.conf as root so it looks like this:

hosts:          files mdns4_minimal [NOTFOUND=return] dns mdns4 mdns
<div>Now we need to add the services we wish to have our mac recognize by making the file: /etc/avahi/services/afpd.service have this:</div>
<div>
<div>&lt;?xml version="1.0" standalone='no'?&gt;&lt;!--*-nxml-*--&gt;</div>
<div>&lt;!DOCTYPE service-group SYSTEM "avahi-service.dtd"&gt;</div>
<div>&lt;service-group&gt;</div>
<div>&lt;name replace-wildcards="yes"&gt;%h&lt;/name&gt;</div>
<div>&lt;service&gt;</div>
<div>&lt;type&gt;_afpovertcp._tcp&lt;/type&gt;</div>
<div>&lt;port&gt;548&lt;/port&gt;</div>
<div>&lt;/service&gt;</div>
<div>&lt;service&gt;</div>
<div>&lt;type&gt;_rfb._tcp&lt;/type&gt;</div>
<div>&lt;port&gt;5901&lt;/port&gt;</div>
<div>&lt;/service&gt;</div>
<div>&lt;service&gt;</div>
<div>&lt;type&gt;_device-info._tcp&lt;/type&gt;</div>
<div>&lt;port&gt;0&lt;/port&gt;</div>
<div>&lt;txt-record&gt;model=Xserve&lt;/txt-record&gt;</div>
<div>&lt;/service&gt;</div>
<div>&lt;/service-group&gt;</div>
</div>
<div>restart avahi:</div>
<div>$ sudo /etc/init.d/avahi-daemon restart</div>
<div>Now your mac will automatically recognize file sharing and screen sharing, go to your finder, you should see your ubuntu listed in your computers list, click it and you should see a "connect as" and a "share screen" button.</div>
