<?php
/**
 * Controller to facilitate localization/ translation of OU player/ OU embed user-interface.
 *
 * @copyright Copyright 2011 The Open University.
 *
 * Examples:
 *   http://embed.open.ac.uk/localize/template
 *   http://embed.open.ac.uk/localize/po/zh-cn  -- View online.
 *   http://embed.open.ac.uk/localize/po/zh-cn/download  -- Opens in poEdit if installed.
 */

class Localize extends MY_Controller {

  const TEMPLATE = 'ouplayer.pot';

  public function index() {
    redirect('localize/template');
  }

  public function po($lang='x', $download=false) {
    $lang = strtolower($lang);
    if ('en'==$lang)redirect('localize/template');

    $name = "$lang.po";
	$path = APPPATH ."/language/$name";
	// MIME: text/x-po
	if ($download) {
	    header('Content-Type: text/x-po; charset=utf-8');
	} else {
	    header('Content-Type: text/plain; charset=utf-8');
	}
	if (file_exists($path)) {
		@header("Content-Disposition: inline; filename=$name");
		echo file_get_contents($path);
	}
	/*elseif (file_exists($path.'t')) { //Template.
		@header("Content-Disposition: inline; filename=$name".'t');
		echo file_get_contents($path.'t');
	}*/
	else {
		$this->_error("Language pack not found: $lang ($name)", 404);
	}
  }

  public function template($download=false) {
    $name = self::TEMPLATE;
	$path = APPPATH ."/language/$name";
	if ($download) {
	    header('Content-Type: text/x-po; charset=utf-8');
	} else {
	    header('Content-Type: text/plain; charset=utf-8');
	}
	if (file_exists($path)) {
		@header("Content-Disposition: inline; filename=$name");
		echo file_get_contents($path);
	} else {
		$this->_error("Language template not found: $name", 404);
	}
  }
}
