<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Item extends AdLabs_VP_Renderable {
	protected $type_slug = 'item';
	protected $path_slug = 'items';
	protected $fields = array();
	protected $has_many_named = array( 'fields' );
	protected $has_controls = true;

	protected function render_field( $id ) {
		$extra_classes = ( isset( $this->values->align ) ) ? array( 'vp-align-' . $this->values->align ) : array();
		$this->render_thing( 'field', $id, $extra_classes );
	}

	public function add_field( $slug, $info = array() ) {
		return $this->add_thing( 'field', $slug, $info );
	}

	protected function data() {
		$data = new StdClass;
		$data->id = $this->id;
		$data->slug = $this->slug;
		if ( isset( $this->values->align ) ) {
			$data->align = $this->values->align;
		}
		return $data;
	}
}
