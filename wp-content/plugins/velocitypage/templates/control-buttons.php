<?php
defined( 'WPINC' ) or die;
?>

<?php if ( $this->transitioning || $this->enabled ) : ?>
<ul class="vp-quick-controls">
	<li class="vp-start-page"><a href="#">Edit</a></li>
	<li class="vp-save-page"><a href="#">Save</a></li>
</ul>
<?php endif; ?>

<div class="vp-page-controls">
	<div class="vp-message" style="display: none"></div>

	<?php // START transition template ?>
	<div style="display:none" class="vp-panel vp-transition-panel">
		<div class="vp-panel-cancel"><a href="#"><?php _e( 'cancel' ); ?></a></div>
		<h1><?php _e( 'Choose a Template', 'velocitypage' ); ?></h1>
		<div class="vp-panel-body">
			<div class="vp-panel-section">
				<h2><?php _e( 'Current WordPress Theme', 'velocitypage' ); ?></h2>
				<ul>
					<?php foreach ( $this->get_layouts() as $layout ) : ?>
						<li><a href="<?php echo remove_query_arg( 'vp-instant-transition', add_query_arg( array( 'vp-transition' => 'user-theme', 'vp-layout' => $layout->slug ) ) ); ?>"><img width="100" height="100" src="<?php echo $this->get_url(); ?>img/layouts/<?php echo $layout->slug; ?>.png" /><span><?php echo $layout->name; ?></span></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="vp-panel-section">
				<h2><?php _e( 'VelocityPage Templates', 'velocitypage' ); ?></h2>
				<ul>
				<?php foreach ( $this->get_themes() as $theme ) : ?>
					<li><a href="<?php echo remove_query_arg( 'vp-instant-transition', add_query_arg('vp-transition', $theme->slug ) ); ?>"><img width="100" height="100" src="<?php echo $this->get_theme_dir_url() . $theme->slug; ?>/screenshot.jpg" /><span><?php echo $theme->name; ?></span></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<div class="vp-panel-section">
				<p><b>Note:</b> Your page will reopen and you will be able to edit it with VelocityPage. Your public page <em>will not change</em> until you press "save".</p>
			</div>
		</div>
	</div>
	<?php // END transition template ?>


	<?php // START addnew template ?>
	<div style="display:none" class="vp-panel vp-addnew-panel">
	<form method="post" action="">
		<input type="hidden" name="vp-action" value="addnew" />
		<div class="vp-panel-cancel"><a href="#"><?php _e( 'cancel' ); ?></a></div>
		<h1><?php _e( 'Add New VelocityPage', 'velocitypage' ); ?></h1>
		<div class="vp-panel-body">
			<div class="vp-panel-section">
				<h2><?php _e( 'Choose a name', 'velocitypage' ); ?></h2>
				<p><input class="vp-addnew-title" name="vp-addnew-title" type="text" /></p>
				<h2><?php _e( 'Parent page', 'velocitypage' ); ?></h2>
				<script>var vpAllPageURLs = <?php echo $this->get_page_url_json(); ?>;</script>
				<p><?php wp_dropdown_pages(array( 'name' => 'vp-page-parent', 'id' => 'vp-page-parent', 'show_option_none' => __( '— none —', 'velocitypage' ), 'option_none_value' => '0' )); ?></p>
				<p class="vp-addnew-url" style="display:none"><?php echo trailingslashit(home_url('/')); ?><span></span></p>
				<p><button role="submit" class="create"><?php _e( 'Create Page', 'velocitypage' ); ?></button></p>
			</div>
		</div>
	</form>
	</div>
	<?php // END addnew template ?>

</div>
