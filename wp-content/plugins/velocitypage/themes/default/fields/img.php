<?php defined( 'WPINC' ) or die; ?>
<?php if ( $this->doing_js() ) : ?>
	<vp-image-link>
		<input type="text" value="{{data.url}}" placeholder="Enter URL here" />
	</vp-image-link>
	<vp-image style="<# if ( data.width ) { #>width: <?php $this->render_value('width'); ?>px;<# } if ( data.height ) { #> height: <?php $this->render_value('height'); ?>px;<# } #>">
	<# if ( data.value === '' ) { #>
		<div class="vp-choose-image"><a href="#"><?php _e( 'Choose image', 'velocitypage' ); ?></a></div>
	<# } else { #>
		<img src="<?php $this->render_value('value'); ?>" />
	<# } #>
	</vp-image>
<?php else : ?>
	<?php if ( $this->get_value('url') ) : ?>
		<a href="<?php $this->render_value( 'url' ); ?>">
	<?php endif; ?>
	<img src="<?php $this->render_value('value'); ?>" <?php if ( $this->get_value('height') ) { ?>height="<?php $this->render_value('height'); ?>" <?php } if ( $this->get_value('width') ) { ?>width="<?php $this->render_value('width'); ?>" style="width: <?php $this->render_value('width'); ?>px;"<?php } ?> />
	<?php if ( $this->get_value('url') ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>
