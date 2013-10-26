---
layout: post
title: Chef - Making Cereal
excerpt: I've decided it was time for a new blog with a new name. By starting a new blog, I have some new tools that you should look in to. Reliable hosting for my blog for free, using Github! New direction for my blog, focusing on Computer Science, Other Languages, Community, and Business.
tags:
- bash
- development
- go faster
- efficiency
- process
- tools
- opensource
- continuous integration
- test driven development
- ruby
- servers
---

## Life Changing

It isn't very often, when you find a tool that completely changes the way you do things.  For me, this happened recently with [Opscode's Chef](http://www.opscode.com/chef/) tool for configuration management of machines. After learning Chef and actually beginning to use the tool, I've realized that my days of manually setting up servers is in the past.

This blog post is to share some of the basic information that I have learned about Chef.  It is a high level overview, but perhaps will provide a good construct for you to make the jump.

## High Level Elements

First of all, It’s Ruby! Therefor, I get all of the power, freedom, and enjoyment that I get in my favorite language, when working with server installation and configuration. If you do not know ruby, this is a great opportunity to begin, and if that still pushes you away, I still encourage you to look into using [Puppet](http://puppetlabs.com/).

### Converge

Converge in my definition is to install and configure a server to become one, via your chef scripts.  You can reconverge many servers, all to become up to date, or you can converge a brand new server.

### Recipes

*Opscode did a great job at sticking with the "Chef" terminology with other elements, like kitchen, chef, cookbooks, etc.*

**Recipes** are the actual implementation of units of responsibility used when converging.  Recipes should be separated in small units of responsibility, such as configuring an nginx website for ubuntu, or setting up a linux user, or managing the firewall rules.  Maybe you have a recipe for installing git from source.  Small manageable units of installation and configuration.

### Attributes

When implementing recipes, you often are using data for installing and configuring.  Data such as username, password, version of ruby, website root path, etc.  All of these things should be pulled up to attributes so that they can be configured more easily, which allows your recipe to be more widely distributable, and extensible.

### Cookbooks

Obviously, a cookbook contains many recipes, right!? So, you could have cookbooks for Nginx, Unicorn, UFW, Users, Apache, Git, Jenkins, etc.

### Roles

Roles allow you to combine recipes, and configure them with attributes.  A good example here is if you want a role for your specific application, and you want a different role for your database server.  These two roles would define the recipes required, and configure them with attributes of data to use.

### Environments

Very similar to roles, but instead of defining recipes, your mostly defining attributes, such as `RAILS_ENV`, or database username and passwords.

### LWRP - Light Weight Resources and Providers

These are constructs that Opscode provides to allow you to implement recipes with a more object oriented style.  Resources are objects that define data attributes, and providers contain actions that can be performed on a resource.

Instead of implementing your user cookbook with straight functional recipes, you might create a user LWRP (light weight resource and provider), to define the object, and implement any actions you would want.

### Data Bags

Data bags live on the chef server, and provide the ability to store encrypted and sharable information that can be queried into your recipes.

## Vision

> "Slow down Matt, what does all of this mean?"

Before we continue, let's talk about some of the amazing things that you can start doing if you start using Chef.

**Get what you want when you want it.** No more waiting for sysadmins to give you a machine with certain software and licenses, start working on developing an infrastructure where you can converge a workstation or server a la carte!

Just some ideas of what you could start working on, that almost every project needs:

* dev box for (ios, ruby, c#, java, etc)
* Jenkins
* Demo Server
* QA Servers
* Disposable Environment
* Custom Git server (w/ssh keys! Say goodbye to netrc files, what’s that?!)

**Automation** - Begin automating workstation and server configuration for all of those things.

**Consistency** - Create and maintain all servers and workstations from the same source.  It's easy to maintain one or two servers, but what about when you have 10 with *mostly* identical configuration requirements.  Maybe your production box is wide open, but your staging box has IP restrictions.

**Self Documenting** - Ever been the person who sets up a majority infrastructure, whether it's servers, workstation, or CI boxes?  Even though you documented as good as you could, and pair programmed, it still wasn't enough.  Ever been the other person? It sucks.  Having your configuration in code is not only documenting, but it's historical if you use source control like Git!

**Continuous Integration** - After being on a number of projects and leading a few of them, I've noticed that full application integration tests is not enough.  Especially when you have multiple applications for the same project.  Using chef allows you to have full integration tests from a brand new server to the end.  This kind of end to end testing is a dream come true for me, and motivates me to work on my project's recipes more.  After that, you can even have full continuous deployment, not only for software, but for configuration too!

## Life Is Hard

Life **IS** hard, but the benefit is so worth it.

* Slow Start
* High learning curve
* Organizational Momentum
* Ruby
* Chef Paradigms
* Windows automation
* Idempotence

All of these things cause it difficult to begin using chef and to commit.  Without committing fully, you end up with a crappy process.

## More To Come

There are a number of posts that I plan on following up on, so check back in:

* How to do Ruby
* Microsoft Windows automation
* Learn from Case study
* Testing & CI with Chef
* Chef Solo vs Chef Server
* Sharing Cookbooks & Documentation
* Learn from Cloud development

If you have other things you'd like to read about, [shoot me a message on twitter](https://twitter.com/coffeencoke)
