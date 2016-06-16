<?php defined( 'WPINC' ) or die; ?>

<?php
if ( $this->doing_js() ) {
	$groups = array();
	foreach ( $this->plugin->rows as $slug => $row ) {
		if ( 'chooser' === $slug ) continue;
		$row_obj = new $row['class'];
		$expected = $row_obj->get_expectations();
		$item_area_count = count( $expected['item_areas'] );
		if ( ! isset( $groups[$item_area_count] ) ) {
			$groups[$item_area_count] = array();
		}
		$groups[$item_area_count][$slug] = true;
	}
	foreach ( $groups as $key => $members ) { ?>
	<ul class="vp-choose-type">
		<?php foreach ( $members as $slug => $row ) { ?>
			<li><a href="#" data-slug="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $slug ); ?></a></li>
		<?php } ?>
	</ul>
<?php
	}
}
?>
