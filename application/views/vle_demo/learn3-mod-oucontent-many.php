<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A test page for the OU-VLE with many media players.
 *
 * @copyright Copyright 2012 The Open University.
 * @author NDF, 19 April 2012.
 * @link http://learn3.open.ac.uk/mod/oucontent/view.php?id=718&section=4
 */


$input = $this->input;
$body_classes = '';
$body_classes .= $input->get('edge') ? ' oup-vle-edge' :'';


// 24 instances of the player (2 videos).
$original = (bool) $input->get('original');
if ($original) {
  $player_url_unenc = 'http://learn3.open.ac.uk/local/mediahack/';
  #$player_url = 'http:\/\/learn3.open.ac.uk\/local\/mediahack\/';
  $audio_height = 30;
  $body_classes .=' vle-mediahack';
} else {
  $player_url_unenc = site_url('embed/vle');
  $audio_height = 36; #22;
}
$player_url = str_replace('"', '', json_encode($player_url_unenc));


// Player 'foreground' colour.
$player_param = '';
$rgb = $input->get('rgb');
if ($rgb) {
  $player_param .= "&amp;rgb=$rgb";
}


// URL for stylesheets, Javascript, images etc.
$resource_url = 'http://learn3.open.ac.uk';

// 'newwindow.png' icon.
$icon_url = "$resource_url/mod/oucontent/";

$transcript_url = "$resource_url/mod/oucontent/";



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  dir="ltr" lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>*OUVLE 'many' players test | OU Player |   Learning Guide 1: Quality of life and wellbeing: Learning Guide 1 resources</title>
    <link rel="shortcut icon" href="<?php echo $resource_url ?>/theme/image.php?theme=ou&amp;image=favicon&amp;rev=730&amp;component=theme" />
    <link rel="stylesheet" type="text/css" href="<?php echo $resource_url ?>/includes/headers-footers/ou-header.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $resource_url ?>/includes/studenthome-header-2012.css" />
    <script type="text/javascript" src="<?php echo $resource_url ?>/includes/headers-footers/ou-header.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="moodle, Learning Guide 1: Quality of life and wellbeing: Learning Guide 1 resources" />
