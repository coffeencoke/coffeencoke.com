# Beginning iOS Development with VIM

I love using vim for ruby development, and I just began learning iOS.

I was playing the board game "Life" with my [wonderful wife](http://bettyelainephotography.com), when the spinner kept getting stuck!  This must happen to many spinners out there in the world, thus, as most software developers do, I thought, surely there must be an app for that.

So I looked and sure enough there was a *single* app; and it was not up to par for my standards.  Which made me think that this would be a great first app for me to begin learning.

You're welcome to check out my progress on my [game spinner for iOS app on github](https://github.com/coffeencoke/game_spinner_for_ios).  You're welcome to give me pointers where I am doing bad things… yesterday me was stupid.

I tell you this so that you realize that I am roughly new to iOS, and I mostly develop server applications. 

I *do* know, however, that [I hate Xcode](http://damnyouxcode.tumblr.com/).  Therefor, I would love to figure out how to develop my project using my favorite tool, [VIM](http://www.vim.org/).

## Getting Started

## Notes

**video**

<http://objvimmer.com/blog/2011/09/25/what-a-vim-plus-kiwi-inner-tdd-loop-looks-like/>

**command line tools**

command line builds <https://github.com/facebook/xctool/>

```
brew install xctool
```

**XCTest**

New official testing framework for units

<http://iosunittesting.com/category/xctest/>

Kiwi?

KIF?

**UIAutomation**

for integration tests

**Clang Complete**

<http://www.vim.org/scripts/script.php?script_id=3302> - full code completion

**VIM plugins**

iOS - <https://github.com/eraserhd/vim-ios/>

cocoa - <http://www.vim.org/scripts/script.php?script_id=2674>

## Troubleshooting

Issues with code signing - don't want to spend money on dev membership yet…

```
 xctool -project GameSpinnerForIos.xcodeproj -scheme GameSpinnerForIos build -sdk iphonesimulator
```

**`-sdk iphonesimulator`** is the key option here.

`.xctool-args` file.
