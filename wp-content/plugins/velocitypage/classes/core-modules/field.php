<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Field_H1 extends AdLabs_VP_Field {
	protected $slug = 'h1';
	protected $wrap_with = 'h3';
	protected $block_level = false;

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		parent::__construct( $info );
	}
}

$this->register_field( 'h1', array(
	'class' => 'AdLabs_VP_Field_H1'
));

class AdLabs_VP_Field_H2 extends AdLabs_VP_Field_H1 {
	protected $slug = 'h2';
	protected $wrap_with = 'h2';
}

$this->register_field( 'h2', array(
	'class' => 'AdLabs_VP_Field_H2'
));

class AdLabs_VP_Field_H3 extends AdLabs_VP_Field_H1 {
	protected $slug = 'h3';
	protected $wrap_with = 'h3';
}

$this->register_field( 'h3', array(
	'class' => 'AdLabs_VP_Field_H3'
));

class AdLabs_VP_Field_H4 extends AdLabs_VP_Field_H1 {
	protected $slug = 'h4';
	protected $wrap_with = 'h4';
}

$this->register_field( 'h4', array(
	'class' => 'AdLabs_VP_Field_H4'
));

class AdLabs_VP_Field_Spacer extends AdLabs_VP_Field_H1 {
	protected $slug = 'spacer';
}

$this->register_field( 'spacer', array(
	'class' => 'AdLabs_VP_Field_Spacer'
));

class AdLabs_VP_Field_HR extends AdLabs_VP_Field_Spacer {
	protected $slug = 'hr';
}

$this->register_field( 'hr', array(
	'class' => 'AdLabs_VP_Field_HR'
));

class AdLabs_VP_Field_P extends AdLabs_VP_Field_H1 {
	protected $slug = 'p';
	protected $wrap_with = 'div';
	protected $block_level = true;
	protected $apply_filters_php = 'velocitypage_content';
	protected $apply_filters_js = 'velocitypage_content_js';
}

$this->register_field( 'p', array(
	'class' => 'AdLabs_VP_Field_P'
));

class AdLabs_VP_Field_HTML extends AdLabs_VP_Field_H1 {
	protected $slug = 'html';
	protected $wrap_with = 'div';
	protected $block_level = true;
}

$this->register_field( 'html', array(
	'class' => 'AdLabs_VP_Field_HTML'
));

class AdLabs_VP_Field_Media extends AdLabs_VP_Field_H1 {
	protected $slug = 'media';
	protected $wrap_with = 'div';
	protected $block_level = true;
	protected $apply_filters_php = 'velocitypage_content_media';
}

$this->register_field( 'media', array(
	'class' => 'AdLabs_VP_Field_Media'
));

class AdLabs_VP_Field_Shortcode extends AdLabs_VP_Field_Media {
	protected $slug = 'shortcode';
	protected $wrap_with = 'div';
	protected $block_level = true;
	protected $apply_filters_php = 'velocitypage_content_media';
}

$this->register_field( 'shortcode', array(
	'class' => 'AdLabs_VP_Field_Shortcode'
));

class AdLabs_VP_Field_Img extends AdLabs_VP_Field_H1 {
	protected $slug = 'img';
	protected $wrap_with = 'div';
	protected $block_level = false;
	protected $width = 0;
	protected $height = 0;

	public function __construct( $info = array() ) {
		$this->default_template_base_path = dirname( dirname( dirname( __FILE__ ) ) ) . '/themes/default';
		if ( isset( $info['width'] ) ) {
			$this->width = $info['width'];
		}
		if ( isset( $info['height'] ) ) {
			$this->height = $info['height'];
		}
		parent::__construct( $info );
	}

	public function render_src() {
		if ( $this->doing_js() ) {
			echo "{{data.value}}";
		} else {
			echo $this->values->value;
		}
	}

	public function render_width() {
		echo $this->doing_js() ? "{{data.width}}" : $this->values->width;
	}

	public function render_height() {
		echo $this->doing_js() ? "{{data.height}}" : $this->values->height;
	}
}

$this->register_field( 'img', array(
	'class' => 'AdLabs_VP_Field_Img',
));
