<?php
defined( 'WPINC' ) or die;
$current_theme = get_post_meta( $post->ID, $this->meta_key( 'theme' ), true );
$enabled = !! get_post_meta( $post->ID, $this->meta_key( 'enabled' ), true );
?>
<div class="alignleft">
	<input type="radio" id="<?php echo self::DASHED_PREFIX; ?>enabled" name="<?php echo self::PREFIX; ?>enabled" value="1" <?php checked( $enabled ); ?> /> <label for="<?php echo self::DASHED_PREFIX; ?>enabled"><?php _e( 'Enabled', 'velocitypage' ); ?></label>
</div>
<div class="alignright">
	<input type="radio" id="<?php echo self::DASHED_PREFIX; ?>disabled" name="<?php echo self::PREFIX; ?>enabled" value="0" <?php checked( ! $enabled ); ?> /> <label for="<?php echo self::DASHED_PREFIX; ?>disabled"><?php _e( 'Disabled', 'velocitypage' ); ?></label>
</div>
<div class="clear"></div>
<p><?php _e( '<b>Note</b>: When VelocityPage is enabled, this page&#8217;s existing WordPress content will be ignored.', 'velocitypage' ); ?></p>

<p><?php _e( 'Theme:' ); ?> <select id="<?php echo self::DASHED_PREFIX; ?>theme" name="<?php echo self::PREFIX; ?>theme">
	<option value="user-theme" <?php selected( 'user-theme', $current_theme ); ?>>Use existing theme</option>
	<?php foreach ( $this->get_themes() as $theme ) : ?>
	<option value="<?php echo $theme->slug; ?>" <?php selected( $theme->slug, $current_theme ); ?>><?php echo $theme->name; ?></option>
	<?php endforeach; ?>
</select></p>