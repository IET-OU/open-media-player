<?php

  //$url = $this->input->get('url');

?>
<style>
#oembed-form input{ font-size:1em; padding:3px; }
#X-oembed-out{ border-left:1px solid #bbb; padding-left:5em;
 position:relative; left:30em; top:-10em; z-index:999; }
</style>

<form id=oembed-form>
  <p><label for=url>URL to embed </label>
  <p><input id=url name=url type=url value="<?php echo $url ?>" size=60 />
  <p><input type=submit />

</form>

<ul>
  <li><a href=
"?url=http://dl.dropbox.com/u/9130126/CompendiumLD/test8.svg%23!CompendiumLD=1&width=640&height=620"
>http://dl.dropbox.com/u/9130126/CompendiumLD/test8.svg</a>
</ul>


<p id=oembed-out>
<?php if ($url): ?>
<a class=embed href="<?php echo $url ?>">Test</a>
<?php endif; ?>
</p>

