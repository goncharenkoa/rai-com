<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Item_Area extends AdLabs_VP_Renderable {
	protected $type_slug = 'item-area';
	protected $path_slug = 'item-areas';
	protected $items = array();
	protected $has_many = array( 'items' );
	protected $lists_count_of = array( 'items' );
	protected $has_controls = true;

	public function add_item( $slug, $info = array() ) {
		return $this->add_thing( 'item', $slug, $info );
	}

	public function render_item_area() {
		$this->render_things( 'item' );
	}
}
