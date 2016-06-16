<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Row_Area extends AdLabs_VP_Renderable {
	protected $rows = array();
	protected $type_slug = 'row-area';
	protected $path_slug = 'row-areas';
	protected $has_many = array( 'rows' );
	protected $has_controls = true;

	public function add_row( $slug, $info = array() ) {
		$info['parent'] = $this->slug;
		return $this->add_thing( 'row', $slug, $info );
	}

	public function render_row_area() {
		$this->render_things( 'row' );
	}
}
