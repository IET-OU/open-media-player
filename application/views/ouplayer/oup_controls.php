<?php
///Translators: Multimedia (audio/video) player controls.
?>

<div role="toolbar" id="controls" <?php echo _oupc_label('oup-controls oupc', t('Player controls')) ?>>
  <div class="row-1">
    <button id="oup-play-control" <?php echo _oupc_label('play', t('Play')) /*oup-play-control play-pause*/
      ?> data-play-text="<?php echo t('Play')?>" data-pause-text="<?php echo t('Pause')?>"><span>&#x25BA;</span></button>

    <div class="seek group">
      <button <?php echo _oupc_label('back', t('Rewind')) ?>><span>&larr;</span></button>
      <button <?php echo _oupc_label('forward', t('Fast forward')) ?>><span>&rarr;</span></button>

      <input role="timer" <?php echo _oupc_label('time time-out', t('Current time')) ?> readonly value="00:00 / 00:00" x-style="display:none"/>
      <?php /*<span role="timer" <-?=_oupc_label('time time-out', t('Progress')) ?-> >00:00 / 00:00</span>
      <-?php /*<output role="timer" <-?=_oupc_label('x-time time-out offscreen', t('Progress')) ?-> style="display:none;">00:00 / 00:00</output>*/ ?>
    </div>

    <div class="track seek-bar bar" title="Progress bar">
      <span role="progressbar" aria-value-min="0" aria-value-max="100" <?php echo _oupc_label('buffer', t('Loading, please wait')) ?> data-loaded-text="<?php echo t('Loaded') ?>"></span>
      <span role="slider" aria-value-min="0" aria-value-max="<?php echo $meta->duration ?>" <?php echo _oupc_label('progress', t('Seek bar')) ?>></span>
      <div class="playhead head" title="Drag - playhead"><span>D</span></div>
    </div>
	<div class="time-right group">
	  <input role="timer" <?php echo _oupc_label('time-total', t('Total time'))?> readonly value="00:00" x-style="display:none"/>
	  <?php /*<span role="timer" <-?=_oupc_label('time-total', t('Progress')) ?-> >00:00</span>*/ ?>
	</div>
  </div>

  <div class="row-2">
    <div class="volume group">
      <button <?php echo _oupc_label('mute', t('Mute'))?> data-mute-text="<?php echo t('Mute')?>" data-unmute-text="<?php echo t('Unmute')?>"><span>M</span></button>
      <input  <?php echo _oupc_label('volume-out --offscreen', t('Volume'))?> title="<?php echo t('Volume')?>" value="50%" readonly />

      <span class="volume-inner" tabindex="-1">
        <button <?php echo _oupc_label('quieter', t('Quieter')) ?>><span>-</span></button>
        <button <?php echo _oupc_label('louder', t('Louder')) ?>><span>+</span></button> 
        <span class="volume-fg"></span><span class="volume-bg"><span class="vol-bg-inner"></span></span>
      </span>
    </div>

    <div class="volume-bar bar" title="Volume bar">
      <div role="slider" class="volumehead head" title="Drag - volume"><span>D</span></div>
    </div>

<?php /*Semantically a mix of buttons and a few links. But for ease of styling, we use <a>, with role=button. */ ?>
    <div class="tools group">
	<?php if (isset($meta->_related_url)): ?>
      <a target="_blank" href="<?php echo $meta->_related_url ?>" <?php echo _oupc_label('tr related', t('New window: %s', $meta->_related_text)) ?>><span>L</span></a>
	<?php endif; ?>
    <?php if('video'==$meta->media_type): ?>
	<?php ///Translators: Captions - timed-text for the deaf/hard of hearing (sometimes known as Subtitles in British English). ?>
      <a role="button" href="#" <?php echo _oupc_label('tr captn', t('Captions'))?> data-show-text="<?php echo 
	    t('Show captions') ?>" data-hide-text="<?php echo t('Hide captions') ?>"><span>CC</span></a>
    <?php endif; /*Use CSS/javascript to show/hide transcript button. */ ?>
	<?php if (isset($meta->transcript_url)): ?>
	<?php ///Translators: Script or text transcript. ?>
      <a role="button" href="#transcript" <?php echo _oupc_label('tr tscript', t('Show script'))?> data-show-text="<?php echo 
	    t('Show script') ?>" data-hide-text="<?php echo t('Hide script') ?>"><span>T</span></a>
	<?php endif; ?>
    <?php if('embed'==$mode): ?>
	  <a target="_blank" href="<?php echo $popup_url ?>" <?php echo _oupc_label('tr popout', t('New window: %s', t('pop out player'))) ?>
	    data-with-script="<?php echo t('New window: %s', t('pop out player with script')) ?>"><span>PO</span></a>
    <?php endif; ?>
    <?php if('video'==$meta->media_type): ?>
	  <a role="button" href="#" <?php echo _oupc_label('tr fulls', t('Full screen')) ?>><span>F</span></a>
    <?php endif; ?>
	<?php ///Translators: More options - that is, help, embed code, downloads. ?>
      <a role="button" href="#more" <?php echo _oupc_label('tr more', t('More options…')) ?>><span>S</span></a>
	</div>
  </div>
</div>

