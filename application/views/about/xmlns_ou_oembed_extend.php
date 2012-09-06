
<h2>oEmbed Extend namespace</h2>

<p>The namespace <code style="font-size:medium"><?php echo XMLNS_OU_OEMBED_EXTEND ?></code>
is intended for use in various Open University projects which employ <a href="http://oembed.com/">oEmbed</a>.

<h3>XML namespace</h3>
<pre>

	<strong><?php echo XMLNS_OU_OEMBED_EXTEND ?></strong>

</pre>

<p>Your request:
<pre>
	<?php echo XMLNS_OU_OEMBED_EXTEND ?><strong id=DL-hash></strong>


</pre>
<script>
(function () {
	var D = document;
	if (D.location.hash) {
		D.getElementById('DL-hash').innerHTML = D.location.hash.replace(/#/, '');
	}
})();
</script>



<p>Example usage:
<pre id=Example>
  &lt;?xml version="1.0" encoding="utf-8"?>
  &lt;oembed
    xmlns:ex="<strong><?php echo XMLNS_OU_OEMBED_EXTEND ?></strong>"
    >
    &lt;version>1.0&lt;/version>
    &lt;<strong>ex</strong>:custom_path>!labspace.open.ac.uk!Learning_to_L..&lt;/<strong>ex</strong>:custom_path>
    ...
  &lt;/oembed>

</pre>


<p>What is an XML Namespace? 
<a href="http://w3.org/TR/REC-xml-names/#abstract">World Wide Web Consortium Recommendation</a> | <a href="http://en.wikipedia.org/wiki/XML_namespace">Wikipedia</a>.


<p>This XML namespace is, or will be used by these Open University projects:
  <a href="<?php echo site_url('demo/ouldi') ?>">OU Embed</a>,
  iSpot-oEmbed,
  Track OER (<a href="http://track.olnet.org/oembed?url=http%3A%2F%2Flabspace.open.ac.uk%2FLearning_to_Learn_1.0&format=xml">Track OER XML</a>).

<p>



