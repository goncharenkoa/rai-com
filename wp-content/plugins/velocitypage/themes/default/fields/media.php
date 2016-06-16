<?php defined( 'WPINC' ) or die; ?>

<?php if ( $this->doing_js() ) : ?>
	<# if ( data.editing ) { #>
		<textarea class='vp-media'>{{ data.value }}</textarea>
	<# } else { #>
		{{{data.html}}}
	<# } #>
<?php else : ?>
	<?php $this->render_field(); ?>
<?php endif; ?>
