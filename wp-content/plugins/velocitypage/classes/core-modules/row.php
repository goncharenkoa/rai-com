<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Row_Base extends AdLabs_VP_Row {
	protected $slug = 'base';

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		parent::__construct( $info );
	}
}

class AdLabs_VP_Row_Chooser extends AdLabs_VP_Row_Base {
	protected $slug = 'chooser';
}

$this->register_row( 'chooser', array(
	'class' => 'AdLabs_VP_Row_Chooser',
));

class AdLabs_VP_Row_Default extends AdLabs_VP_Row_Base {
	protected $slug = 'default';
	protected $expected = array(
		'item_areas' => array(
			'default' => 'default',
		)
	);
}

// $this->register_row( 'default', array(
// 	'class' => 'AdLabs_VP_Row_Default',
// ));

class AdLabs_VP_Row_Full_Width extends AdLabs_VP_Row_Default {
	protected $slug = 'full-width';
	protected $expected = array(
		'item_areas' => array(
			'default' => '100-percent',
		)
	);
}

$this->register_row( 'full-width', array(
	'class' => 'AdLabs_VP_Row_Full_Width',
));

class AdLabs_VP_Row_12_12 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-12-12';
	protected $expected = array(
		'item_areas' => array(
			'default' => '50-percent',
			'second' => '50-percent',
		)
	);
}

$this->register_row( 'split-12-12', array(
	'class' => 'AdLabs_VP_Row_12_12',
));

class AdLabs_VP_Row_13_23 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-13-23';
	protected $expected = array(
		'item_areas' => array(
			'default' => '33-percent',
			'second' => '67-percent',
		)
	);
}

$this->register_row( 'split-13-23', array(
	'class' => 'AdLabs_VP_Row_13_23',
));

class AdLabs_VP_Row_23_13 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-23-13';
	protected $expected = array(
		'item_areas' => array(
			'default' => '67-percent',
			'second' => '33-percent',
		)
	);
}

$this->register_row( 'split-23-13', array(
	'class' => 'AdLabs_VP_Row_23_13',
));

class AdLabs_VP_Row_13_13_13 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-13-13-13';
	protected $expected = array(
		'item_areas' => array(
			'default' => '33-percent',
			'second' => '33-percent',
			'third' => '33-percent',
		)
	);
}

$this->register_row( 'split-13-13-13', array(
	'class' => 'AdLabs_VP_Row_13_13_13',
));

class AdLabs_VP_Row_14_14_12 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-14-14-12';
	protected $expected = array(
		'item_areas' => array(
			'default' => '25-percent',
			'second' => '25-percent',
			'third' => '50-percent',
		)
	);
}

$this->register_row( 'split-14-14-12', array(
	'class' => 'AdLabs_VP_Row_14_14_12',
));

class AdLabs_VP_Row_12_14_14 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-12-14-14';
	protected $expected = array(
		'item_areas' => array(
			'default' => '50-percent',
			'second' => '25-percent',
			'third' => '25-percent',
		)
	);
}

$this->register_row( 'split-12-14-14', array(
	'class' => 'AdLabs_VP_Row_12_14_14',
));

class AdLabs_VP_Row_14_12_14 extends AdLabs_VP_Row_Default {
	protected $slug = 'split-14-12-14';
	protected $expected = array(
		'item_areas' => array(
			'default' => '25-percent',
			'second' => '50-percent',
			'third' => '25-percent',
		)
	);
}

$this->register_row( 'split-14-12-14', array(
	'class' => 'AdLabs_VP_Row_14_12_14',
));
