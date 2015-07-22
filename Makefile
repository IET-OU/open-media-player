# GNU Make file for Open Media Player (2014-07-15).
# Requires cygwin64 on Windows.

# Based on: git-pull-serv.php - Run git-pull on a Linux/Unix server, and log the before and after state.
# @copyright 2013-01-24 N.D.Freear.
# @link https://gist.github.com/nfreear/4620953

# Environment
PHP=php
#PHP=C:/Users/ndf42/xampp/php/php
COMPOSER=composer
CFG=./application/config/


help:
	#
	# Open Media Player installer.
	#
	# Available targets:
	@echo "	generic install install-dev update update-nick pull cm build-theme version.json gettext"

generic:
	# Setting up a generic (non-OU) environment...
	@printf "#\n# .env: generic\n#\n" > .env
	@echo 'NF_COMPOSER_SUGGEST="(providers|basic auth|dotenv)"' >> .env
	@echo "" >> .env
	@echo 'OUENV=generic' >> .env
	@echo "" >> .env

install: prepare clean
	$(COMPOSER) install --no-dev --prefer-dist
	make post-install

install-dev: prepare clean
	$(COMPOSER) install -v
	make post-install

prepare:
	$(COMPOSER) self-update
	mv composer.json composer.json-TMP
	$(COMPOSER) require  wikimedia/composer-merge-plugin:1.*
	mv composer.json-TMP composer.json

post-install:
	# Post-install steps...
	@# Why doesn't msysgit/mingw32 cp have a "--no-clobber" option? :(
	[ -f $(CFG)embed_config.php ] || cp $(CFG)embed_config.dist.php $(CFG)embed_config.php
	[ -f $(CFG)oup_site.php ] || cp $(CFG)oup_site.dist.php $(CFG)oup_site.php
	make version.json

env-template:
	$(COMPOSER) dot-env-suggest > .env

clean:
	rm -rf composer.lock

clean-all: clean
	$(COMPOSER) clear-cache -v
	rm -rf vendor/
	rm -f version.json
	rm -f .env

diff:
	git diff
	cd vendor/iet-ou/open-media-player-core; git diff
	cd vendor/iet-ou/open-oembed-providers; git diff

st: describe
	git status
	@echo "";
	cd vendor/iet-ou/open-media-player-core; git status
	@echo "";
	cd vendor/iet-ou/open-oembed-providers; git status

update: describe pull describe version.json

update-nick: describe pull-nick describe version.json

describe:
	@git describe --tags --long
	@git log -1 --oneline

pull:
	git pull

pull-nick:
	git pull nick master

cm:
	git commit -em

build-theme:
	$(PHP) index.php build/theme

version.json:
	@$(PHP) index.php build/revision

gettext:
	$(PHP) application/cli/xgettext.php


.PHONY: help generic install install-dev update describe pull cm build-theme version.json gettext

#End.
