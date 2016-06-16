<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Row extends AdLabs_VP_Renderable {
	protected $item_areas = array();
	protected $fields = array();
	protected $type_slug = 'row';
	protected $path_slug = 'rows';
	protected $has_many_named = array( 'item_areas', 'fields' );
	protected $has_controls = true;

	public function add_field( $slug, $info = array() ) {
		return $this->add_thing( 'field', $slug, $info );
	}

	protected function field( $slug ) {
		return $this->get_thing( 'field', $slug );
	}

	public function render_item_area( $slug ) {
		$this->render_thing( 'item_area', $slug );
	}

	public function render_item_areas() {
		if ( isset( $this->expected['item_areas'] ) ) {
			$areas = array_keys( $this->expected['item_areas'] );
			array_walk( $areas, array( $this, 'render_item_area' ) );
		}
	}

	protected function render_field( $slug ) {
		$this->render_thing( 'field', $slug );
	}

	public function add_item_area( $slug, $info = array() ) {
		return $this->add_thing( 'item_area', $slug, $info );
	}

	protected function item_area( $slug ) {
		return $this->get_thing( 'item_area', $slug );
	}

	public function render($before = null, $after = null) {
		parent::render( '<div class="row">', '</div>' );
	}

	protected function data() {
		$data = parent::data();
		if ( isset( $this->values->style ) ) {
			$data->style = $this->values->style;
		}
		return $data;
	}
}
