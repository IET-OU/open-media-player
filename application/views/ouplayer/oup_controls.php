<div id="oup-controls" role="toolbar" aria-label="<?=t('Player controls')?>" class="hulu">
<!-- These events will be attached unobtrusively!! -->
<button
  class="play oup-play-control" <?php /*onmouseover="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onmouseout="OUP.delayhidetip()"
  onfocus="OUP.fixedtooltip(this.getAttribute('aria-label'), this, event)"
  onblur="OUP.delayhidetip()" */
  //Play video ?  ?>
  aria-label="<?=t('Play')?>"
  data-play-text="<?=t('Play')?>" data-pause-text="<?=t('Pause')?>"><span>P</span></button>
<div class="oupc-r1">
 <button class="back" aria-label="<?=t('Rewind')?>">&lt;</button>
 <div class="sl track">
  <span class="sl buffer"></span>
  <span class="sl progress"></span>
  <span class="sl playhead"></span>
 </div>
 <button class="forward" aria-label="<?=t('Fast forward')?>">&gt;</button>
 <span class="time" aria-label="<?=t('Progress')?>"></span>
 <input class="x-time" readonly style="display:none" />
</div>
<div class="oupc-r2">
 <button class="mute" aria-label="<?=t('Mute')?>"
  data-mute-text="<?=t('Mute')?>" data-unmute-text="<?=t('Unmute')?>">mute</button>
 <button class="louder"  aria-label="<?=t('Louder')?>">+</button>
 <button class="quieter" aria-label="<?=t('Quieter')?>">&ndash;</button>
 <input class="x-volume" readonly aria-label="<?=t('Volume')?>" style="display:none" />

 <button class="captn" aria-label="<?=t('Captions')?>">CC</button>
 <button class="script" aria-label="<?=t('Show script')?>"
  data-show-text="<?=t('Show script')?>" data-hide-text="<?=t('Hide script')?>">T</button>

 <a href="<?=$meta->_related_url ?>" target="_blank" class="related" aria-label="<?=t('New window: related link…')?>">rel</a>
 <a href="#" target="_blank" class="popout" aria-label="<?=t('New window: pop out player')?>">pop</a>
 <button class="fulls" aria-label="<?=t('Full screen')?>">F</button>
 <button class="more" aria-label="<?=t('More&hellip;')?>">more</button>
</div>
</div>
