<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * OUVLE page template.
 *
 * @copyright Copyright 2012 The Open University.
 * @author NDF, 1 May 2012.
 * @link http://learn3.open.ac.uk/mod/oucontent/view.php?id=718&section=4
 */

$input = $this->input;
$body_classes = ' ouvle-test';
$body_classes .= $input->get('edge') ? ' oup-vle-edge' :'';


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
<link rel="stylesheet" href="<?php echo base_url() ?>assets/client/site-embed.css" />




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




<?php echo $content_for_layout ?>




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

	  <!--NDF -->
      <li class="ou-ia-study">...</li>

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
