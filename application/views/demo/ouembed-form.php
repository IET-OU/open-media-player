<?php
  //$url = $this->input->get('url');

?>
<style>
.ouembed-form{ font-size:1.05em; }
.ouembed-form input{ font-size:1.2em; padding:.7em 4px; background:#ddd; color:#333; border:1px solid #d0d0d0; margin:0; }
input#url{ background:#f8f8f8; border-right-width:0 }
input#url:focus{ box-shadow:0 0 20px #d0d0d0; background:#fff; }
input[type=submit]{ cursor:pointer; padding:.7em; }
.ouembed-form input[type=submit]:hover{ background:#e8e8e8; }
#examples li{ margin:3px 0; width:60%; white-space:nowrap; overflow: hidden; text-overflow:ellipsis; /*#1388, truncate too-long titles..*/ }
#X-oembed-out{ border-left:1px solid #bbb; padding-left:5em;
 position:relative; left:30em; top:-10em; z-index:999; }
#oembed-out{ margin:1em auto; }
</style>


<div class=ouembed-form>

<form id=form>
  <p><label for=url>URL to embed </label>
  <p><input id=url name=url type=url required value="<?php echo $url ?>" size=90 maxlength=140 placeholder="<?php echo array_pop(array_slice($examples, 0, 1)) ?>"
  /><input type=submit />
</form>


<ul id=examples>
<?php foreach ($examples as $example_name => $example_url): ?>
  <li><a href=
"?url=<?php echo urlencode($example_url) ?>"
title="<?php echo $example_name ?> (<?php echo strlen($example_url) ?>)"
><?php echo $example_url ?></a>
<?php endforeach; ?>
</ul>

</div>

<div id=oembed-out>
<?php if ($url): ?>
<a class=embed href="<?php echo $url ?>"><?php echo $url ?></a>
<?php endif; ?>
</div>

