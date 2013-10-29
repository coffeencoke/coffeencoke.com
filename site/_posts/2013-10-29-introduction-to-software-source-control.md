---
layout: post
title: Introduction to software source control
tags:
- DFDW
- git
- efficiency
- go faster
- continuous integration
- tools
- troubleshooting
- terminal
- versioning
- tutorials
- opensource
- command line
---

## never lose a thing, hack away safely!

If you develop software, whether it's a basic web page, Wordpress site, Drupal, PHP, Ruby on Rails, Java, Erlang, or even lolcode; You will eventually lose your work, or completely screw up your work and will have a very difficult, frustrating time getting back to a quality state.

This is one reason that you should consider learning a tool that will provide you with revision control for your code. Other terms used to describe this is source code management, distributed revision control, software configuration management, etc.

Revision control allows you to work on your code stress free, and without needing to manually create backup folders or files for working states.  Say goodbye to `my_report4.backup.php`, you will no longer need to retain these backups, because your revisions are controlled by something else.

My hands down recommendation right now is a tool called [Git](https://www.google.com/search?q=git&oq=git&aqs=chrome..69i57j69i60l3j69i59l2.529j0j4&sourceid=chrome&espv=210&es_sm=91&ie=UTF-8).  Git provides you with many abilities, and tools, but I want to focus on its revision control for now.

With Git, you can make "commits" as you develop your code, and at any point in time you can...

1. Revert back to a previous state
1. View a commit that you made in the past, with an explanation for that code
1. Learn why a line of code was added, or changed, and who changed it
1. Work on some new version or branch of your code, and still be able to make changes to the original code, without having to ship your unfinished version.

There are more advanced features that Git allows, especially when introducing a team environment with your project, and multiple environments, but those topics will be [added to this series at a later date](/blog/2013/10/25/dear-web-design-freelancer/).

There's no need for me to produce this grand tutorial on how to use Git, because, well... other people have already made plenty, and I do not wish to polite the inter tubes with duplicate stuff!

Please enjoy these, and seriously commit yourself to learning this tool!  It will make your life so much easier, not just for you, but for the next developer.

## Some Resources

* The best starter tutorial I've seen for Git: <http://try.github.io/levels/1/challenges/1>
* Variety of resources: <http://try.github.io/wrap_up>
* Great videos for all levels of learning git: <http://git-scm.com/videos>
* Github for your computer: <http://mac.github.com/> There's also github for windows, but eh to windows. And you can use this with any git repository, you don't have to use Github.

## Wrap Up

Please please please give it a try! I challenge you to really commit yourself to using git on one of your projects.  When you use a different project that doesn't use Git, I think you might cry.

## Next Steps

If you want to learn more about what you can do after you've decided to use Git, check out the following:

* Github
* Deploying your code with Capistrano
* Topics with Continuous Integration
* Server configuration management with Chef or Puppet