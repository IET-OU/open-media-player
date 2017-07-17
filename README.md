
<!--[![Vote! Jisc][jisc-icon]][jisc]-->

[![Build status – Travis-CI][travis-icon]][travis]  [![Code Climate][climate-icon]][climate]
[![SensioLabs Insight][sensio-icon]][sensio] [![Remote test status][rtest-icon]][rtest]
[![Packagist][packagist-icon-x]][packagist]  [![License: GPL][license-icon]][gpl]
[![Translation][trans-icon]][trans]


# Open Media Player

A mainstream audio and video player service that puts accessibility front and centre.
We put the emphasis on ease of use for end-users and authors. From the [The Open University][ou].

* <https://embed.open.ac.uk>

Built on [MediaElement.js][], CodeIgniter and [oEmbed][].


## Requirements

* Linux, Mac OS X or Windows
* PHP 5.5.9+ (cURL, SimpleXML)
    * [Composer][]
* Apache 2.2+ (mod_rewrite) or Nginx


## Releases

* See [docs/CHANGELOG.md](docs/CHANGELOG.md).

## Links

* GitHub: [IET-OU/open-media-player-core][]
* GitHub: [IET-OU/open-media-player-themes][]
* GitHub: [IET-OU/open-media-player-extend][]
* GitHub: [IET-OU/open-oembed-providers][]

--

* <http://embed.open.ac.uk>
* <https://mediaplayer.open.ac.uk>

## Installation

* See the [installation guide on the Wiki][install].

In brief, using [Composer][]:

```
composer create-project iet-ou/open-media-player --no-dev -sdev --prefer-dist
```

## Credits

Open Media Player: Copyright © 2016 The Open University.

* Author: Nick Freear / [Institute of Educational Technology][iet], & many others.

For full credits and licenses see [docs/CREDITS.md](docs/CREDITS.md)

---
License:  [GPL version 3 onwards][gpl].

© 2011-2017 [The Open University][ou] and contributors. ([Institute of Educational Technology][iet])


[gpl]: LICENSE.txt "GNU General Public License 3.0 or (at your option) any later version / GPL-3.0+"
[gpl-ext]: http://gnu.org/licenses/gpl.html "GPL-3.0+"
[code]: https://github.com/IET-OU/open-media-player
[IET-OU/open-media-player-core]: https://github.com/IET-OU/open-media-player-core "License: GPL-3.0+"
[IET-OU/open-media-player-themes]:  https://github.com/IET-OU/open-media-player-themes "License: MIT"
[IET-OU/open-media-player-extend]: https://github.com/IET-OU/open-media-player-extend
[IET-OU/open-oembed-providers]:  https://github.com/IET-OU/open-oembed-providers
[install]: https://github.com/IET-OU/open-media-player/wiki/Install
[Composer]: https://getcomposer.org/
[MediaElement.js]: http://mediaelementjs.com/
[oEmbed]: http://oembed.com/ "oEmbed API specification"
[iet]: http://iet.open.ac.uk/
[ou]: http://www.open.ac.uk/

[packagist]: https://packagist.org/packages/IET-OU/open-media-player
[packagist-icon]: https://img.shields.io/packagist/v/IET-OU/open-media-player.svg#!v2.x-dev
[packagist-icon-x]: https://img.shields.io/badge/packagist-2.0--beta*-671c37.svg#!dark-red
[packagist-icon-p]: https://img.shields.io/badge/packagist-2.0--beta*-e3046b.svg#!pink
[license-icon]: https://img.shields.io/packagist/l/IET-OU/open-media-player.svg?style=flat
[travis]:  https://travis-ci.org/IET-OU/open-media-player
[travis-icon]: https://api.travis-ci.org/IET-OU/open-media-player.svg?branch=2.x "Build status – Travis-CI"
[climate]: https://codeclimate.com/github/IET-OU/open-media-player
[climate-icon]: https://codeclimate.com/github/IET-OU/open-media-player/badges/gpa.svg
[sensio]: https://insight.sensiolabs.com/projects/18d6d958-4571-4529-8c0c-5a70fa29be65 "SensioLabs Insight"
[sensio-icon]: https://insight.sensiolabs.com/projects/18d6d958-4571-4529-8c0c-5a70fa29be65/mini.png
[reposs]: https://reposs.herokuapp.com/?path=IET-OU/open-media-player "Repo size"
[rtest]: http://iet-embed-acct.open.ac.uk/dev/ou-media-player-test/report/ "Remote test status"
[rtest-icon]: http://iet-embed-acct.open.ac.uk/dev/ou-media-player-test/report/svg/
[jisc]: https://elevator.jisc.ac.uk/e/accessiblebydesign/#!/idea/open-media-player
[jisc-icon]: https://img.shields.io/badge/Jisc-vote_%E2%9C%93-ff6d00.svg "Vote for us in the Jisc Accessible by Design challenge"

[trans]: http://weblate.iet.open.ac.uk/projects/open-media-player/core "Translation status"
[trans-icon]: http://weblate.iet.open.ac.uk/widgets/open-media-player/-/shields-badge.svg?utm_source=widget

[End]: http://example
