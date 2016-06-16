<?php defined( 'WPINC' ) or die; ?>

<?php if ( $this->doing_js() ) : ?>
	<# if ( data.editing ) { #>
		<textarea class='vp-shortcode'>{{ data.value }}</textarea>
	<# } else if ( data.html ) { #>
		{{{data.html}}}
	<# } else { #>
		{{{data.value}}}
	<# } #>
<?php else : ?>
	<?php $this->render_field(); ?>
<?php endif; ?>
