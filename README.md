# Open Media Player

A mainstream audio and video player service that puts accessibility front and centre.
We put the emphasis on ease of use for end-users and authors. From the [The Open University][ou].

* <https://embed.open.ac.uk>

Built on [MediaElement.js][], CodeIgniter and [oEmbed][].


See the [open source project](https://iet-ou.github.io/open-media-player/).


## Requirements

* Linux, Mac OS X or Windows
* PHP 7.2+ (cURL, SimpleXML)
* Apache 2.2+ (mod_rewrite)


## Releases

### Version 1.3.2
Release 22 April 2016 /

* Replicated fixes on mobile version of site
* Tidied up tab navigation

### Version 1.3.1
Release 31 March 2016 /

* Automated javascript build process using grunt
* Switched from closure compiler to uglify for javascript build, issue with
display of full screen and caption icons appears to be fixed.

### Version 1.3
Release 11 March 2016 / :

* Fixed issue with poster image stretching
* Fixed issues with display of poster image for audio files
* Added https:// to poster images
* Added extra code for testing purposes in /test_area

### v1.2-1-gb9f13ac
Release 17 Aug/ Live: approx. 25 Aug 2015

* Fix 'disallowed key characters' bug [Bug:22]

### v1.1-26-g731260f
Release: 5 Jan/ Live: 14 Jan 2015

* Fix jQuery XSS vulnerability [Bug:8]

### v1.1-25-g535a7b7
Release: 17 Dec/ Live: 18 Dec 2014

* Fix PHP notice/ warning [Bug:7]
* Fix PHP `error_reporting()`/ `display_errors` use [Bug:7]

### v1.1-21-gba86785
Release: 5 Dec/ Live: 11 Dec 2014

* Fix to add "no-proxy" support to Http library - intranet-restricted [Bug:3]
* Fix cookies for intranet-restricted transcripts [Bug:4]
* Add analytics events to OpenLearn (legacy) player [Bug:5]

### v1.1-12-g1f75bbf
Release: 21 Nov/ Live: approx. 26 Nov 2014

* Fix OU Media Player for intranet-restricted content [Bug:1]

### v1.1-9-g17ff3ce
<!-- v1.1-0-g0075a19 equiv. to v1.0-rc.1-45-g0075a19 // v1.1-8-g7cf9e8f -->
Release: ~2 Jun/ Live: 12 Jun 2014

* Hide the title panel/ banner for OUICE/OU-branded pages [iet-it-bugs: 1486](http://iet-it-bugs.open.ac.uk/node/1486) [LTS-redmine: 10744](http://ltsredmine.open.ac.uk/issues/10744),
* Fix: "In IE11 (Win8) we just see a black rectangle.." [iet-it-bugs: 1487](http://iet-it-bugs.open.ac.uk/node/1487) (CSS)
* Fix: broken transcript links,
* Fix: Remove "View on Podcast site" link for private media,
* Fix: Correctly handle secure HTTPS media URLs,
* Fix: add support for "http://media-podcast.open.ac.uk" URLs,
* Fix: remove "role=application" from Player embeds (accessibility),
* Fix: time-display widget overlaps progress-bar - prevents dragging (CSS),
* Add Google Analytics to OpenLearn player variant, add Player logo to about page.

### v1.0-rc.1-32-gd251c7a
Release: ~10 Dec/ Live: 12 Dec 2013

* Fix: full screen button, only top half works - FLV [Ltsredmine: #8526][lts#:8526]
* Fix: "no-Flash" message intermittently appearing (OpenLearn) [#9072]
* Fix: I'm seeing subtitles twice - Chrome only [#9071]
* Fix: full screen consistency, inc. follow up [Ltsredmine: #7911][lts#:7911]
* Fix: Player controls alignment CSS [iet-it-bugs: #1485][#:1485]

### v1.0-rc.1-0-gd0bb0cb
v0.95-beta-80-gd0bb0cb
Release: 25 July/ Live: approx. 30 July 2013

#### Player fixes following [LTS-tech-testing][lts-bugs]:

* List - todo - [iet-it-bugs: #1477][#:1477]
* Video offset bug [Ltsredmine: #6932][lts#:6932]
* Playing on tablet device [Ltsredmine: #7182][lts#:7182]
* ..

### v0.95-beta-39-g584d305
Release: 31 May/ Live: approx. 21 June 2013

### v0.95-beta-30-gcfe9c2d
Release: 20 May/ Live: approx. 23 May 2013

#### OU Player features:

* The Player is now available under HTTPS/ SSL - initially for VLE use.

#### OU Player bug fixes:

* Javascript/ configuration fix for video size - Internet Explorers/ MSIEs 7/ 9 [Bug #1474][#:1474]
* Config. fix to Ender/jeesh Javascript URL under HTTPS/ SSL [Bug #1473]
* Fix for `no-svg` class in `oup-light` CSS stylesheet [Bug #1476]
* Follow-up PHP fix for analytics [Bug #1464]

### v0.95-beta-2-gb72490b
Release: 31 January/ Live: approx. 7 February 2013

#### OU Player features:

* Finished support for "rgb" colour parameter - VLE player [Bug #1324][#:1324]; fix 2013-01-07,
* Use new HTML transcript from OU Podcast site [Bug #1460][#:1460]; fix 2013-01-22; ref #1409],

#### OU Player bug fixes:

* Fixed video size issue - Chrome etc. - ender/jeesh/VLE/ no captions [Bug #1456][#:1456]; fix 2013-01-11; reported by Ray.Guo,
* Tooltip styling/ Z-index bug [Bug #1458]
* Podcast player "private" flag bug [Bug #1448; fix 2013-01-10; reported by Ben.Hawkridge]
* Firefox VLE player bug - "Sorry, your browser appears.." [Bug #1457][#:1457]; fix 2013-01-25; reported by Ray.Guo; [Bug #1447][#:1447]; reported by Ben.Hawkridge,
* "rgb" parameter error handling too draconian [Bug #1453; fix 2013-01-07]
* Fixed access control - ignore private/ published flags, set cookie [Bug #1463][#:1463]; fix 2013-01-30; reported by Ben.Hawkridge,

#### OU Embed:

* OU Embed demo/preview form [Bug #1455][#:1455]
* Bibsonomy provider, ScraperWiki external provider [Bug #1461; #1420]
* Embedding from Wordpress.com blogs - Noembed [Cloudworks #310]
* Fileviewer provider, including CompendiumLD SVG [Bug #1420]
* iSpot external provider [Bug #1408; added 2012-10-11]

### v0.9-beta-123-gfc4eaf3
Release: 10 December/ Live: 13 December 2012

* Upgrade to latest MediaElement.js 2.10.0 [Bug #1368][#:1368]; commit 2012-12-10; 2.9.5-32-g98263df,
* Upgrade to CodeIgniter 2.1.3 [Bug #1410; commit 2012-10-31]
* Support "maxwidth" - plus experimental "pcwidth" (100% / percent width) [Bug #1415]
* New placeholder/locked image for private podcasts [Bug #1401; added 2012-09-25; by Peter Devine]

#### OU Player bug fixes (September-December 2012):

* Chrome fails MP4 using mediaelement/ maybe-to-no [Bug #1416][#:1416]; fix 2012-12-10,
* PHP-Apache hangs on IT-EUD-Acct/ LOCK_EX/ CodeIgniter logging [Bug #1446; fix 2012-12-10]
* MSIE 9 compatibility view style/CSS width [Bug #1417]
* Mobile fix - width=100%/ jQuery/Ender [Bug #1414]
* Documentation [Bug #1413]
* MY_Input workaround for Drupal-oembed consumers [Bug #1378; fixed 2012-11-06]
* MediaElement.js error/ event handling [Bug #1412; fixed 2012-10-29]
* IT deployment fixes [Bug #1406][#:1406]; #1400; September,


## Links

* <http://embed.open.ac.uk> | <http://mediaplayer.open.ac.uk>
* Bugs/ Issues:  [IET-OU/open-media-player][bugs]


## Installation

In brief, the steps for the installation of OU Media Player (non IT-EUD hosting) and OU-Embed are:

 1. Get [the code][code], eg. `$ git clone https://github.com/IET-OU/open-media-player.git`
 2. Copy: application/config/embed_config.dist.php to application/config/embed_config.php
 3. Set `$config['debug']`,
 4. Set `$config['podcast_feed_url_pattern']`,
 5. Check `$config['http_proxy']`,
 6. Create a data directory with `logs/` and `oupodcast/` sub-directories, and set permissions (eg. `$ chown -R apache:apache` )
 7. Set the data directory `$config['data_dir']` in application/config/embed_config.php,
 8. Set `$config['log_path']` in application/config/config.php

Details and notes:

* Installation guide: [extended readme on Google][install]


## Ignore files

When importing to [_AllChange_][allchange] for [IT-EUD hosting][eud], please ensure that these files and directories are ignored/ deleted:

    .git/*/*       -- ALL sub-directories/ files
    .gitignore
    _data/         -- To discuss(*)
    _data/logs/*.php
    _data/oupodcast/*.*
    application/logs/*.php

(*) We need to either ignore the whole `_data/` directory, or most of its contents, including `logs/*.php` and `oupodcast/*`. Then [re-create - see install](#install).

## Include files

When importing to _AllChange_, please ensure that these files and directories are included/ implemented:

    _data/			-- See [ignore](#ignore)
    application/*/*	-- ALL sub-directories/ files.. except for [ignored files](#ignore)
    application/config/config.php		-- Including.. config.php
    application/config/embed_config.php	-- Including.. embed_config.php
    docs/*			-- ALL files
    system/*/*		-- ALL sub-directories/ files
    .htaccess
    .sams
    index.php
    license-ci.txt
    README.md
    robots.txt
    version.json


## Credits

Open Media Player: Copyright © 2010-2021 [The Open University][ou] ([IET][]).

* Author: Nick Freear / Institute of Educational Technology, and many others.

For full credits and licenses see [docs/CREDITS.txt](docs/CREDITS.txt)



[code]: https://github.com/IET-OU/open-media-player
[eud]: http://intranet4.open.ac.uk/wikis/sysdevdoc/EUD_Hosting_Process "End User Development hosting, IT-OU"
[allchange]: http://intasoft.net/our-products/allchange/
[install]: https://docs.google.com/document/d/1tg1mrPqniUp6evs0odfs7wughuMLY4r82-kFylVWQXE/edit#heading=h.1esjm0y5y8se
[bugs_o]: http://iet-it-bugs.open.ac.uk/project/issues/ouplayer
[bugs]: https://github.com/IET-OU/open-media-player/issues/
[lts-bugs]: http://ltsredmine.open.ac.uk/projects/ouplayer/issues
[#:*]: http://iet-it-bugs.open.ac.uk/node/
[lts#:*]: http://ltsredmine.open.ac.uk/issues/
[bug#:*]: https://github.com/IET-OU/open-media-player/issues/
[Bug:*]:  https://github.com/IET-OU/open-media-player/issues/
[Bug:22]: https://github.com/IET-OU/open-media-player/issues/22
[credit_g]: https://github.com/IET-OU/open-media-player/tree/master/docs/CREDITS.txt
[credit]: http://iet-embed-acct.open.ac.uk/docs/CREDITS.md "Credits and licenses"

[MediaElement.js]: https://mediaelementjs.com/
[oEmbed]: https://oembed.com/ "oEmbed API specification"
[iet]: https://iet.open.ac.uk/ "Institute of Educational Technology"
[ou]: http://www.open.ac.uk/

[End]: http://example
