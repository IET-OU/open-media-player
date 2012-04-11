<?php
/**
* Internationalization/Localization.
*
* See,
*   ouplayer/app/core/MY_Lang.php
*   ouplayer/app/language/ouplayer.pot.po
*/


$oup_mep_texts = array(
  'startLanguage' => 'en', //$params->lang,

  'controlsText' => t('Player controls'),
  '_loadingText' => t('Loading, please wait'),
  '_relatedText' => t('Related link: %s'),

  'playText' => t('Play'),
  'pauseText' => t('Pause'),

  'muteonText' => t('Mute'),
  'muteoffText' => t('Un mute'),
  'quieterText' => t('Quieter'),
  'louderText' => t('Louder'),
  'volumeText' => t('Volume'),

  'showscriptText' => t('Show script'),
  'hidescriptText' => t('Hide script'),
  'tracksText' => t('Captions'), //"Subtitles" [en-GB]; "Captions" [en-US]

  'progressText' => t('Seek bar'),
  '_timeText' => t('Time'), //.mejs-time-float-current
  'currentText' => t('Current time'),
  'durationText' => t('Total time'),

  'qualityText' => t('Quality selection/ High definition'),
  'popoutText' => t('New window: %s').t('pop out player'),
  'fullscreenText' => t('Full screen'),
  'optionsText' => t('More options…'),
);

/*if ('my' == $params->lang) {
  foreach ($oup_mep_texts as $key => $val) {
	if ('startLanguage'!=$key) $oup_mep_texts[$key] .= ' **';
  }
}*/

$texts_json = json_encode($oup_mep_texts);

echo trim($texts_json,  '{}') .',';
