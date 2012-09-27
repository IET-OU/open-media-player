# Readme for the OU Player/ OU Embed project

A unified, accessible online media player solution for The Open University.

Built on Mediaelement, Flowplayer, CodeIgniter and oEmbed.


## Installation

In brief, the 6 steps for the installation of OU Player/ OU-Embed:

1. Copy: application/config/embed_config.dist.php to application/config/embed_config.php
2. Set $config['debug'],
3. Set $config['podcast_feed_url_pattern'],
4. Check $config['http_proxy'],
5. Create a data directory, and set permissions ( $ chown -R apache:apache )
6. Set $config['data_dir'],

Detailed:

* Installation guide: [extended readme on Google](https://docs.google.com/document/d/1tg1mrPqniUp6evs0odfs7wughuMLY4r82-kFylVWQXE/edit)



## Links

* <http://embed.open.ac.uk> | <http://media-podcast-dev.open.ac.uk/player>
* Bugs/ Issues:  [iet-it-bugs.open.ac.uk/project/issues/ouplayer](http://iet-it-bugs.open.ac.uk/project/issues/ouplayer)


## Credits

OU player: Copyright 2010-2012 The Open University. All rights reserved.

* Not licensed as open-source (yet!)
* Author: Nick Freear <n.d.freear+@+open.ac.uk> / Institute of Educational Technology, and many others.

For full credits and licenses see docs/CREDITS.txt.


## TODOs
* Add INSERTs to *_serv.php
* Use $config[providers]..examples in the Demo controller.
* Error handling - use exceptions.
* Add $thumbnail_width to embed_cache Database.
* services.json, like Embed.ly.
* Use $this->CI->oembed_request, etc.


[End.]