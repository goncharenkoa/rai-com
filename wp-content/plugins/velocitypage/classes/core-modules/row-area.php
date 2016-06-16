<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Row_Area_Default extends AdLabs_VP_Row_Area {
	protected $slug = 'default';

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		parent::__construct( $info );
	}
}

$this->register_row_area( 'default', array(
	'class' => 'AdLabs_VP_Row_Area_Default',
));
