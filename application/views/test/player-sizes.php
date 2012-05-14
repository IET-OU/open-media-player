<?php
#
# OU Podcast player size test/ demo.
#
#https://docs.google.com/document/d/1zgycCtBTcph7O4wwXAQtQq0jtXoJ3eKnSxKnNr6VRPU/edit
#

  $video_player_sizes = array(
    'x-small'=> array('width'=>295, 'height'=>166, 'note'=>'(suitable for OUICE site side bars)'),
    'small'  => array('width'=>480, 'height'=>270),
    'medium' => array('width'=>560, 'height'=>315),
    'large'  => array('width'=>640, 'height'=>360),
    'x-large'=> array('width'=>848, 'height'=>480),
  );
?>


<h2>OU Podcast video player sizes</h2>

<?php foreach ($video_player_sizes as $label => $dim): ?>

  <p><?php echo ucfirst($label) ?> player: <?php echo $dim['width'] ?> × <?php echo $dim['height'] ?> pixels
  <?php echo isset($dim['note']) ?  $dim['note'] :'' ?>

  <p><iframe
   class="ouplayer video" frameborder="0" allowfullscreen webkitallowfullscreen
   width="<?php echo $dim['width'] ?>" height="<?php echo $dim['height'] ?>"
   src="<?php echo site_url('embed/pod/student-experiences/db6cc60d6b') ?>"
  ></iframe>

<?php endforeach; ?>


<pre>


N.D.Freear, 2012-05-14.

* https://docs.google.com/document/d/1zgycCtBTcph7O4wwXAQtQq0jtXoJ3eKnSxKnNr6VRPU/edit

