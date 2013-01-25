<?php
/** LAMS oEmbed view.

--Get image, author, date, tags.

TODO: scale the image.

/w/ouplayer/oembed?callback=C&format=json&url=http%3A//lamscommunity.org/lamscentral/sequence%3Fseq_id=1007900
*/
// Dimensions in pixels.
  $img_width = 550;
  #$img_height= 400;
  $img_height= round($meta->thumbnail_height / $meta->thumbnail_width * $img_width);

  $base_url = base_url();
  //$tracker = $this->CI->oembed->_track();

  //classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
#License: http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png
#http://dolly.lamscommunity.org/lams/learning/mainflash.jsp?lessonID=6758&amp;portfolioEnabled=true&amp;presenceEnabledPatch=false&amp;presenceImEnabled=false&amp;presenceUrl=localhost&amp;createDateTime=2010-09-16%2006:08:39.0&amp;title=preview&amp;mode=preview

    // Note, use of RDFa, based on http://creativecommons.org/choose/
    // Note, SVG-iframe is a problem in MSIE 7 (display) & Safari (scale).
    //$html =<<<EOF
    ob_start();

    ?>
<link class='LAMS-css' rel='stylesheet' href='<?php echo $base_url ?>assets/services/lams.css' /><style>
<?php /*MSIE 7: @import url(<?php echo $base_url ?>assets/services/lams.css);*/ ?>
.lams.embed-rsp .seq object, .lams.embed-rsp .seq img{width:<?php echo $img_width ?>px; height:<?php echo $img_height ?>px;}
</style><div class='lams embed-rsp' about='<?php echo $url ?>' xmlns:dct='http://purl.org/dc/terms/' xmlns:cc='http://creativecommons.org/ns#' xmlns:bz='http://digitalbazaar.com/media/'><div class="head">
<?php ///Translators: LAMS, Learning Activity Management System. ?>
 <a class="logo" href="http://lamscommunity.org/" rel='dct:publisher' property='dct:publisher' content='LAMS'><img alt="<?php echo t('LAMS community') ?>" title="<?php echo t('LAMS community') ?>" src="http://lamscommunity.org/images/lams_logo.gif" /></a>
 <h3 href="http://purl.org/dc/dcmitype/StillImage" property="dct:title" rel="dct:type"><?php echo $meta->title ?></h3>
 <?php echo t('By: %s', '')?><a class="xp-popup" property="cc:attributionName" rel="cc:attributionURL"
 data-xp-width="1124" data-xp-height="700"
 href="<?php echo $meta->author_url ?>" target="lams-win"
 title="<?php echo t('Open in new window') ?>"><?php echo $meta->author ?><?php /*<span>, <-?=t('Open in new window') ?-></span>*/ ?></a> &nbsp;
 <?php echo t('License: %s', '')?><a rel="license" class="cc-by-nc-sa"
 href="http://creativecommons.org/licenses/by-nc-sa/2.0/"
 title="Creative Commons Attribution-NonCommercial-ShareAlike 2.0 Unported License"><?php echo t('Creative Commons License') ?></a>
 </div>
 <p class="seq"><?php /*MSIE: <object type="image/svg+xml" data="<?php echo $meta->_svg_url ?>">*/ ?>
  <img alt="<?php echo t('The LAMS sequence.') ?>" src="<?php echo $meta->thumbnail_url ?>" />
 <?php /*</object>*/ ?></p>
 <a class="xp-popup zoom btn" data-xp-width="780" data-xp-height="298" target="lams-win" rel="bz:download"
 href="<?php echo $meta->thumbnail_url ?>"
 title="<?php echo t('Open in new window') ?>"><?php echo t('Zoom<s>, new window') ?></span><!--764+15, 241+55--></a>
 <p class="foot">
| <a class="xp-popup button" href=
"http://lamscommunity.org/lamscentral/preview?ld_id=<?php echo $meta->_preview_id ?>" title="<?php echo t('Open in new window') ?>"><?php echo t('Preview<s>, new window') ?></span></a>
| <a class="xp-popup button" href="http://lessonlams.com/lams/cloud/import.do?sequenceLocation=http://lamscommunity.org/seqs/<?php echo $meta->_seq_id ?>.zip" title="<?php echo t('Open in new window') ?>"
 ><?php echo t('Open in Lesson LAMS<s>, new window') ?></span></a>
| <a class="xp-popup button details" rel="dct:source"
 data-xp-width-0="1124" data-xp-height="700" data-xp-resizable=1 data-xp-scrollbars=1 
 href="http://lamscommunity.org/lamscentral/sequence?seq_id=<?php echo $meta->_seq_id ?>"
 target="_blank" title="<?php echo t('Open in new window') ?>"
 ><?php echo t('Full Info<s>, new window') ?></span></a>
|  <a class="svg button" href="<?php echo $meta->_svg_url ?>" rel='bz:download'><abbr title="<?php echo t('Scalable Vector Graphic') ?>">SVG</abbr></a>
|</p>
<?php echo $tracker ?></div>
<?php
    $html = ob_get_clean();
//EOF;

    $oembed = array(
        'version'=> '1.0',
        'type'   => 'rich',
        'provider_name'=> 'LAMS Community',
        'provider_url' => "http://lamscommunity.org/",
        'title'  => $meta->title,
        'author_name'=>$meta->author,
        'author_url' =>$meta->author_url,
        'html'   => $html,
        'thumbnail_url'=> $meta->thumbnail_url,
        'thumbnail_width' =>$meta->thumbnail_width,
        'thumbnail_height'=>$meta->thumbnail_height,
        '__seq_id' => $meta->_seq_id,
        '__svg_url' => $meta->_svg_url,
        #'dc:date'=> $meta->timestamp ? date('c', $meta->timestamp) : null,
        #'license_url'  => null,
  );

  $view_data = array(
      'url'   => $url,
      'format'=> $format,
      'callback'=>$callback,
      'oembed' =>$oembed,
  );
  $this->load->view('oembed/render', $view_data);

/* http://creativecommons.org/choose/

<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"
 ><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a> <br />
 <span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/StillImage" property="dct:title" rel="dct:type">LAMS Sequence: Crimefighting with Maths</span>
 by <a xmlns:cc="http://creativecommons.org/ns#" href="http://lamscommunity.org/lamscentral/sequence-by-user?user_id=959067" property="cc:attributionName" rel="cc:attributionURL">Joanne Withnall</a>
 is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Attribution-ShareAlike 3.0 Unported License</a>.<br />
 Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="http://lamscommunity.org/seqs/svg/1007900.png" rel="dct:source">lamscommunity.org</a>. <br />
 Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="http://lamscommunity.org/lamscentral/sequence?seq_id=1007900#perms" rel="cc:morePermissions">http://lamscommunity.org/lamscentral/sequence?seq_id=1007900#perms</a>.
*/
