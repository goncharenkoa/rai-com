<?php defined( 'WPINC' ) or die; ?>

<?php if ( $this->doing_js() ) { ?>
<ul class="vp-choose-type<# if ( data.oldModelFields ) { #> vp-switching-types<# } #>">
<?php foreach ( $this->plugin->items as $slug => $item ) { ?>
	<?php if ( 'chooser' === $slug ) continue; ?>
	<?php if ( 'image' === $slug && $this->plugin->demo && ! $this->plugin->can_edit ) continue; ?>
	<li<?php echo in_array( $slug, array( 'h1', 'h2', 'h3', 'h4' ) ) ? '' : ' class="vp-new-only"'; ?>><a href="#" class="vp-choose-type" data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $item['nicename'] ); ?></a></li>
<?php } ?>
</ul>
<?php } ?>