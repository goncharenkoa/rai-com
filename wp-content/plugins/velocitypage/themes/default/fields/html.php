<?php defined( 'WPINC' ) or die; ?>

<?php if ( $this->doing_js() ) : ?>
	<# if ( data.editing ) { #>
		<textarea class='vp-html'>{{ data.value }}</textarea>
	<# } else { #>
		{{{data.value}}}
	<# } #>
<?php else : ?>
	<?php $this->render_field(); ?>
<?php endif; ?>
