<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Renderable {
	protected $id = 'renderable-id-CHANGEME';
	protected $slug = 'renderable-slug-CHANGEME';
	protected $type_slug = 'renderable-type-slug-CHANGEME';
	protected $default_template_base_path = '';
	protected $path_slug = 'renderable-path-CHANGEME';
	protected $plugin;
	protected $has_many = array();
	protected $has_many_named = array();
	protected $expected = array();
	protected $lists_count_of = array();
	protected $has_controls = false;
	public $values;

	public function __construct( $info = array() ) {
		$this->plugin = VelocityPage();
		$defaults = array(
			'id' => uniqid(),
		);
		$info = wp_parse_args( $info, $defaults );
		$this->id = $info['id'];
		$this->values = (object) $info;
	}

	public function render( $before = null, $after = null) {
		foreach ( array(
			trailingslashit( VelocityPage()->theme->path ) . $this->path_slug . "/{$this->slug}.php",
			trailingslashit( $this->default_template_base_path ) . $this->path_slug . "/{$this->slug}.php",
			trailingslashit( $this->default_template_base_path ) . $this->path_slug . "/default.php",
		) as $template ) {
			if ( file_exists( $template ) ) {
				$this->announce();
				$this->wrap( $before );
				include( $template );
				$this->print_control_placeholder();
				$this->wrap( $after );
				return;
			}
		}
		// Still here?
		trigger_error( "Template not found for {$this->path_slug}/{$this->slug}.php", E_USER_ERROR );
	}

	public function announce() {
		// echo '<code>' . ( $this->doing_js() ? '&nbsp;JS' : 'PHP' ) . ':</code> ' . $this->type_slug;
	}

	public function print_expectations() {
		if ( $this->expected ) {
			$this->wrap( "<script>velocityPageApp.expectations.{$this->type_slug}s['{$this->slug}'] = " . json_encode( $this->expected ) . ';</script>' );
		}
	}

	public function get_expectations() {
		return $this->expected;
	}

	public function wrap( $output ) {
		return $this->plugin->wrap( $output );
	}

	protected function print_control_placeholder() {
		if ( $this->doing_js() && $this->has_controls() )
			$this->wrap( "<div class='{$this->type_slug}-controls-wrap'></div>" );
	}

	protected function has_controls() {
		return (bool) $this->has_controls;
	}

	public function render_js() {
		$this->set_js( true );
		$this->render();
		$this->set_js( false );
	}

	public function set_js( $doing_js = true ) {
		$this->plugin->doing_js = (bool) $doing_js;
	}

	public function doing_js() {
		return (bool) $this->plugin->doing_js;
	}

	public function doing_export() {
		return (bool) $this->plugin->doing_export;
	}

	public function add_thing( $type, $module_slug, $info = array() ) {
		$types = $type . 's';
		if ( isset( $this->{$types}[$info['id']] ) ) {
			return $this->{$types}[$info['id']];
		}
		$class = $this->plugin->get_thing_class( $type, $module_slug );
		if ( ! class_exists( $class ) ) {
			trigger_error( "Class $class for $type/$module_slug does not exist", E_USER_NOTICE );
			return false;
		}
		$new_thing = new $class( $info );
		$this->{$types}[$new_thing->id] = $new_thing;
		return $new_thing;
	}

	public function get_thing( $type, $slug ) {
		$types = $type . 's';
		if ( isset( $this->{$types}[$slug] ) )
			return $this->{$types}[$slug];
		else
			return NULL;
	}

	public function render_thing( $type, $slug, $extra_classes = array() ) {
		$type_dashed = str_replace( '_', '-', $type );
		$types = $type . 's';
		$classes = array(
			"{$this->type_slug}-{$type_dashed}-wrap",
			"{$this->type_slug}-{$type_dashed}-wrap-{$slug}",
		);
		if ( ! $this->doing_js() && $extra_classes ) {
			$classes = array_merge( $classes, $extra_classes );
		}
		$this->wrap( "<div class='" .implode( ' ', $classes ) . "'>" );
		if ( ! $this->doing_js() ) {
			$classes = array( "{$type_dashed}-wrap" );
			if ( isset( $this->expected[$types] ) ) {
				$classes[] = $type_dashed . '-wrap-slug-' . $this->expected[$types][$slug];
			}

			$this->wrap( "<div class='" . implode( ' ', $classes ) . "'>" );

			$this->{$types}[$slug]->render();

			$this->wrap( "</div>" );
		}
		$this->wrap( "</div>" );
	}

	public function render_things( $type ) {
		$types = $type . 's';
		$classes = array( "{$this->type_slug}-{$type}-wrap" );
		if ( ! $this->doing_js() && false !== array_search( $types, $this->lists_count_of, true ) ) {
			$classes[] = "{$type}-count-" . count( $this->{$types} );
		}
		$this->wrap( "<div class='" . implode( ' ', $classes ) . "'>" );
		if ( ! $this->doing_js() && count( $this->{$types} ) ) {
			foreach ( $this->{$types} as $thing ) {
				$alt = $thing->get_value( 'style' ) === 'alt' ? ' vp-alt-style' : '';
				$this->wrap( "<div class='{$type}-wrap {$type}-wrap-slug-{$thing->slug}{$alt}'>" );
				$thing->render();
				$this->wrap( "</div>" );
			}
		}
		$this->wrap( "</div>" );
	}

	public function get_value( $value ) {
		if ( isset( $this->values->{$value} ) )
			return $this->values->{$value};
	}

	public function render_value( $value ) {
		echo $this->doing_js() ? "{{data.$value}}" : $this->get_value( $value );
	}

	public function render_raw_value( $value ) {
		echo $this->doing_js() ? "{{{data.$value}}}" : $this->get_value( $value );
	}

	protected function data() {
		$data = new StdClass;
		$data->id = $this->id;
		$data->slug = $this->slug;
		return $data;
	}

	public function get() {
		$return = new StdClass;
		$return->data = $this->data();
		$options = new StdClass;
		foreach ( (array) $this->has_many as $thing_name ) {
			$things = array();
			foreach ( $this->{$thing_name} as $thing ) {
				$things[] = $thing->get();
			}
			$js_thing_name = $this->underscores_to_camelcase( $thing_name );
			$options->{$js_thing_name} = $things;
		}
		foreach ( (array) $this->has_many_named as $thing_name ) {
			$things = new StdClass;
			foreach ( $this->{$thing_name} as $name => $thing ) {
				$things->{$name} = $thing->get();
			}
			$js_thing_name = $this->underscores_to_camelcase( $thing_name );
			$options->{$js_thing_name} = $things;
		}
		$return->options = $options;
		return $return;
	}

	public function underscores_to_camelcase( $text ) {
		$words = explode( '_', $text );
		$output = array_shift( $words );
		$words = array_map( 'ucfirst', $words );
		$output .= implode( '', $words );
		return $output;
	}
}
