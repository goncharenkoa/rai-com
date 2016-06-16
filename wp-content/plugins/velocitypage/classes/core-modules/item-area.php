<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Item_Area_Default extends AdLabs_VP_Item_Area {
	protected $slug = 'default';

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		parent::__construct( $info );
	}
}

$this->register_item_area( 'default', array(
	'class' => 'AdLabs_VP_Item_Area_Default',
));

class AdLabs_VP_Item_Area_25_Percent extends AdLabs_VP_Item_Area_Default {
	protected $slug = '25-percent';
}

$this->register_item_area( '25-percent', array(
	'class' => 'AdLabs_VP_Item_Area_25_Percent',
));

class AdLabs_VP_Item_Area_33_Percent extends AdLabs_VP_Item_Area_Default {
	protected $slug = '33-percent';
}

$this->register_item_area( '33-percent', array(
	'class' => 'AdLabs_VP_Item_Area_33_Percent',
));

class AdLabs_VP_Item_Area_50_Percent extends AdLabs_VP_Item_Area_Default {
	protected $slug = '50-percent';
}

$this->register_item_area( '50-percent', array(
	'class' => 'AdLabs_VP_Item_Area_50_Percent',
));

class AdLabs_VP_Item_Area_67_Percent extends AdLabs_VP_Item_Area_Default {
	protected $slug = '67-percent';
}

$this->register_item_area( '67-percent', array(
	'class' => 'AdLabs_VP_Item_Area_67_Percent',
));

class AdLabs_VP_Item_Area_100_Percent extends AdLabs_VP_Item_Area_Default {
	protected $slug = '100-percent';
}

$this->register_item_area( '100-percent', array(
	'class' => 'AdLabs_VP_Item_Area_100_Percent',
));
