# GNU Make file for OU Media Player (2014-07-15).
# Requires cygwin64 on Windows.

# Based on: git-pull-serv.php - Run git-pull on a Linux/Unix server, and log the before and after state.
# @copyright 2013-01-24 N.D.Freear.
# @link https://gist.github.com/nfreear/4620953

# Environment
PHP=C:/Users/ndf42/xampp/php/php
LOG=2>&1 > C:/Users/ndf42/git-pull-serv_crake.log


help:
	@echo
	# OU Media Player/ OU embed installer.
	@echo
	# Available targets:
	@echo "		update describe pull cm build-theme version gettext"

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


.PHONY: help update describe pull cm build-theme version gettext

#End.
