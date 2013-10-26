---
layout: post
title: Be fast with Bash Aliases
tags:
- bash
- command line
- efficiency
- go faster
- linux
- mac os x
- terminal
- tools
status: publish
type: post
published: true
meta:
  _edit_last: '3545253'
---
<img class="size-full wp-image-10 alignright" title="terminal_2" src="http://coffeencoke.com/wp-content/uploads/2009/06/terminal_2.png" alt="terminal_2" width="189" height="124" /><strong>How to use bash alias commands to your advantage</strong>

Using command line tools saves a developer an unbelievable amount of time.  The question is how do you save more time and increase your efficiency even more?

One of my favorite ways is one I've used a long time, by using bash aliases.  This post is directed to Mac OS X but may work with some linux distros as well, files are named differently.

How can this help you?  Lets say everytime you open a shell window you have to cd into a generally deep project directory like:
<blockquote>
<pre>/Users/mattsimpson/Clients/My\ Client/Web/Email\ Dispatch\ App/branches/0_8_0_1_ccd_migration</pre>
</blockquote>
This can be tedious and annoying very easily, especially if you like to keep your folder names standard english format like "My Client" rather than cammal case "MyClient" or "my_client", etc.

With Aliases we turn this:
<blockquote>
<pre>
<pre>[msimpson@dakota ~]$ cd /Users/mattsimpson/Clients/My\ Client/Web/Email\ Dispatch\ App/branches/0_8_0_1_ccd_migration</pre>
</pre>
</blockquote>
Into this
<blockquote>
<pre>[msimpson@dakota ~]$ email_dispatch_app</pre>
</blockquote>
which you can tab out after emai → [tab], that's jimmy johns fast.

<strong>How do I get there?</strong>

First, Open a terminal window and edit your <strong>.bash_login</strong> file (.bashrc for linux) with your favorite text editor:
<blockquote>
<pre>[msimpson@dakota ~]$ vi ~/.bash_login</pre>
</blockquote>
And <strong>Insert</strong> the following near the end of the file:
<blockquote>
<pre># Alias definitions.
# You may want to put all your additions into a separate file like
# ~/.bash_aliases, instead of adding them here directly.
# See /usr/share/doc/bash-doc/examples in the bash-doc package.

if [ -f ~/.bash_aliases ]; then
 . ~/.bash_aliases
fi</pre>
</blockquote>
<strong>Save</strong> and close.

Create a <strong>new file</strong>, let's name it <strong>.bash_aliases</strong> in your home directory:
<blockquote>
<pre>[msimpson@dakota ~]$ vi ~/.bash_aliases</pre>
</blockquote>
and <strong>insert</strong> the following into the first line of the newly created file, but replace the alias name (email_dispatch_app) with your desired command alias name and the command path (/Users/mattsimpson/Clients/My Client/Web/Email Dispatch App/branches/0_8_0_1_ccd_migration) with your desired command path...
<blockquote>
<pre>alias email_dispatch_app='cd /Users/mattsimpson/Clients/My\ Client/Web/Email\ Dispatch\ App/branches/0_8_0_1_ccd_migration'</pre>
</blockquote>
<strong>Save</strong> and close.

<strong>Execute</strong> the following command to <strong>reset your bash session</strong>:
<blockquote>
<pre>[msimpson@dakota ~]$ . ~/.bash_login</pre>
</blockquote>
You are now able to execute your command (email_dispatch_app) and it's <strong>tab completable!</strong> Go ahead and try it and see below for my list of aliases I have collected through the past couple years.
<blockquote>
<pre>[msimpson@dakota ~]$ email_dispatch_app</pre>
</blockquote>
<strong>Obviously</strong> you can see how this can speed up your development and allow you to <strong>focus on the things that matter</strong>, not on where you need to change directories, or that super long command that you always have to type in over and over.

Here is the list of aliases I have, feel free to contribute your aliases, I'd love to see how others are using aliases.

my .bash_aliases file:
<blockquote># General Use Aliases
alias l='ls -lh'
alias c='clear'
alias cx='chmod +x'
alias tree="find . -print | sed -e 's;[^/]*/;|____;g;s;____|; |;g'"

# Ruby / Ruby on Rails Aliases
alias cons='./script/console'
alias gen='./script/generate'
alias spec='./script/spec'
alias srv='./script/server -u'
function import_email { email_dispatch &amp;&amp; ./script/runner "IncomingEmailHandler.direct_mail(STDIN.read, '$1')"; }

# Project Directory Shortcuts
# ...
# a bunch of directory shortcuts
alias email_dispatch_app='cd /Users/mattsimpson/Clients/My\ Client/Web/Email\ Dispatch\ App/branches/0_8_0_1_ccd_migration'
# ...

# SSH Shortcuts
# ...
# a bunch of ssh commands so i don't have to remember users and ip addresses like:
alias sshenvion='ssh msimpson@xx.xx.xx.xxx'
# ...

# Services
alias mysqlservice='sudo /Library/StartupItems/MySQLCOM/MySQLCOM'
alias recover_scanner="cd /var/www/projects/cdops2/current/ &amp;&amp; sudo ./script/runner -e production "IncomingEmailHandler.recovery_scanner""
function mksvn { ssh msimpson@trogdor setupsvn.sh $1; }
# instead of
# $ svn checkout -m 'some svn message'
# you do
# $ svc some svn message
function svc { svn commit -m "'$*'"; }
function checkout { svn checkout svn+ssh://trogdor/var/svnroot/$1; }</blockquote>
My favorite is by far the srv and the svc commands.  Enjoy :)
