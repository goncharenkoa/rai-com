<?php defined( 'WPINC' ) or die; ?>

<div class="vp-spacer" style="height: <?php $this->render_value('value'); ?>px"><?php if ( $this->doing_js() ) : ?>
Spacer: <input type="number" min="40" max="300" value="<?php $this->render_value('value'); ?>" class="vp-spacer-value" />px
<div class="vp-spacer-slider"></div>
<?php endif; ?></div>
