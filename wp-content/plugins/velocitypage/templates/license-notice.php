<?php defined( 'WPINC' ) or die; ?>
<?php if ( isset( $message ) && isset( $message_type ) ) { ?>
	<style>
		div.velocitypage-notice {
			background-image: url('<?php echo $this->get_url() . 'img/logo-64x64.png'; ?>');
			background-position: 5px 50%;
			background-repeat: no-repeat;
			background-size: 32px 32px;
			padding-left: 42px !important;
		}
	</style>
	<div class="velocitypage-notice <?php echo $message_type; ?>"><p><?php echo $message; ?></p></div>
<?php } ?>
