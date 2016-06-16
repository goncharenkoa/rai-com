<?php
defined( 'WPINC' ) or die;
?>

<script type="text/html" id="tmpl-controls-item-area">
<a href="#" class="vp-add"><i class="fa fa-plus"></i> add item</a>
</script>

<script type="text/html" id="tmpl-controls-row-area">
<a href="#" class="vp-add"><i class="fa fa-plus"></i> add row</a>
</script>

<script type="text/html" id="tmpl-controls-item">
<vp-control-column>
	<a href="#" title="Grab to move" class="vp-sort-handle"><i class="fa fa-bars"></i></a>
	<# if ( _.contains( ['shortcode', 'media', 'html', 'mailchimp', 'aweber', 'image'], data.slug ) ) {#>
		<a href="#" class="vp-edit"><i class="fa fa-edit"></i></a>
	<# } #>
</vp-control-column>
<div class="vp-more">
	<vp-control-row>
		<a href="#" title="Remove" class="vp-remove"><i class="fa fa-trash-o"></i></a>
		<# if ( _.contains( ['h1', 'h2', 'h3', 'h4'], data.slug ) ) { #>
			<a href="#" title="Change item type" class="vp-change"><i class="fa fa-th-large"></i></a>
		<# } else if ( data.slug === 'image' ) { #>
			<a href="#" title="Link image" class="vp-link"><i class="fa fa-link"></i></a>
		<# } #>
		<# if ( _.contains( ['h1', 'h2', 'h3', 'h4', 'image'], data.slug ) ) { #>
			<vp-control-row-group>
				<a href="#" title="Align left" class="vp-align" data-align="left"><i class="fa fa-align-left"></i></a>
				<a href="#" title="Align center" class="vp-align" data-align="center"><i class="fa fa-align-center"></i></a>
				<a href="#" title="Align right" class="vp-align" data-align="right"><i class="fa fa-align-right"></i></a>
			</vp-control-row-group>
		<# } #>
	</vp-control-row>
</div>
</script>

<script type="text/html" id="tmpl-controls-row">
<vp-control-column>
	<a href="#" title="Grab to move" class="vp-sort-handle"><i class="fa fa-bars"></i></a>
</vp-control-column>
<div class="vp-more">
	<vp-control-row>
		<a href="#" class="vp-remove"><i class="fa fa-trash-o"></i></a>
		<a href="#" title="Change item type" class="vp-change"><i class="fa fa-th-large"></i></a>
		<a href="#" title="Switch style" class="vp-switch-style"><i class="fa fa-random"></i></a>
	</vp-control-row>
</div>
</script>
