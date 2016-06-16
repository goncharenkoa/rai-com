<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Field extends AdLabs_VP_Renderable {
	protected $type_slug = 'field';
	protected $path_slug = 'fields';
	protected $block_level = false;
	protected $apply_filters_php = false;
	protected $apply_filters_js = false;

	public function render_field() {
		$class = $this->block_level ? 'vp-block' : 'vp-inline';
		$markup = $this->block_level ? 'div' : 'span';
		if ( $this->doing_js() ) {
			echo "<$markup class='vp-editable $class'>{{{ data.value }}}</$markup>";
		} elseif ( $this->doing_export() ) {
			echo $this->get_value( 'value' );
		} else {
			$out = $this->apply_filters_php ? apply_filters( $this->apply_filters_php, $this->get_value( 'value' ) ) : $this->get_value( 'value' );
			$this->wrap( "<$markup class='vp-noneditable $class'>" );
			echo $out;
			$this->wrap( "</$markup>" );
		}
	}

	protected function data() {
		$data = $this->values;
		unset( $data->autofocus );
		$data->id = $this->id;
		$data->slug = $this->slug;
		if ( $this->apply_filters_js ) {
			$data->value = apply_filters( $this->apply_filters_js, $this->get_value( 'value' ) );
		}
		return $data;
	}
}
