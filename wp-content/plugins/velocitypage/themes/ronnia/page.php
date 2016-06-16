<?php defined( 'WPINC' ) or die; ?>

<div class="header">
	<div class="header-top-left">
	<?php $this->render_field( 'h1' ); ?>
	<?php $this->render_field( 'h2' ); ?>
	</div>
	<?php $this->render_row_area( 'header' ); ?>
</div>
<div class="rows">
	<?php $this->render_row_area( 'default' ); ?>
</div>
<div class="footer">
	<?php $this->render_field( 'footer' ); ?>
</div>
