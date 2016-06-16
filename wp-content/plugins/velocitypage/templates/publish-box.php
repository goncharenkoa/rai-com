<?php
defined( 'WPINC' ) or die;
?>

<?php if ( true ) : // Current user can publish with VelocityPage ?>
<div class="misc-pub-section misc-pub-velocitypage">
	<img style="vertical-align: middle; position: relative; top: -1px" src="<?php echo $this->get_url(); ?>img/logo-40x40.png" width="20" height="20" /><a style="padding-left: 6px" href="<?php echo $link; ?>">Edit with VelocityPage</a>
</div>
<?php endif; ?>
