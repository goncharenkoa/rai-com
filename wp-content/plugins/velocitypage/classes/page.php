<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Page extends AdLabs_VP_Renderable {
	protected $type_slug = 'page';
	protected $fields = array();
	protected $row_areas = array();
	protected $item_areas = array();
	protected $has_many_named = array( 'row_areas', 'item_areas', 'fields' );

	public function __construct( $data = NULL ) {
		parent::__construct();
		if ( is_object( $data ) )
			$this->load_data( $data );
	}

	public function add_field( $slug, $info = array() ) {
		return $this->add_thing( 'field', $slug, $info );
	}

	protected function field( $slug ) {
		if ( isset( $this->fields[$slug] ) )
			return $this->fields[$slug];
		else
			return NULL;
	}

	protected function render_field( $id ) {
		$this->render_thing( 'field', $id );
	}

	public function add_row_area( $slug, $info = array() ) {
		return $this->add_thing( 'row_area', $slug, $info );
	}

	public function add_item_area( $slug, $info = array() ) {
		return $this->add_thing( 'item_area', $slug, $info );
	}

	protected function row_area( $slug ) {
		return $this->get_thing( 'row_area', $slug );
	}

	protected function item_area( $slug ) {
		return $this->get_thing( 'item_area', $slug );
	}

	protected function render_row_area( $slug ) {
		$this->render_thing( 'row_area', $slug );
	}

	protected function render_item_area( $slug ) {
		$this->render_thing( 'item_area', $slug );
	}

	public function render( $before = null, $after = null ) {
		if ( ! $this->doing_js() )
			$this->wrap( "<div id='velocity-page-inner-wrapper'>" );
		include( $this->plugin->theme->path . 'simple-page.php' );
		if ( ! $this->doing_js() )
			$this->wrap( "</div>" );
	}

	public function to_array_without( $object, $keys = array() ) {
		$array = (array) $object;
		foreach ( $keys as $key ) {
			unset( $array[$key] );
		}
		return $array;
	}

	// Todo: let each class load its children
	public function load_data( $data ) {
		$this->has_data = true; // Temp hack
		foreach ( $data->fields as $name => $field ) {
			$this->add_field( $field->slug, (array) $field );
		}
		// Migration
		if ( isset( $data->sectionAreas ) ) {
			$data->rowAreas = $data->sectionAreas;
		}
		foreach ( $data->rowAreas as $name => $rowArea ) {
			// Todo: don't hardcode default here
			$_rowArea = $this->add_row_area( 'default', array( 'id' => $name ) );
			foreach ( $rowArea as $row ) {
				$_row = $_rowArea->add_row( $row->slug, (array) $row );
				foreach ( $row->fields as $name => $field ) {
					$_row->add_field( $field->slug, (array) $field );
				}
				foreach ( $row->itemAreas as $name => $itemArea ) {
					// Todo: don't hardcode default here
					$_itemArea = $_row->add_item_area( 'default', array( 'id' => $name ) );
					foreach ( $itemArea as $item ) {
						$_item = $_itemArea->add_item( $item->slug, $this->to_array_without( $item, array( 'fields' ) ) );
						if ( $_item ) {
							foreach ( $item->fields as $name => $field ) {
								$_item->add_field( $field->slug, (array) $field );
							}
						}
					}
				}
			}
		}
	}

	public function js_data() {
		$data = array( 'fields' => array(), 'rowAreas' => array(), 'itemAreas' => array() );
		foreach ( $this->fields as $key => $field ) {
			$data['fields'][$key] = $field->get();
		}
		$data['fields'] = (object) $data['fields'];
		foreach ( $this->row_areas as $key => $area ) {
			$data['rowAreas'][$key] = $area->get();
		}
		foreach ( $this->item_areas as $key => $area ) {
			$data['itemAreas'][$key] = $area->get();
		}
		$data['rowAreas'] = (object) $data['rowAreas'];
		$data['itemAreas'] = (object) $data['itemAreas'];
		$data['id'] = get_queried_object_id();
		$data['theme'] = $this->plugin->theme->slug;
		$data['demo'] = $this->plugin->demo;
		$data['transitioning'] = $this->plugin->transitioning;
		$data = (object) $data;
		?><script>velocityPageApp.pageData = <?php echo json_encode( $data ); ?>; velocityPageApp.loadData();
		<?php if ( $this->plugin->transitioning ) { ?>jQuery(function($){$('li.vp-start-page').click();});<?php } ?>
		</script><?php
	}
}
