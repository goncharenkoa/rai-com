<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Item_Default extends AdLabs_VP_Item {
	protected $slug = 'default';

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		parent::__construct( $info );
	}
}

class AdLabs_VP_Item_Spacer extends AdLabs_VP_Item_Default  {
	protected $slug = 'spacer';
	protected $expected = array(
		'fields' => array(
			'default' => 'spacer',
		)
	);
}

$this->register_item( 'spacer', array(
	'class' => 'AdLabs_VP_Item_Spacer',
));

class AdLabs_VP_Item_HR extends AdLabs_VP_Item_Spacer  {
	protected $slug = 'hr';
	protected $expected = array(
		'fields' => array(
			'default' => 'hr',
		)
	);
}

$this->register_item( 'hr', array(
	'class' => 'AdLabs_VP_Item_HR',
));

class AdLabs_VP_Item_Image extends AdLabs_VP_Item_Default  {
	protected $slug = 'image';
	protected $expected = array(
		'fields' => array(
			'image' => 'img',
		)
	);
}

$this->register_item( 'image', array(
	'class' => 'AdLabs_VP_Item_Image',
));

class AdLabs_VP_Item_Text extends AdLabs_VP_Item_Default  {
	protected $slug = 'text';
	protected $expected = array(
		'fields' => array(
			'default' => 'p',
		)
	);
}

$this->register_item( 'text', array(
	'class' => 'AdLabs_VP_Item_Text',
));

class AdLabs_VP_Item_Media extends AdLabs_VP_Item_Default {
	protected $slug = 'media';
	protected $expected = array(
		'fields' => array(
			'default' => 'media',
		)
	);
}

$this->register_item( 'media', array(
	'class' => 'AdLabs_VP_Item_Media',
));

class AdLabs_VP_Item_Shortcode extends AdLabs_VP_Item_Media {
	protected $slug = 'shortcode';
	protected $expected = array(
		'fields' => array(
			'default' => 'shortcode',
		)
	);
}

$this->register_item( 'shortcode', array(
	'class' => 'AdLabs_VP_Item_Shortcode',
));

class AdLabs_VP_Item_HTML extends AdLabs_VP_Item_Default  {
	protected $slug = 'html';
	protected $expected = array(
		'fields' => array(
			'default' => 'html',
		)
	);
}

$this->register_item( 'html', array(
	'class' => 'AdLabs_VP_Item_HTML',
	'nicename' => 'Custom HTML',
));

class AdLabs_VP_Item_MailChimp extends AdLabs_VP_Item_HTML {
	protected $slug = 'mailchimp';
}

$this->register_item( 'mailchimp', array(
	'class' => 'AdLabs_VP_Item_MailChimp',
	'nicename' => 'MailChimp Form',
));

class AdLabs_VP_Item_AWeber extends AdLabs_VP_Item_HTML {
	protected $slug = 'aweber';
}

$this->register_item( 'aweber', array(
	'class' => 'AdLabs_VP_Item_AWeber',
	'nicename' => 'AWeber Form',
));

class AdLabs_VP_Item_H1 extends AdLabs_VP_Item_Default  {
	protected $slug = 'h1';
	protected $expected = array(
		'fields' => array(
			'default' => 'h1',
		)
	);
}

$this->register_item( 'h1', array(
	'class' => 'AdLabs_VP_Item_H1',
	'nicename' => 'H1',
));

class AdLabs_VP_Item_H2 extends AdLabs_VP_Item_Default  {
	protected $slug = 'h2';
	protected $expected = array(
		'fields' => array(
			'default' => 'h2',
		)
	);
}

$this->register_item( 'h2', array(
	'class' => 'AdLabs_VP_Item_H2',
	'nicename' => 'H2',
));

class AdLabs_VP_Item_H3 extends AdLabs_VP_Item_Default  {
	protected $slug = 'h3';
	protected $expected = array(
		'fields' => array(
			'default' => 'h3',
		)
	);
}

$this->register_item( 'h3', array(
	'class' => 'AdLabs_VP_Item_H3',
	'nicename' => 'H3',
));

class AdLabs_VP_Item_H4 extends AdLabs_VP_Item_Default  {
	protected $slug = 'h4';
	protected $expected = array(
		'fields' => array(
			'default' => 'h4',
		)
	);
}

$this->register_item( 'h4', array(
	'class' => 'AdLabs_VP_Item_H4',
	'nicename' => 'H4',
));


class AdLabs_VP_Item_Chooser extends AdLabs_VP_Item_Default  {
	protected $slug = 'chooser';
}

$this->register_item( 'chooser', array(
	'class' => 'AdLabs_VP_Item_Chooser',
));