<link rel="stylesheet" type="text/css" href="<?php echo $resource_url ?>/theme/yui_combo.php?3.4.1/build/cssreset/reset-min.css&amp;3.4.1/build/cssfonts/fonts-min.css&amp;3.4.1/build/cssgrids/grids-min.css&amp;3.4.1/build/cssbase/base-min.css" />
<script type="text/javascript" src="http://learn3.open.ac.uk/lib/yui/3.4.1/build/yui/yui-min.js"></script>
<script type="text/javascript" src="http://learn3.open.ac.uk/theme/yui_combo.php?2.9.0/build/yahoo-dom-event/yahoo-dom-event.js&amp;2.9.0/build/connection/connection-min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $resource_url ?>/theme/yui_combo.php?2.9.0/build/assets/skins/sam/skin.css" />
<script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script><link rel="stylesheet" type="text/css" href="http://learn3.open.ac.uk/theme/styles.php?theme=ou&amp;rev=730" />
<script type="text/javascript">
//<![CDATA[
var M = {}; M.yui = {}; var moodleConfigFn = function(me) {var p = me.path, b = me.name.replace(/^moodle-/,'').split('-', 3), n = b.pop();if (/(skin|core)/.test(n)) {n = b.pop();me.type = 'css';};me.path = b.join('-')+'/'+n+'/'+n+'.'+me.type;}; var galleryConfigFn = function(me) {var p = me.path,v=M.yui.galleryversion,f;if(/-(skin|core)/.test(me.name)) {me.type = 'css';p = p.replace(/-(skin|core)/, '').replace(/\.js/, '.css').split('/'), f = p.pop().replace(/(\-(min|debug))/, '');if (/-skin/.test(me.name)) {p.splice(p.length,0,v,'assets','skins','sam', f);} else {p.splice(p.length,0,v,'assets', f);};} else {p = p.split('/'), f = p.pop();p.splice(p.length,0,v, f);};me.path = p.join('/');};
M.yui.loader = {"base":"http:\/\/learn3.open.ac.uk\/lib\/yui\/3.4.1\/build\/","comboBase":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?","combine":true,"filter":"","insertBefore":"firstthemesheet","modules":{"yui2-event":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/event\/event-min.js"},"yui2-animation":{"type":"js","requires":["yui2-dom","yui2-event"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/animation\/animation-min.js"},"yui2-swfstore":{"type":"js","requires":["yui2-element","yui2-cookie","yui2-swf"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/swfstore\/swfstore-min.js"},"yui2-datatable":{"requires":["yui2-element","yui2-datasource"],"type":"js","optional":["yui2-calendar","yui2-dragdrop","yui2-paginator"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/datatable\/datatable-min.js"},"yui2-swfdetect":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/swfdetect\/swfdetect-min.js"},"yui2-menu":{"requires":["yui2-containercore"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/menu\/menu-min.js"},"yui2-treeview":{"requires":["yui2-event","yui2-dom"],"type":"js","optional":["yui2-json","yui2-animation","yui2-calendar"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/treeview\/treeview-min.js"},"yui2-get":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/get\/get-min.js"},"yui2-progressbar":{"requires":["yui2-element"],"type":"js","optional":["yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/progressbar\/progressbar-min.js"},"yui2-uploader":{"type":"js","requires":["yui2-element"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/uploader\/uploader-min.js"},"yui2-datasource":{"requires":["yui2-event"],"type":"js","optional":["yui2-connection"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/datasource\/datasource-min.js"},"yui2-profiler":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/profiler\/profiler-min.js"},"yui2-connection":{"supersedes":["yui2-connectioncore"],"requires":["yui2-event"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/connection\/connection-min.js"},"yui2-json":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/json\/json-min.js"},"yui2-datemath":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/datemath\/datemath-min.js"},"yui2-calendar":{"supersedes":["yui2-datemath"],"requires":["yui2-event","yui2-dom"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/calendar\/calendar-min.js"},"yui2-simpleeditor":{"requires":["yui2-element"],"type":"js","optional":["yui2-containercore","yui2-menu","yui2-button","yui2-animation","yui2-dragdrop"],"pkg":"editor","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/editor\/simpleeditor-min.js"},"yui2-swf":{"supersedes":["yui2-swfdetect"],"requires":["yui2-element"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/swf\/swf-min.js"},"yui2-event-simulate":{"type":"js","requires":["yui2-event"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/event-simulate\/event-simulate-min.js"},"yui2-yuiloader-dom-event":{"supersedes":["yui2-yahoo","yui2-dom","yui2-event","yui2-get","yui2-yuiloader","yui2-yahoo-dom-event"],"rollup":5,"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/yuiloader-dom-event\/yuiloader-dom-event.js"},"yui2-storage":{"requires":["yui2-yahoo","yui2-event","yui2-cookie"],"type":"js","optional":["yui2-swfstore"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/storage\/storage-min.js"},"yui2-container":{"supersedes":["yui2-containercore"],"requires":["yui2-dom","yui2-event"],"type":"js","optional":["yui2-dragdrop","yui2-animation","yui2-connection"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/container\/container-min.js"},"yui2-profilerviewer":{"requires":["yui2-profiler","yui2-yuiloader","yui2-element"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/profilerviewer\/profilerviewer-min.js"},"yui2-imagecropper":{"requires":["yui2-dragdrop","yui2-element","yui2-resize"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/imagecropper\/imagecropper-min.js"},"yui2-paginator":{"requires":["yui2-element"],"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/paginator\/paginator-min.js"},"yui2-tabview":{"requires":["yui2-element"],"type":"js","optional":["yui2-connection"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/tabview\/tabview-min.js"},"yui2-layout":{"requires":["yui2-element"],"type":"js","optional":["yui2-animation","yui2-dragdrop","yui2-resize","yui2-selector"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/layout\/layout-min.js"},"yui2-imageloader":{"type":"js","requires":["yui2-event","yui2-dom"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/imageloader\/imageloader-min.js"},"yui2-containercore":{"requires":["yui2-dom","yui2-event"],"type":"js","pkg":"container","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/container\/container_core-min.js"},"yui2-event-mouseenter":{"type":"js","requires":["yui2-dom","yui2-event"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/event-mouseenter\/event-mouseenter-min.js"},"yui2-logger":{"requires":["yui2-event","yui2-dom"],"type":"js","optional":["yui2-dragdrop"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/logger\/logger-min.js"},"yui2-cookie":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/cookie\/cookie-min.js"},"yui2-stylesheet":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/stylesheet\/stylesheet-min.js"},"yui2-connectioncore":{"requires":["yui2-event"],"type":"js","pkg":"connection","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/connection\/connection_core-min.js"},"yui2-utilities":{"supersedes":["yui2-yahoo","yui2-event","yui2-dragdrop","yui2-animation","yui2-dom","yui2-connection","yui2-element","yui2-yahoo-dom-event","yui2-get","yui2-yuiloader","yui2-yuiloader-dom-event"],"rollup":8,"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/utilities\/utilities.js"},"yui2-dragdrop":{"type":"js","requires":["yui2-dom","yui2-event"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/dragdrop\/dragdrop-min.js"},"yui2-colorpicker":{"requires":["yui2-slider","yui2-element"],"type":"js","optional":["yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/colorpicker\/colorpicker-min.js"},"yui2-event-delegate":{"requires":["yui2-event"],"type":"js","optional":["yui2-selector"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/event-delegate\/event-delegate-min.js"},"yui2-yuiloader":{"type":"js","supersedes":["yui2-yahoo","yui2-get"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/yuiloader\/yuiloader-min.js"},"yui2-button":{"requires":["yui2-element"],"type":"js","optional":["yui2-menu"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/button\/button-min.js"},"yui2-resize":{"requires":["yui2-dragdrop","yui2-element"],"type":"js","optional":["yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/resize\/resize-min.js"},"yui2-element":{"requires":["yui2-dom","yui2-event"],"type":"js","optional":["yui2-event-mouseenter","yui2-event-delegate"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/element\/element-min.js"},"yui2-history":{"type":"js","requires":["yui2-event"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/history\/history-min.js"},"yui2-yahoo":{"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/yahoo\/yahoo-min.js"},"yui2-element-delegate":{"type":"js","requires":["yui2-element"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/element-delegate\/element-delegate-min.js"},"yui2-charts":{"type":"js","requires":["yui2-element","yui2-json","yui2-datasource","yui2-swf"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/charts\/charts-min.js"},"yui2-slider":{"requires":["yui2-dragdrop"],"type":"js","optional":["yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/slider\/slider-min.js"},"yui2-selector":{"type":"js","requires":["yui2-yahoo","yui2-dom"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/selector\/selector-min.js"},"yui2-yuitest":{"requires":["yui2-logger"],"type":"js","optional":["yui2-event-simulate"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/yuitest\/yuitest-min.js"},"yui2-carousel":{"requires":["yui2-element"],"type":"js","optional":["yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/carousel\/carousel-min.js"},"yui2-autocomplete":{"requires":["yui2-dom","yui2-event","yui2-datasource"],"type":"js","optional":["yui2-connection","yui2-animation"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/autocomplete\/autocomplete-min.js"},"yui2-yahoo-dom-event":{"supersedes":["yui2-yahoo","yui2-event","yui2-dom"],"rollup":3,"type":"js","fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/yahoo-dom-event\/yahoo-dom-event.js"},"yui2-dom":{"type":"js","requires":["yui2-yahoo"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/dom\/dom-min.js"},"yui2-editor":{"supersedes":["yui2-simpleeditor"],"requires":["yui2-menu","yui2-element","yui2-button"],"type":"js","optional":["yui2-animation","yui2-dragdrop"],"fullpath":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?2.9.0\/build\/editor\/editor-min.js"},"core_filepicker":{"name":"core_filepicker","fullpath":"http:\/\/learn3.open.ac.uk\/lib\/javascript.php?file=%2Frepository%2Ffilepicker.js&rev=729","requires":["base","node","node-event-simulate","json","async-queue","io-base","io-upload-iframe","io-form","yui2-button","yui2-container","yui2-layout","yui2-menu","yui2-treeview","yui2-dragdrop","yui2-cookie"]},"core_dock":{"name":"core_dock","fullpath":"http:\/\/learn3.open.ac.uk\/lib\/javascript.php?file=%2Fblocks%2Fdock.js&rev=729","requires":["base","node","event-custom","event-mouseenter","event-resize"]},"mod_oucontent":{"name":"mod_oucontent","fullpath":"http:\/\/learn3.open.ac.uk\/lib\/javascript.php?file=%2Fmod%2Foucontent%2Fmodule.js&rev=729","requires":["base","node","yui2-dragdrop","yui2-animation","swf"]},"theme_ou":{"name":"theme_ou","fullpath":"http:\/\/learn3.open.ac.uk\/lib\/javascript.php?file=%2Ftheme%2Fou%2Fmodule.js&rev=729","requires":["base","node","dom"]}},"groups":{"moodle":{"name":"moodle","base":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?moodle\/729\/","comboBase":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?","combine":true,"filter":"","ext":false,"root":"moodle\/729\/","patterns":{"moodle-":{"group":"moodle","configFn":moodleConfigFn},"root":"moodle"}},"local":{"name":"gallery","base":"http:\/\/learn3.open.ac.uk\/lib\/yui\/gallery\/","comboBase":"http:\/\/learn3.open.ac.uk\/theme\/yui_combo.php?","combine":true,"filter":"","ext":false,"root":"gallery\/","patterns":{"gallery-":{"group":"gallery","configFn":galleryConfigFn},"root":"gallery"}}}};
M.cfg = {"wwwroot":"http:\/\/learn3.open.ac.uk","sesskey":"6Rnfly9Bfp","loadingicon":"http:\/\/learn3.open.ac.uk\/theme\/image.php?theme=ou&image=i%2Floading_small&rev=730","themerev":"730","theme":"ou","jsrev":"729"};
//]]>
</script>
<script type="text/javascript" src="http://learn3.open.ac.uk/lib/javascript.php?file=%2Flib%2Fjavascript-static.js&amp;rev=729"></script>
<script type="text/javascript" src="http://learn3.open.ac.uk/theme/javascript.php?theme=ou&amp;rev=730&amp;type=head"></script>


<!--NDF: test-related styles. -->
<link rel="stylesheet" href="<?php echo base_url().'application/assets/client/site-embed.css' ?>" />



</head>
<body id="page-mod-oucontent-view" class="<?php echo $body_classes ?> path-mod path-mod-oucontent safari dir-ltr lang-en yui-skin-sam yui3-skin-sam learn3-open-ac-uk pagelayout-standard course-9 context-808 cmid-718 category-2 side-pre-only ou-variant-ouice">
<!--NDF: skiplink fix - keyboard access. -->
<div class="skiplinks"><a class="skip" x-href="#middle-column" href="#maincontent">Skip to main content</a></div>
<script type="text/javascript">
//<![CDATA[
document.body.className += ' jsenabled';
//]]>
</script>

<script type="text/javascript">if (typeof window.ou_sitestat=='function')ou_sitestat();</script>
<div id="ou-org-header">  <a class="ou-link-ou" href="http://www.open.ac.uk/"><img src="<?php echo $resource_url ?>/includes/headers-footers/oulogo-56.jpg" alt="The Open University" /></a>
  <div class="ou-role-nav">
    <ul>
      <li class="ou-role-accessibility"><a href="http://www.open.ac.uk/accessibility/">Accessibility</a></li>
      <li class="ou-role-signin" id="ou-signin1"><a href="https://msds.open.ac.uk/signon/sams001.aspx" id="ou-signin2">Sign in</a></li>
      <li id="ou-signout" class="ou-role-signout"><a href="https://msds.open.ac.uk/signon/samsoff.aspx" id="ou-signout2">/ Sign out</a></li>
      <li id="ou-studenthome" class="ou-role-studenthome"><a href="http://www.open.ac.uk/students/" id="ou-studenthome2">StudentHome</a></li>
      <li id="ou-tutorhome" class="ou-role-tutorhome"><a href="http://www.open.ac.uk/tutorhome/">TutorHome</a></li>
      <li id="ou-intranet" class="ou-role-intranet"><a href="http://intranet.open.ac.uk/">IntranetHome</a></li>
      <li id="ou-sponsor" class="ou-role-sponsor"><a href="https://css2.open.ac.uk/employers/sponsorhome/home/HomePage.aspx">SponsorHome</a></li>
      <li id="ou-contact" class="ou-role-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>
      <li id="ou-search" class="ou-role-search"><a href="http://www.open.ac.uk/search/">Search the OU</a></li>
    </ul>
  </div>
  <div class="ou-ia-nav">
    <ul>
      <li class="ou-ia-home"><a href="http://www.open.ac.uk/">The Open University</a></li>
      <li class="ou-ia-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>
      <li class="ou-ia-research"><a href="http://www.open.ac.uk/research/">Research at the OU</a></li>
      <li class="ou-ia-community"><a href="http://www.open.ac.uk/community/">OU Community</a></li>
      <li class="ou-ia-about"><a href="http://www.open.ac.uk/about/">About the OU</a></li>
    </ul>
  </div>
</div><div id="page"><div id="page-main">
    <div id="page-header">
                    <div class="navbar clearfix">
                <div class="breadcrumb"><span class="accesshide">Page path</span><ul><li><a title="Adult health, social care and wellbeing" href="http://learn3.open.ac.uk/course/view.php?id=9">K217-11B</a></li><li> <span class="accesshide " ><span class="arrow_text">/</span>&nbsp;</span><span class="arrow sep">&nbsp;</span> <a title="Website content" href="http://learn3.open.ac.uk/mod/oucontent/view.php?id=718">Learning Guide 1: Quality of life and wellbeing</a></li><li> <span class="accesshide " ><span class="arrow_text">/</span>&nbsp;</span><span class="arrow sep">&nbsp;</span> <span tabindex="0">Learning Guide 1 resources</span></li></ul></div>
                                <div class="navbutton"> <form action="search.php" method="get"><div><label for="oucontent_searchquery">Search this document</label><span class="helplink"><a href="http://learn3.open.ac.uk/help.php?component=oucontent&amp;identifier=documentsearch&amp;lang=en" title="Help with Search this document" id="helpicon4f8fe369edf0e1"><img src="http://learn3.open.ac.uk/theme/image.php?theme=ou&amp;image=help&amp;rev=730" alt="Help with Search this document" class="iconhelp" /></a></span><input type="hidden" name="id" value="718" /><input type="text" name="query" id="oucontent_searchquery" value="" /><input type="submit" id="ousearch_searchbutton" value="" alt="Search" title="Search" /></div></form></div>
                            </div>
                <div class="clearer"></div>
        <div class="deco13"></div><div class="deco14"></div><div class="deco15"></div>
    </div>
<!-- END OF HEADER -->

    <div id="page-content">


	<!--NDF: warning. -->
	<div id="warn" class="oup-test-warning ouvle">
		<h1>This is a <strong>TEST</strong> VLE page  <sub>(many players)</sub></h1>
		<p>You may need to log in to the <a href="http://learn3.open.ac.uk/mod/oucontent/view.php?id=718&section=4">original page</a>, press browser 'Back' and refresh for the media to work.
		<small>(The page uses <a href="<?php echo $player_url_unenc ?>" title="Audio height: <?php echo $audio_height ?>px, including beige bg.">this media player</a>.)</small>
		<p><small>(Note, the <a href="http://code.google.com/p/chromium/issues/detail?id=37721">skip link is broken in Google Chrome</a> - a known bug :( NDF, April 2012.)</small>
	</div>



                <div id="region-pre" class="block-region">
            <div class="region-content">
                <a href="#sb-1" class="skip-block">Skip Contents</a><div class="block oucontent-contents"><div class="header"><div class="title"><div class="block_action"></div><h2>Contents</h2></div></div><div class="content"><ul><li><a href="view.php?id=718">Overview</a></li><li><a href="view.php?id=718&amp;section=2">This week&#x2019;s activities</a><ul><li><a href="view.php?id=718&amp;section=2.1">Activity 1.1: Basic requirements for life</a></li><li><a href="view.php?id=718&amp;section=2.2">Activity 1.2: Happiness and subjective wellbeing</a></li><li><a href="view.php?id=718&amp;section=2.3">Activity 1.3: Talking about happiness</a></li><li><a href="view.php?id=718&amp;section=2.4">Activity 1.4: The impact of difference and identity on quality of life</a></li><li><a href="view.php?id=718&amp;section=2.5">Activity 1.5: Issues of power and participation in quality of life</a></li><li><a href="view.php?id=718&amp;section=2.6">Activity 1.6: The role of critical practice in quality of life</a></li></ul></li><li><a href="view.php?id=718&amp;section=3">Summary</a></li><li class="oucontent-tree-current"><span class="accesshide">Current section: </span>Learning Guide 1 resources</li><li><a href="view.php?id=718&amp;section=__references">References</a></li></ul></div></div><span id="sb-1" class="skip-block-to"></span><div class="block oucontent-printablelink"><div class="content"><div class="block_action notitle"></div><a href="view.php?id=718&amp;printable=1#section4">Printable version</a></div></div><div id="inst495" class="block_helplink  block"><div class="content"><div class="block_action notitle"></div><a href="http://learn3.open.ac.uk/admin/tool/redirector/redirect.php/22/en/mod/oucontent/view"><img class="iconhelp" alt="Help with this page" title="Help with this page" src="http://learn3.open.ac.uk/theme/image.php?theme=ou&amp;image=docs&amp;rev=730" />Help with this page</a></div></div><a href="#sb-5" class="skip-block">Skip Navigation</a><div id="inst4" class="block_navigation  block"><div class="header"><div class="title"><div class="block_action"></div><h2>Navigation</h2></div></div><div class="content"><ul class="block_tree list"><li class="type_course depth_1 contains_branch"><p class="tree_item branch canexpand navigation_node"><a title="Adult health, social care and wellbeing" href="http://learn3.open.ac.uk/course/view.php?id=9">K217-11B</a></p><ul><li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_16"><span tabindex="0">Resources &amp; forums</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_17"><span tabindex="0">29 Jan</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_18"><span tabindex="0">1</span></p></li>
<li class="type_structure depth_2 contains_branch"><p class="tree_item branch"><span tabindex="0">2</span></p><ul><li class="type_activity depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a title="Website content" href="http://learn3.open.ac.uk/mod/oucontent/view.php?id=717"><img alt="Website content" class="smallicon navicon" title="Website content" src="http://learn3.open.ac.uk/theme/image.php?theme=ou&amp;image=icon&amp;rev=730&amp;component=oucontent" />Block 1: Introduction to exploring health, social ...</a></p></li>
<li class="type_activity depth_3 item_with_icon current_branch"><p class="tree_item leaf hasicon active_tree_node"><a title="Website content" href="http://learn3.open.ac.uk/mod/oucontent/view.php?id=718"><img alt="Website content" class="smallicon navicon" title="Website content" src="http://learn3.open.ac.uk/theme/image.php?theme=ou&amp;image=icon&amp;rev=730&amp;component=oucontent" />Learning Guide 1: Quality of life and wellbeing</a></p></li>
<li class="type_activity depth_3 item_with_icon"><p class="tree_item leaf hasicon"><a title="Forum" href="http://learn3.open.ac.uk/mod/forumng/view.php?id=719"><img alt="Forum" class="smallicon navicon" title="Forum" src="http://learn3.open.ac.uk/theme/image.php?theme=ou&amp;image=icon&amp;rev=730&amp;component=forumng" />
Block 1 Forum</a></p></li></ul></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_19"><span tabindex="0">3</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_20"><span tabindex="0">4</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_21"><span tabindex="0">5</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_22"><span tabindex="0">8</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_23"><span tabindex="0">9</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_24"><span tabindex="0">10</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_25"><span tabindex="0">11</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_26"><span tabindex="0">14</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_27"><span tabindex="0">15</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_28"><span tabindex="0">16</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_29"><span tabindex="0">17</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_30"><span tabindex="0">19</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_31"><span tabindex="0">20</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_32"><span tabindex="0">21</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_33"><span tabindex="0">22</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_34"><span tabindex="0">24</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_35"><span tabindex="0">25</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_36"><span tabindex="0">26</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_37"><span tabindex="0">27</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_38"><span tabindex="0">29</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_39"><span tabindex="0">30</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_40"><span tabindex="0">31</span></p></li>
<li class="type_structure depth_2 collapsed contains_branch"><p class="tree_item branch" id="expandable_branch_41"><span tabindex="0">32</span></p></li></ul></li></ul></div></div><span id="sb-5" class="skip-block-to"></span>            </div>
        </div>
        
        
        <div id="region-main"><div id="region-main-inner">
            <div class="deco1"></div><div class="deco2"></div>
            <div class="region-content">
				<!--NDF: skiplink fix - keyboard access. -->
                <span id="maincontent" name="maincontent"></span><div id="middle-column"><div class='oucontent-prev'><a class="arrow_link" href="view.php?id=718&amp;section=3" title="Previous: Summary"><span class="arrow "></span>&nbsp;<span class="arrow_text">Previous: <strong>Summary</strong></span></a></div><div class="oucontent-content"><h1 class="oucontent-title-1">Learning Guide 1 resources</h1><div class="oucontent-box oucontent-s-heavybox2 oucontent-s-box "><div class="oucontent-outer-box"><h2 class="oucontent-h3 oucontent-nonumber">Audio and video resources</h2><div class="oucontent-inner-box"><h3 class="oucontent-h4 oucontent-basic">Overview</h3><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_lg1_intro_jonl_hq.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_3997610445"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_3997610445").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Overview\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Overview&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_lg1_intro_jonl_hq.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960049" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960049')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960049" id="back_transcript_id394406960049"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_lg1_intro_jonl_hq.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Overview</span></div></div></div><h3 class="oucontent-h4 oucontent-basic">Activity 1.1</h3><div class="oucontent-media oucontent-media-mini"><div class="oucontent-default-filter "><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_vid001_320x176.mp4?forcedownload=1" class="oumedialinknoscript">Download this video clip.</a><span id="filter_video_9612558355"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_video_9612558355").innerHTML = "<iframe tabindex=\"0\" title=\"Video player: Introducing \" width=\"320\" height=\"206\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Video+player%3A+Introducing+&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_vid001_320x176.mp4&amp;width=320&amp;height=206&amp;caption_url=k217_2010j_b1_vid001_320x176.srt<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960094" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960094')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960094" id="back_transcript_id394406960094"></a><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Introducing Trevor and Dahlia</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset1.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_212651557046"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_212651557046").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Basic needs\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Basic+needs&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a001_asset1.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960498" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960498')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960498" id="back_transcript_id394406960498"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset1.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Basic needs</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset2.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_187370458447"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_187370458447").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Lyn\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Lyn&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a001_asset2.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960557" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960557')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960557" id="back_transcript_id394406960557"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset2.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Lyn</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset3.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_29516687948"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_29516687948").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Parminder and Syan\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Parminder+and+Syan&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a001_asset3.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960595" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960595')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960595" id="back_transcript_id394406960595"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset3.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Parminder and Syan</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset4.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_106856404449"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_106856404449").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Dumitru\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Dumitru&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a001_asset4.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960648" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960648')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960648" id="back_transcript_id394406960648"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset4.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Dumitru</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset5.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_24951584250"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_24951584250").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Robert\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Robert&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a001_asset5.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960694" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960694')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960694" id="back_transcript_id394406960694"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a001_asset5.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Robert</span></div></div></div><h3 class="oucontent-h4 oucontent-basic">Activity 1.3</h3><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset1.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_30716457951"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_30716457951").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Trevor and Dahlia\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Trevor+and+Dahlia&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a011_asset1.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960749" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960749')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960749" id="back_transcript_id394406960749"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset1.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Trevor and Dahlia</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset2.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_116744594952"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_116744594952").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Parminder and Syan\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Parminder+and+Syan&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a011_asset2.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960798" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960798')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960798" id="back_transcript_id394406960798"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset2.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Parminder and Syan</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset3.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_110586135253"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_110586135253").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Dumitru\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Dumitru&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a011_asset3.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960824" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960824')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960824" id="back_transcript_id394406960824"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset3.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Dumitru</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset4.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_61063613554"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_61063613554").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Robert\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Robert&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a011_asset4.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960860" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960860')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960860" id="back_transcript_id394406960860"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a011_asset4.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Robert</span></div></div></div><h3 class="oucontent-h4 oucontent-basic">Activity 1.5</h3><div class="oucontent-media oucontent-media-mini"><div class="oucontent-default-filter "><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_vid002_320x176.mp4?forcedownload=1" class="oumedialinknoscript">Download this video clip.</a><span id="filter_video_2910134216"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_video_2910134216").innerHTML = "<iframe tabindex=\"0\" title=\"Video player: Introducing Orchard Hill\" width=\"320\" height=\"206\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Video+player%3A+Introducing+Orchard+Hill&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_vid002_320x176.mp4&amp;width=320&amp;height=206&amp;caption_url=k217_2010j_b1_vid002_320x176.srt<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960898" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406960898')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406960898" id="back_transcript_id394406960898"></a><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Introducing Orchard Hill</span></div></div></div><h3 class="oucontent-h4 oucontent-basic">Activity 1.6</h3><p><b>The rehab assistant</b></p><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1a_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_158098048755"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_158098048755").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 1\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+1&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset1a_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961126" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961126')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961126" id="back_transcript_id394406961126"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1a_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 1</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2a_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_156293016956"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_156293016956").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 2\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+2&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset2a_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961154" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961154')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961154" id="back_transcript_id394406961154"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2a_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 2</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3a_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_130649889357"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_130649889357").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 3\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+3&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset3a_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961181" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961181')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961181" id="back_transcript_id394406961181"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3a_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 3</span></div></div></div><p><b>The care worker</b></p><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1b_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_92107457758"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_92107457758").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 1\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+1&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset1b_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961220" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961220')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961220" id="back_transcript_id394406961220"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1b_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 1</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2b_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_169898139159"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_169898139159").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 2\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+2&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset2b_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961243" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961243')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961243" id="back_transcript_id394406961243"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2b_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 2</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3b_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_121073957760"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_121073957760").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 3\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+3&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset3b_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961287" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961287')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961287" id="back_transcript_id394406961287"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3b_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 3</span></div></div></div><p><b>The social worker</b></p><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1c_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_87265504061"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_87265504061").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 1\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+1&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset1c_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961323" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961323')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961323" id="back_transcript_id394406961323"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1c_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 1</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2c_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_92091231262"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_92091231262").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 2\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+2&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset2c_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961360" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961360')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961360" id="back_transcript_id394406961360"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2c_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 2</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3c_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_39321712763"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_39321712763").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 3\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+3&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset3c_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961387" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961387')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961387" id="back_transcript_id394406961387"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3c_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 3</span></div></div></div><p><b>The GP</b></p><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1d_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_32626389564"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_32626389564").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 1\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+1&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset1d_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961421" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961421')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961421" id="back_transcript_id394406961421"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset1d_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 1</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2d_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_16603960865"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_16603960865").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 2\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+2&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset2d_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961442" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961442')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961442" id="back_transcript_id394406961442"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset2d_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 2</span></div></div></div><div class="oucontent-media" style="width:342px;"><div class="oucontent-default-filter"><span class="oumediafilter"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3d_hi.mp3?forcedownload=1" class="oumedialinknoscript">Download this audio clip.</a><span id="filter_mp3_149220040266"></span></span><script type="text/javascript">
//<![CDATA[
document.getElementById("filter_mp3_149220040266").innerHTML = "<iframe tabindex=\"0\" title=\"Audio player: Part 3\" width=\"342\" height=\"<?php echo $audio_height ?>\" frameborder=\"0\" scrolling=\"no\" style=\"overflow:hidden\" src=\"<?php echo $player_url ?>?title=Audio+player%3A+Part+3&amp;media_url=http%3A%2F%2Flearn3.open.ac.uk%2Fpluginfile.php%2F808%2Fmod_oucontent%2Foucontent%2F103%2Fk217_2010j_b1_a021_asset3d_hi.mp3&amp;width=342&amp;height=30<?php echo $player_param ?>\"><\/iframe>";

//]]>
</script>
</div><div class="oucontent-figure-text"><div class="oucontent-transcriptlink"><a href="<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961463" title="Transcript (opens in new window)" onclick="return oucontentTranscript('<?php echo $transcript_url ?>view.php?id=718&amp;extra=transcript_id394406961463')">Transcript <img src="<?php echo $icon_url ?>newwindow.png" alt="(opens in new window)"/></a></div><a name="transcript_id394406961463" id="back_transcript_id394406961463"></a><div class="oucontent-audiodownloadlink"><a href="http://learn3.open.ac.uk/pluginfile.php/808/mod_oucontent/oucontent/103/k217_2010j_b1_a021_asset3d_hi.mp3?forcedownload=1" title="Download this audio clip">Download</a></div><div class="oucontent-caption oucontent-nonumber"><span class="oucontent-figure-caption">Part 3</span></div></div></div></div></div></div><div class="oucontent-box oucontent-s-heavybox2 oucontent-s-box "><div class="oucontent-outer-box"><h2 class="oucontent-h3 oucontent-nonumber">Websites</h2><div class="oucontent-inner-box"><p>Activity 1.2: <a class="oucontent-hyperlink" href="http://www.neweconomics.org/gen/m1_i1_aboutushome.aspx">The New Economics Foundation</a><span class="oucontent-sidenote oucontent-linktip"><span class="oucontent-sidenote-inner"><span class="accesshide"> [</span>Tip: hold Ctrl and click a link to open it in a new tab. (<a href="hidetip.php?tip=linktip">Hide tip</a>)</span><span class="accesshide">] </span></span>, including their <a class="oucontent-hyperlink" href="http://www.neweconomics.org/gen/well_being_top.aspx">wellbeing resources</a> page</p></div></div></div><div class="oucontent-box oucontent-s-heavybox2 oucontent-s-box "><div class="oucontent-outer-box"><h2 class="oucontent-h3 oucontent-nonumber">Articles and papers</h2><div class="oucontent-inner-box"><p>Activity 1.2: <a class="oucontent-hyperlink" href="http://www.guardian.co.uk/commentisfree/2006/aug/28/comment.mainsection1">&#x2018;Unhappiness is inevitable’ by Paul Moloney</a></p><p>Activity 1.4: <a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.4B+Garner+article" class="oucontent-olink">&#x2018;Considerably better than the alternative: positive aspects of getting older’</a> (Garner, 2009)</p><p>Activity 1.5: <a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.5B+Martin+article" class="oucontent-olink">&#x2018;A real life – a real community: The empowerment and full participation of people with an intellectual disability in their community’</a> (Martin, 2006)</p></div></div></div><div class="oucontent-box oucontent-s-heavybox2 oucontent-s-box "><div class="oucontent-outer-box"><h2 class="oucontent-h3 oucontent-nonumber">Module book</h2><div class="oucontent-inner-box"><p><a href="olink.php?id=718&amp;targetdoc=Book+1+%E2%80%93+Exploring+health%2C+social+care+and+wellbeing" class="oucontent-olink">Book 1, Chapter 1</a></p></div></div></div><div class="oucontent-box oucontent-s-heavybox2 oucontent-s-box "><div class="oucontent-outer-box"><h2 class="oucontent-h3 oucontent-nonumber">Notes documents</h2><div class="oucontent-inner-box"><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.2+%28Task+B%29+notes" class="oucontent-olink">Activity 1.2 Task B</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.2+%28Task+C%29+notes" class="oucontent-olink">Activity 1.2 Task C</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.3+%28Task+A%29+notes" class="oucontent-olink">Activity 1.3</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.4+%28Task+A%29+notes" class="oucontent-olink">Activity 1.4 Task A</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.5+%28Task+A%29+notes" class="oucontent-olink">Activity 1.5 Task A</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG1+Activity+1.5+%28Task+B%29+notes" class="oucontent-olink">Activity 1.5 Task B</a></p><p><a href="olink.php?id=718&amp;targetdoc=K217+LG+Activity+1.6+%28Task+A%29+notes" class="oucontent-olink">Activity 1.6 Task A</a></p></div></div></div></div><div class='oucontent-next'><a class="arrow_link" href="view.php?id=718&amp;section=__references" title="Next: References"><span class="arrow_text">Next: <strong>References</strong></span>&nbsp;<span class="arrow ">&nbsp;</span></a></div></div>            </div>
        </div><div class="clearer"></div></div>

    </div><div class="clearer"></div></div>

<!-- START OF FOOTER -->
        <div id="page-footer" class="clearfix">
        <div class="page-footer-inner"><div class="deco6"></div><div class="deco7"></div><div class="deco8"></div></div><div id="ou-org-footer">



<div class="ou-grid ou-mobile-footer" id="ou-mobile-jlinks"></div>



<div class="ou-grid ou-footer-links">

  <div class="ou-c1of4">

    <ul>

      <li class="ou-title"><a href="http://www.open.ac.uk">The Open University</a></li>

      <li class="ou-copyright">&#169; Copyright <span id="sbyear"></span>. All rights reserved</li>

      <li class="ou-phone">+44 (0) 845 300 60 90</li>

      <li class="ou-email"><a href="http://www.open.ac.uk/email/">Email us</a></li>

      <li class="ou-study"><a href="http://www.open.ac.uk/study/">Study at the OU</a></li>

      <li class="ou-research"><a href="http://www.open.ac.uk/research/">Research</a></li>

      <li class="ou-community"><a href="http://www.open.ac.uk/community/">Community</a></li>

      <li class="ou-about"><a href="http://www.open.ac.uk/about/">About</a></li>

      <li class="ou-accessibility"><a href="http://www.open.ac.uk/about/">Accessibility</a></li>

    </ul>

  </div>

  <div class="ou-c2of4">

    <ul>

    <li class="ou-contact"><a href="http://www.open.ac.uk/contact/">Contact</a></li>

      <li class="ou-search"><a href="http://www.open.ac.uk/search/">Search</a></li>

      <li class="ou-privacy"><a href="http://www.open.ac.uk/privacy/">Website privacy</a></li>

      <li class="ou-copyright"><a href="http://www.open.ac.uk/copyright/">Copyright</a></li>

      <li class="ou-conditions"><a href="http://www.open.ac.uk/conditions/">Conditions of use</a></li>

      <li class="ou-cymraeg"><a href="http://www.open.ac.uk/cymraeg/">Cymraeg</a></li>

      <li class="ou-mobile-enquiries">0845 300 60 90</li>

    </ul>

  </div>

  <div class="ou-c3of4">

    <ul>

      <li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/undergraduate/">Undergraduate</a></li>

      <li class="ou-ia-study"><a href="http://www3.open.ac.uk/study/postgraduate/">Postgraduate</a></li>

      <li class="ou-ia-study ou-ia-research"><a href="http://www.open.ac.uk/research-degrees">Research degrees</a></li>

      <li class="ou-ia-home ou-ia-study"><a href="http://www.open.ac.uk/employers/">Employers</a></li>

      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/the-ou-explained/">OU explained</a></li>

      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/faculties-and-centres/">Faculties and centres</a></li>

      <li class="ou-ia-about"><a href="http://www8.open.ac.uk/about/main/admin-and-governance/">Admin and governance</a></li>

      <li class="ou-ia-about ou-ia-home"><a href="http://www.open.ac.uk/news/">Press Room</a></li>

      <li class="ou-ia-home"><a href="http://www.open.ac.uk/alumni/" class="ou-home">Alumni</a></li>

      <li class="ou-ia-home ou-ia-research ou-ia-about"><a href="http://www.open.ac.uk/jobs/">Jobs</a></li>

      <li class="ou-ia-home"><a href="http://www.open.ac.uk/fundraising/">Donate</a></li>

      <li class="ou-ia-community"><a href="http://www.open.ac.uk/platform/">Platform</a></li>

      <li class="ou-ia-community"><a href="http://www.open.ac.uk/openlearn/">OpenLearn</a></li>

      <li class="ou-ia-community"><a href="http://www.open.ac.uk/facebook/">Facebook</a></li>

      <li class="ou-ia-community"><a href="http://www.open.ac.uk/twitter/">Twitter</a></li>

      <li class="ou-ia-community"><a href="http://www.open.ac.uk/youtube/">YouTube</a></li>

      <li class="ou-ia-learning"><a href="http://www.open.ac.uk/students/">StudentHome</a></li>

      <li class="ou-ia-learning"><a href="http://www.open.ac.uk/skillsforstudy/">Learning Support</a></li>

      <li class="ou-ia-learning"><a href="http://library.open.ac.uk/">Library</a></li>

    </ul>

  </div>

  <div class="ou-c4of4"><!-- reserved --></div>

  </div>

    

</div>



<script type="text/javascript">if (typeof window.ou_init=='function')ou_init();</script>    </div>
    
</div>
<script type="text/javascript" src="http://learn3.open.ac.uk/theme/javascript.php?theme=ou&amp;rev=730&amp;type=footer"></script>
<script type="text/javascript">
//<![CDATA[
M.str = {"repository":{"add":"Add","back":"&laquo; Back","close":"Close","cleancache":"Clean my cache files","copying":"Copying","date":"Date","downloadsucc":"The file has been downloaded successfully","emptylist":"Empty list","error":"An unknown error occurred!","federatedsearch":"Federated search","filenotnull":"You must select a file to upload.","getfile":"Select this file","iconview":"View as icons","invalidjson":"Invalid JSON string","linkexternal":"Link external","listview":"View as list","loading":"Loading...","login":"Login","logout":"Logout","noenter":"Nothing entered","noresult":"No search result","manageurl":"Manage","popup":"Click \"Login\" button to login","preview":"Preview","refresh":"Refresh","save":"Save","saveas":"Save as","saved":"Saved","saving":"Saving","search":"Search","searching":"Search in","size":"Size","submit":"Submit","sync":"Sync","title":"Choose a file...","upload":"Upload this file","uploading":"Uploading...","xhtmlerror":"You are probably using XHTML strict header, some YUI Component doesn't work in this mode, please turn it off in moodle","chooselicense":"Choose license","author":"Author","norepositoriesavailable":"Sorry, none of your current repositories can return files in the required format.","norepositoriesexternalavailable":"Sorry, none of your current repositories can return external files.","nofilesattached":"No files attached","filepicker":"File picker","nofilesavailable":"No files available","overwrite":"Overwrite","renameto":"Rename to","fileexists":"File name already being used, please use another name","fileexistsdialogheader":"File exists","fileexistsdialog_editor":"A file with that name has already been attached to the text you are editing.","fileexistsdialog_filemanager":"A file with that name has already been attached"},"moodle":{"cancel":"Cancel","help":"Help","ok":"OK","error":"Error","info":"Information","viewallcourses":"View all courses","yes":"Yes"},"block":{"addtodock":"Move this to the dock","undockitem":"Undock this item","undockall":"Undock all"},"langconfig":{"thisdirectionvertical":"btt"},"admin":{"confirmation":"Confirmation"}};
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
var navtreeexpansions4 = [{"id":"expandable_branch_1","key":"300095","type":20},{"id":"expandable_branch_2","key":"300084","type":20},{"id":"expandable_branch_3","key":"300078","type":20},{"id":"expandable_branch_4","key":"300018","type":20},{"id":"expandable_branch_5","key":"300013","type":20},{"id":"expandable_branch_6","key":"300012","type":20},{"id":"expandable_branch_7","key":"300088","type":20},{"id":"expandable_branch_8","key":"300011","type":20},{"id":"expandable_branch_9","key":"300010","type":20},{"id":"expandable_branch_10","key":"300075","type":20},{"id":"expandable_branch_11","key":"300093","type":20},{"id":"expandable_branch_12","key":"300069","type":20},{"id":"expandable_branch_13","key":"300068","type":20},{"id":"expandable_branch_14","key":"300094","type":20},{"id":"expandable_branch_15","key":"300085","type":20},{"id":"expandable_branch_16","key":"603","type":30},{"id":"expandable_branch_17","key":"604","type":30},{"id":"expandable_branch_18","key":"605","type":30},{"id":"expandable_branch_19","key":"607","type":30},{"id":"expandable_branch_20","key":"608","type":30},{"id":"expandable_branch_21","key":"609","type":30},{"id":"expandable_branch_22","key":"612","type":30},{"id":"expandable_branch_23","key":"613","type":30},{"id":"expandable_branch_24","key":"614","type":30},{"id":"expandable_branch_25","key":"615","type":30},{"id":"expandable_branch_26","key":"619","type":30},{"id":"expandable_branch_27","key":"620","type":30},{"id":"expandable_branch_28","key":"621","type":30},{"id":"expandable_branch_29","key":"622","type":30},{"id":"expandable_branch_30","key":"624","type":30},{"id":"expandable_branch_31","key":"625","type":30},{"id":"expandable_branch_32","key":"626","type":30},{"id":"expandable_branch_33","key":"627","type":30},{"id":"expandable_branch_34","key":"629","type":30},{"id":"expandable_branch_35","key":"630","type":30},{"id":"expandable_branch_36","key":"631","type":30},{"id":"expandable_branch_37","key":"632","type":30},{"id":"expandable_branch_38","key":"634","type":30},{"id":"expandable_branch_39","key":"635","type":30},{"id":"expandable_branch_40","key":"636","type":30},{"id":"expandable_branch_41","key":"637","type":30}];
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
YUI(M.yui.loader).use('node', function(Y) {
M.util.load_flowplayer();
setTimeout("fix_column_widths()", 20);
M.util.help_icon.add(Y, {"id":"helpicon4f8fe369edf0e1","url":"http:\/\/learn3.open.ac.uk\/help.php?component=oucontent&identifier=documentsearch&lang=en"});
Y.on('domready', function() { Y.use('mod_oucontent', function(Y) { M.mod_oucontent.init(Y, "view", [], {"switch_plus":"http:\/\/learn3.open.ac.uk\/theme\/image.php?theme=ou&image=t%2Fswitch_plus&rev=730"}); }); });
M.yui.galleryversion="2010.04.08-12-35";Y.use("core_dock","moodle-block_navigation-navigation",function() {M.block_navigation.init_add_tree({"id":"4","instance":"4","candock":true,"courselimit":"20","expansionlimit":0});
});
M.yui.galleryversion="2010.04.08-12-35";Y.use("core_dock","moodle-block_navigation-navigation",function() {M.block_navigation.init_add_tree({"id":"5","instance":"5","candock":true});
});
Y.use('theme_ou', function(Y) { M.theme_ou.init(Y); });
M.util.init_block_hider(Y, {"id":"inst4","title":"Navigation","preference":"block4hidden","tooltipVisible":"Hide Navigation block","tooltipHidden":"Show Navigation block"});

});
//]]>
</script>
</body>
</html>
