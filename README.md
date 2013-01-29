# Readme for the OU Media Player/ OU Embed project

A unified, accessible online audio and video player solution for The Open University.

Built on Mediaelement, Flowplayer, CodeIgniter and oEmbed ([all included][credit]).


## Requirements

 * Linux (Redhat RHEL 6) (ideally, or OS X/ Windows)
 * PHP 5.3+
   * cURL, `json_encode`
 * Apache 2.2+
   * mod_rewrite and `.htaccess` (`.sams`) (or access to `httpd.conf`)


## Installation {#install}

In brief, the steps for the installation of OU Media Player (non IT-EUD hosting) and OU-Embed are:

 1. Get [the code][code], eg. `$ git clone https://[USER]@github.com/IET-OU/ouplayer.git`
 2. Copy: application/config/embed_config.dist.php to application/config/embed_config.php
 3. Set `$config['debug']`,
 4. Set `$config['podcast_feed_url_pattern']`,
 5. Check `$config['http_proxy']`,
 6. Create a data directory with `logs/` and `oupodcast/` sub-directories, and set permissions (eg. `$ chown -R apache:apache` )
 7. Set the data directory `$config['data_dir']` in application/config/embed_config.php,
 8. Set `$config['log_path']` in application/config/config.php

Details and notes:

* Installation guide: [extended readme on Google][install]


## Ignore files {#ignore}

When importing to [_AllChange_][allchange] for [IT-EUD hosting][eud], please ensure that these files and directories are ignored/ deleted:

    .git/
    .gitignore
    _data/         -- To discuss(*)
    _data/logs/*.php
    _data/oupodcast/*.*
    application/logs/*.php

(*) We need to either ignore the whole `_data/` directory, or most of its contents, including `logs/*.php` and `oupodcast/*`. Then [re-create - see install](#install).

## Include files {#include}

When importing to _AllChange_, please ensure that these files and directories are included/ implemented:

    _data/			-- See [ignore](#ignore)
    application/*/*	-- ALL sub-directories/files.. except for [ignored files](#ignore)
    application/config/config.php		-- ..Including
    application/config/embed_config.php	-- ..Including
    docs/*			-- ALL files
    system/*/*		-- ALL sub-directories/files
    .htaccess
    .sams
    index.php
    license-ci.txt
    README.md
    robots.txt
    version.json


## Releases {#releases}

### v0.9-beta-171-g1f5a76d
Release: 28 January/ Live: approx. 7 February 2013

#### OU Player features:

* Finished support for "rgb" colour parameter - VLE player [Bug #1324][#:1324]; fix 2013-01-07,
* Use new HTML transcript from OU Podcast site [Bug #1460][#:1460]; fix 2013-01-22; ref #1409],

#### OU Player bug fixes:

* Fixed video size issue - Chrome etc. - ender/jeesh/VLE/ no captions [Bug #1456][#:1456]; fix 2013-01-11; reported by Ray.Guo,
* Tooltip styling/ Z-index bug [Bug #1458]
* Podcast player "private" flag bug [Bug #1448; fix 2013-01-10; reported by Ben.Hawkridge]
* Firefox VLE player bug - "Sorry, your browser appears.." [Bug #1457][#:1457]; fix 2013-01-25; reported by Ray.Guo; [Bug #1447][#:1447]; reported by Ben.Hawkridge,
* "rgb" parameter error handling too draconian [Bug #1453; fix 2013-01-07]

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
* Bugs/ Issues:  [IET-IT-bugs: project/issues/ouplayer][bugs]


## Credits

OU player: Copyright 2010-2012 The Open University. All rights reserved.

* Not licensed as open-source (yet!)
* Author: Nick Freear <n.d.freear+@+open.ac.uk> / Institute of Educational Technology, and many others.

For full credits and licenses see [docs/CREDITS.txt][credit]



[code]: https://github.com/IET-OU/ouplayer
[eud]: http://intranet4.open.ac.uk/wikis/sysdevdoc/EUD_Hosting_Process "End User Development hosting, IT-OU"
[allchange]: http://intasoft.net/our-products/allchange/
[install]: https://docs.google.com/document/d/1tg1mrPqniUp6evs0odfs7wughuMLY4r82-kFylVWQXE/edit#heading=h.1esjm0y5y8se
[bugs]: http://iet-it-bugs.open.ac.uk/project/issues/ouplayer
[#:*]: http://iet-it-bugs.open.ac.uk/node/
[credit_g]: https://github.com/IET-OU/ouplayer/tree/master/docs/CREDITS.txt
[credit]: http://iet-embed-acct.open.ac.uk/docs/CREDITS.txt "Credits and licenses"

[End]: http://example