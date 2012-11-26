# Readme for the OU Player/ OU Embed project

A unified, accessible online media player solution for The Open University.

Built on Mediaelement, Flowplayer, CodeIgniter and oEmbed (all included).


## Requirements

 * Linux (Redhat RHEL 6) (ideally, or OS X/ Windows)
 * PHP 5.3+
   * cURL, `json_encode`
 * Apache 2.2+
   * mod_rewrite and `.htaccess` (`.sams`) (or access to `httpd.conf`)


## Installation {#install}

In brief, the steps for the installation of OU Media Player (and OU-Embed) are:

 1. Get the code, eg. `$ git clone https://[USER]@github.com/IET-OU/ouplayer.git`
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

When importing to _AllChange_, please ensure that these files and directories are ignored/ deleted:

    .git/
    .gitignore
    _data/         -- To discuss(*)
    _data/logs/*.php
    _data/oupodcast/*.*
    application/config/embed_config.php
    application/logs/*.php

(*) We need to either ignore the whole `_data/` directory, or most of its contents, including `logs/*.php` and `oupodcast/*`. Then [re-create - see install](#install).

## Include files {#include}

When importing to _AllChange_, please ensure that these files and directories are included/ implemented:

    _data/         -- See [ignore](#ignore)
    application/*  -- Except for [ignored files](#ignore)
    docs/*
    system/*
    .htaccess
    .sams
    index.php
    license-ci.txt
    README.md
    robots.txt
    version.json

## Links

* <http://embed.open.ac.uk> | <http://mediaplayer-dev.open.ac.uk>
* Bugs/ Issues:  [IET-IT-bugs: project/issues/ouplayer][bugs]


## Credits

OU player: Copyright 2010-2012 The Open University. All rights reserved.

* Not licensed as open-source (yet!)
* Author: Nick Freear <n.d.freear+@+open.ac.uk> / Institute of Educational Technology, and many others.

For full credits and licenses see [docs/CREDITS.txt][credit]



[install]: https://docs.google.com/document/d/1tg1mrPqniUp6evs0odfs7wughuMLY4r82-kFylVWQXE/edit#heading=h.1esjm0y5y8se
[bugs]: http://iet-it-bugs.open.ac.uk/project/issues/ouplayer
[credit_g]: https://github.com/IET-OU/ouplayer/tree/master/docs/CREDITS.txt
[credit]: http://iet-embed-acct.open.ac.uk/docs/CREDITS.txt


[End.]