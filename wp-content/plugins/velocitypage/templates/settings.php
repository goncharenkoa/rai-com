<?php defined( 'WPINC' ) or die; ?>

<script>
(function(){
	if ( window.history && window.history.replaceState ) {
		window.history.replaceState( {}, '', window.location.toString().replace( /&message=([^&]*)/, '' ) );
	}
})();
</script>
<div class="wrap">
	<h2><?php _e( 'VelocityPage Settings', 'velocitypage' ); ?></h2>
	<?php if ( isset( $message ) && isset( $message_type ) ) { ?>
		<div class="<?php echo $message_type; ?>"><p><?php echo $message; ?></p></div>
	<?php } ?>
	<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>">
		<input type="hidden" name="action" value="<?php echo self::DASHED_PREFIX; ?>save" />
		<?php wp_nonce_field( self::PREFIX . 'save' ); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php _e( 'License Key', 'velocitypage' ); ?>
					</th>
					<td>
						<?php $client_site = !! preg_match( '#-client$#', $license ); ?>
						<input id="<?php echo self::PREFIX; ?>license_key" name="<?php echo self::PREFIX; ?>license_key" type="<?php echo $client_site ? 'hidden' : 'text'; ?>" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
						<?php if ( ! $client_site ) : ?>
						<label class="description" for="<?php echo self::PREFIX; ?>license_key"><?php _e( 'Enter your license key', 'velocitypage' ); ?></label>
						<?php endif; ?>
						<?php if ( $license ) : ?>
						<?php if ( ! $client_site ) { ?><br /><?php } ?>
						<input type="submit" name="<?php echo self::PREFIX; ?>deactivate" value="Deactivate site" class="button button-secondary" />
					<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
		<p><?php _e( 'Don&#8217;t have a license key? Go to <a href="http://velocitypage.com/">VelocityPage.com</a> to purchase one now!', 'velocitypage' ); ?></p>
		<?php submit_button(); ?>

	</form>

	<h2><?php _e( 'Using VelocityPage', 'velocitypage' ); ?></h2>
	<ol>
		<li><?php printf( __( '<a href="%s">Create a Page</a> in WordPress (optional).', 'velocitypage' ), admin_url( 'post-new.php?post_type=page' ) ); ?></li>
		<li><?php _e( 'View that page (or any existing page) on the front of your site.', 'velocitypage' ); ?></li>
		<li><?php printf( __( 'Click the &#8220;%s Edit&#8221; button in the upper right of your screen.', 'velocitypage' ), '<img width="15" height="15" src="' . $this->get_url() . 'img/logo-40x40.png" style="vertical-align: middle" />' ); ?></li>
		<li><?php _e( 'Select a theme (or choose to use your existing theme) and then click &#8220;Edit&#8221;.', 'velocitypage' ); ?></li>
		<li><?php _e( 'You&#8217;re now editing with VelocityPage!', 'velocitypage' ); ?></li>
	</ol>

	<p><?php printf( __( 'You can view full instructions <a href="%s">on our website</a>.', 'velocitypage' ), 'http://velocitypage.com/getting-started-with-velocitypage/' ); ?></p>

</div>