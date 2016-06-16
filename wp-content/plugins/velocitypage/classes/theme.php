<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Theme {
	protected function plugin() {
		return VelocityPage();
	}

	protected function page() {
		return $this->plugin()->page();
	}

	public function bootstrap_data( &$page, $post ) {
		// Blank
	}

	public function ensure_data( &$page ) {
		$page->add_row_area( 'default', array( 'id' => 'default' ) );
	}
}
