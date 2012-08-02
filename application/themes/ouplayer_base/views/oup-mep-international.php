<?php
/**
* Internationalization/ Localization.
* Note, this view is output in the middle of a Javascript object!
*
* See,
*   ouplayer/app/core/MY_Lang.php
*   ouplayer/app/language/ouplayer.pot.po
*/
$lang_ui = $this->lang->lang_code();

?>
  startLanguage:"en", langUI:"<?=$lang_ui ?>", tracksText:"<?=t('Captions') ?>",
  showtracksText:"<?=t('Show captions') ?>",hidetracksText:"<?=t('Hide captions') ?>",
<?php
if ('en' != $lang_ui && 'en-gb' != $lang_ui && 'en-us' != $lang_ui):

  $oup_mep_texts = array(
    //'startLanguage' => 'en', //$params->lang,

    'controlsText' => t('Player controls'),
    '_loadingText' => t('Loading, please wait'),
    '_relatedText' => t('Related link: %s'),

    'playText' => t('Play'),
    'pauseText' => t('Pause'),

    'muteonText' => t('Mute'),
// Accessibility: screen readers pronounce 'Unmute' OK,
//https://docs.google.com/document/d/1nxCbhvBnuKwvnP-pNmLcuOWsfEoQaHcaKLLKurDkej4/edit
// http://en.wiktionary.org/wiki/unmute
    'muteoffText' => t('Unmute'),
    'quieterText' => t('Quieter'),
    'louderText' => t('Louder'),
    'volumeText' => t('Volume'),

    'showscriptText' => t('Show script'),
    'hidescriptText' => t('Hide script'),
    //'tracksText' => t('Captions'), //"Subtitles" [en-GB]; "Captions" [en-US]

    'progressText' => t('Seek bar'),
    '_timeText' => t('Time'), //.mejs-time-float-current
    'currentText' => t('Current time'),
    'durationText' => t('Total time'),

    'qualityText' => t('Quality'),
    'qualityhighText'=> t('High definition'),
    'qualitylowText' => t('Standard definition'),
    'popoutText' => t('Pop out player'),
    // Accessibility: add more detail via aria-label attribute (WAI-ARIA).
    'popoutlabelText' => t('Pop out player') .', '. t('opens in new window'),
    '_newwindowText' => t('New window: %s'),
    'fullscreenText' => t('Full screen'),
    'optionsText' => t('More options…'), #Or settings
  );

/*if ('my' == $params->lang) {
  foreach ($oup_mep_texts as $key => $val) {
	if ('startLanguage'!=$key) $oup_mep_texts[$key] .= ' **';
  }
}*/


  echo json_encode_bare($oup_mep_texts) .',';
endif;
