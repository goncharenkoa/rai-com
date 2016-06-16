<?php defined( 'WPINC' ) or die; ?>

<div class="header">
	<div class="wrap">
	<?php $this->render_field( 'h1' ); ?>
	<?php $this->render_field( 'description' ); ?>
	</div>
</div>
<div class="rows">
	<?php $this->render_row_area( 'default' ); ?>
</div>
<div class="footer">
	<?php $this->render_field( 'footer' ); ?>
	<?php $this->render_field( 'h4' ); ?>
</div>
