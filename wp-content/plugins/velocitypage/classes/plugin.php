<?php
defined( 'WPINC' ) or die;

class AdLabs_VP_Plugin extends WP_Stack_Plugin {
	public static $instance; // Use VelocityPage() to get this outside of the class
	protected $themes = array();
	protected $layouts = array();
	public $theme;
	public $__FILE__;
	public $dir;
	const PREFIX = 'adlabs_vp_';
	const DASHED_PREFIX = 'adlabs-vp-';
	const ADMIN_BAR_NODE = 'velocitypage';
	const VERSION = '1.2.0';
	const CSS_JS_VERSION = '1.2.0';

	// These hold the registrations with the data needed
	// to instantiate and spin out new objects
	public $page;
	public $row_areas = array();
	public $item_areas = array();
	public $rows = array();
	public $items = array();
	public $fields = array();

	// HTML wrapper output
	public $wrap = true;

	// Store
	const STORE_URL = 'http://velocitypage.com/';
	const STORE_ITEM_NAME = 'VelocityPage';

	// JS flag
	public $doing_js = false;

	// Export flag
	public $doing_export = false;

	// Demo mode flag
	public $demo = false;

	// Edit flag
	public $can_edit = false;
	public $transitioning = false;
	public $enabled = false;

	// Main loop flag
	public $capture_main_loop;
	const MARKER_START = "<script>//vp_loop_start</script>";
	const MARKER_END   = "<script>//vp_loop_end</script>";

	// Saving
	public $updating_post = false;
	public $updating_data = false;

	public function __construct( $__FILE__ ) {
		self::$instance = $this;
		$this->__FILE__ = $__FILE__;
		$this->dir = dirname( $__FILE__ ) . '/';
		$this->hook( 'plugins_loaded' );
	}

	public function plugins_loaded() {
		$this->hook( 'init' );
	}

	public function init() {
		global $wpdb;
		// Upgrade routines
		$db_version = trim( get_option( self::PREFIX . 'db_version' ) );
		if ( ! $db_version ) {
			$wpdb->query( "UPDATE $wpdb->postmeta SET meta_key = '_adlabs_vp_data' WHERE meta_key = 'adlabs_vp_data'" );
		}
		update_option( self::PREFIX . 'db_version', 2 );

		$this->hook( self::PREFIX . 'init', 'register_modules' );
		do_action( self::PREFIX . 'init' );

		$this->register_hooks();

		$theme_dir_path = $this->get_theme_dir_path();
		$this->register_theme( 'user-theme', array( 'path' => $theme_dir_path . 'user-theme' ) );

		// We register our built-in themes here
		foreach ( array(
			'guidebook' => 'Guidebook',
			'maven' => 'Maven',
			'landify' => 'Landify',
			'online-course' => 'Online Course',
			'paper-plane' => 'Paper Plane',
			'ronnia' => 'Ronnia',
		) as $theme_slug => $theme_name ) {
			$this->register_theme( $theme_slug, array(
				'path' => $theme_dir_path . $theme_slug,
				'name' => $theme_name
			));
		}

		// We register out built-in layouts here
		foreach ( array(
			'existing-content' => 'Existing Content',
			'about' => 'About',
			'contact' => 'Contact',
			'signup' => 'Signup',
			'start-here' => 'Start Here',
			'thank-you' => 'Thank You',
		) as $layout_slug => $layout_name ) {
			$this->register_layout( $layout_slug, array(
				'name' => $layout_name,
			));
		}

		do_action( self::PREFIX . 'register_themes', $this );

		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			include( $this->dir . 'lib/EDD_SL_Plugin_Updater.php' );
		}
	}

	public function register_hooks() {
		$this->hook( 'admin_init' );
		$this->hook( 'admin_bar_menu', -999999 );
		$this->hook( 'admin_notices' );
		$this->hook( 'template_include' );
		$this->hook( 'add_meta_boxes' );
		$this->hook( 'post_submitbox_misc_actions', 'publish_box' );
		$this->hook( 'save_post' );
		$this->hook( 'wp_ajax_velocity-page', 'ajax' );
		$this->hook( 'admin_menu' );
		$this->hook( 'admin_post_' . self::DASHED_PREFIX . 'save', 'save_settings' );
		$this->hook( self::PREFIX . 'load-theme', 'load_theme' );
		$this->hook( 'wp_restore_post_revision' );
		$this->hook( 'wp_insert_post' );
		$this->hook( 'wp_insert_post_data' );
		$this->hook( 'body_class' );

		add_filter( 'velocitypage_content', 'wptexturize' );
		add_filter( 'velocitypage_content', 'convert_chars' );
		add_filter( 'velocitypage_content', 'wpautop' );
		add_filter( 'velocitypage_content', 'shortcode_unautop' );
		add_filter( 'velocitypage_content', 'do_shortcode', 11 );
		add_filter( 'velocitypage_content', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
		add_filter( 'velocitypage_content', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );

		add_filter( 'velocitypage_content_js', 'wptexturize' );
		add_filter( 'velocitypage_content_js', 'convert_chars' );
		add_filter( 'velocitypage_content_js', 'wpautop' );
		add_filter( 'velocitypage_content_js', 'shortcode_unautop' );

		add_filter( 'velocitypage_content_media', 'convert_chars' );
		add_filter( 'velocitypage_content_media', 'do_shortcode', 11 );
		add_filter( 'velocitypage_content_media', array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
		add_filter( 'velocitypage_content_media', array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
	}

	public function admin_init() {
		// retrieve our license key from the DB
		$license_key = trim( get_option( self::PREFIX . 'license_key' ) );

		// This is hardcoded true for now
		if ( true /* $this->license_valid() */ ) {
			// setup the updater
			$edd_updater = new EDD_SL_Plugin_Updater( self::STORE_URL, $this->__FILE__, array(
				'version' 	=> self::VERSION, // current version number
				'license' 	=> $license_key,
				'item_name' => self::STORE_ITEM_NAME, // name of this plugin
				'author' 	=> 'Ad Labs Inc' // author of this plugin
				)
			);
		} else {
			// $this->hook( 'admin_notices', 'license_expired' );
		}

		$plugin = plugin_basename( $this->__FILE__ );
		$this->hook( "plugin_action_links_$plugin", 'add_settings_link' );
		$this->hook( 'load-post.php', 'load_edit_post' );
	}

	private function add_menu_bar_subnode( $bar, $id_suffix, $title, $meta = array() ) {
		$bar->add_node( array(
			'id' => self::ADMIN_BAR_NODE . '-' . $id_suffix,
			'title' => $title,
			'href' => '#',
			'parent' => self::ADMIN_BAR_NODE,
			'meta' => $meta,
		) );
	}

	public function admin_bar_menu( $bar ) {
		if ( ! is_admin() ) {
			$bar->add_node( array(
				'id' => self::ADMIN_BAR_NODE,
				'title' => sprintf( __( '%s VelocityPage&nbsp;', 'velocitypage' ), '<img width="20" height="20" src="' . $this->get_url() . 'img/logo-40x40.png' . '" />' ),
				'href' => '#',
				'parent' => 'top-secondary',
			) );

			$this->add_menu_bar_subnode( $bar, 'addnew', __( 'Add new page', 'velocitypage' ) );

			if ( is_page() ) {
				$enabled = $this->page_enabled();
				if ( ! $enabled || $this->transitioning ) {
					if ( ! $this->transitioning  ) {
						$this->add_menu_bar_subnode( $bar, 'choose', __( 'Edit with VelocityPage', 'velocitypage' ) );
					} else {
						$this->add_menu_bar_subnode( $bar, 'choose', __( 'Choose another template', 'velocitypage' ) );
					}
				} else {
					$this->add_menu_bar_subnode( $bar, 'edit', __( 'Edit with VelocityPage', 'velocitypage' ) );
				}
				if ( $enabled || $this->transitioning ) {
					$this->add_menu_bar_subnode( $bar, 'save', __( 'Save', 'velocitypage' ), array( 'class' => 'vp-hidden' ) );
					// $this->add_menu_bar_subnode( $bar, 'options', __( 'Options', 'velocitypage' ) );
				}
			}
		}
	}

	public function load_edit_post() {
		if ( isset( $_GET['action'] ) && $_GET['action'] === 'edit' && isset( $_GET['post'] ) ) {
			$post_id = absint( $_GET['post'] );
			if ( $this->page_enabled( $post_id ) ) {
				$this->hook( 'admin_enqueue_scripts' );
			}
		}
	}

	public function admin_enqueue_scripts() {
		wp_enqueue_style( self::DASHED_PREFIX . 'edit-admin-styles', $this->get_url() . 'css/edit-admin.css', null, '2014-04-01' );
		wp_enqueue_script( self::DASHED_PREFIX . 'edit-admin-scripts', $this->get_url() . 'js/edit-admin.min.js', null, '2014-04-25' );
	}

	public function add_settings_link( $links ) {
  	$links[] = '<a href="' . $this->get_settings_url() . '">' . __( 'Settings' ) . '</a>';
  	return $links;
	}

	public function get_page_url_json() {
		$pages = new WP_Query(
			array(
				'post_type' => 'page',
				'post_status' => array( 'publish', 'draft' ),
				'posts_per_page' => -1,
				'no_found_rows' => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
				'fields' => 'ids',
			)
		);
		$pages = $pages->posts;
		$pages_out = array();
		foreach ( $pages as $page ) {
			$pages_out[$page] = str_replace( home_url( '/' ), '', get_permalink( $page ) );
		}
		return json_encode( $pages_out );
	}

	public function body_class( $classes ) {
		if ( $this->demo ) {
			$classes[] = 'vp-demo';
		}
		return $classes;
	}

	public function publish_box() {
		global $post;
		if ( isset( $_GET['post'] ) && $this->is_enabled_post_type( $post->post_type ) ) {
			if ( 'publish' == $post->post_status ) {
				$preview_link = esc_url( get_permalink( $post->ID ) );
			} else {
				$preview_link = set_url_scheme( get_permalink( $post->ID ) );
				$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ), $post ) );
			}
			$preview_link = add_query_arg( 'vp-instant-transition', '1', $preview_link );

			$this->include_file( 'templates/publish-box.php', array( 'link' => $preview_link ) );
		}
	}

	public function admin_notices() {
		if ( in_array( get_current_screen()->id, array( 'plugins', 'update-core' ) ) && ( ! isset( $_POST ) || ! $_POST ) ) {
			$status = $this->get_license_status();
			$license = $this->get_license();
			if ( ! is_object( $status ) || ! isset( $status->message ) ) {
				// No valid status object
				if ( $license ) {
					// Hm. We have a key, but no status object. Try to grab one?
					$status = $this->attempt_license_activation( $license );
					if ( 'invalid' === $status->message ) {
						// The key they had entered is invalid. Blank it.
						$this->update_license( '' );
						$status->message = 'no_license_key';
					} elseif ( 'http_fail' !== $status->message ) {
						$update->message = ( 'already_valid' === $update->message ) ? 'valid' : $update->message;
						$this->update_license_status( $update );
						$this->update_license( $license );
					}
				} else {
					// No license key
					$status = new stdClass;
					$status->message = 'no_license_key';
				}
			}
			switch( $status->message ) {
				case 'no_license_key':
				case 'deactivated':
					$message_type = 'updated';
					$message = sprintf( 'VelocityPage needs a license key in order to receive updates and to give you access to support! Please <a href="%s">enter it here</a>.', $this->get_settings_url() );
					break;
				case 'expired':
					$message_type = 'error';
					$message = sprintf( 'Your VelocityPage license key has expired! Please log in to your account at <a href="%s">VelocityPage.com</a> to renew your license at a discounted rate so you can continue receiving updates and support.', 'http://velocitypage.com/' );
					break;
				case 'disabled':
					$message_type = 'error';
					$message = sprintf( 'Your VelocityPage license key has been disabled. If you requested a refund, this is normal. Otherwise, <a href="%s">contact VelocityPage support</a> to discuss this matter.', 'http://velocitypage.com.' );
					break;
			}
			if ( isset( $message_type ) ) {
				$this->include_file( 'templates/license-notice.php', compact( 'message', 'message_type' ) );
			}
		}
	}

	public function get_settings_url() {
		return admin_url( 'plugins.php?page=velocitypage' );
	}

	public function admin_menu() {
		add_plugins_page( __( 'VelocityPage' ), __( 'VelocityPage' ), 'manage_options', 'velocitypage', array( $this, 'settings' ) );
	}

	public function settings() {
		$license = $this->get_license();
		$status = get_option( self::PREFIX . 'license_status' );
		$client_site = $license && preg_match( '#-client$#', $license );

		if ( isset( $_GET['message'] ) ) {
			switch ( $_GET['message'] ) {
				case 'invalid':
					$message = 'The license key you provided is not valid.';
					$message_type = 'error';
					break;
				case 'invalid_revert':
					$message = 'The new license key you provided is not valid. We restored your old one.';
					$message_type = 'error';
					break;
				case 'expired':
					$message = 'This license key has expired! To continue receiving updates and support, please <a href="http://velocitypage.com/">renew your license</a>.';
					$message_type = 'error';
					break;
				case 'already_valid':
				case 'valid':
					if ( $client_site ) {
						$message = 'Good to go! You can now receive updates for this site.';
					} else {
						$message = 'Good to go! You can now receive updates and support for this site.';
					}
					$message_type = 'updated';
					break;
				case 'deactivated':
					$message = 'Your license key for this site has been deactivated. This site will no longer receive updates or support.';
					$message_type = 'updated';
					break;
				case 'disabled':
					$message = 'This license key has been disabled. Please contact <a href="http://velocitypage.com/">VelocityPage support</a> to resolve this issue.';
					$message_type = 'error';
					break;
			}
		}
		$this->include_file( 'templates/settings.php', compact( 'license', 'status', 'message', 'message_type' ) );
	}

	public function edd_request( $action, $args = array() ) {
		if ( ! is_array( $action ) ) {
			$args['edd_action'] = $action;
		} else {
			$args = $action; // Allows people to just pass an array with edd_action
		}
		$args = wp_parse_args( $args, array(
			'item_name' => urlencode( self::STORE_ITEM_NAME ), // the name of our product in EDD
			'url' => home_url(),
		) );
		if ( isset( $args['license'] ) ) {
			$args['license'] = $this->convert_license( $args['license'] );
		}

		$response = wp_remote_post( self::STORE_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $args ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false;
		} else {
			$decoded = json_decode( wp_remote_retrieve_body( $response ) );
			return is_null( $decoded ) ? false : $decoded;
		}
	}

	public function delete_option( $name ) {
		return delete_option( self::PREFIX . $name );
	}

	public function get_option( $name, $default = null ) {
		$option = get_option( self::PREFIX . $name );
		if ( is_null( $option ) ) {
			return $default;
		} else {
			return $option;
		}
	}

	public function update_option( $name, $value ) {
		return update_option( self::PREFIX . $name, $value );
	}

	public function license_valid() {
		delete_transient( self::PREFIX . 'license_status' );
		$status = $this->get_license_status();
		return is_object( $status ) && isset( $status->license ) && 'valid' === $status->license;
	}

	public function get_license_status() {
		$this->delete_option( 'license_status' );
		$status = get_transient( self::PREFIX . 'license_status' );
		if ( ! $status ) {
			$status = $this->check_license( $this->get_license() );
			if ( is_wp_error( $status ) ) {
				$staus = (object) array( 'message' => 'http_fail', 'data' => new stdClass );;
			} else {
				$status = (object) array( 'message' => $status->license, 'data' => $status );
			}
			$this->update_license_status( $status );
		}
		return $status;
	}

	public function update_license_status( $status ) {
		return set_transient( self::PREFIX . 'license_status', $status, 60*60*24);
	}

	public function update_license( $license ) {
		return $this->update_option( 'license_key', trim( $license ) );
	}

	public function get_license() {
		return trim( $this->get_option( 'license_key', '' ) );
	}

	public function convert_license( $license ) {
		if ( substr( $license, -7 ) === '-client' ) {
			$license = preg_replace( '#-client$#', '', $license );
			$license = strrev( str_rot13( $license ) );
		}
		return $license;
	}

	public function check_license( $license ) {
		return $this->edd_request( 'check_license', array(
			'license' => $license,
			)
		);
	}

	public function activate_license( $license ) {
		return $this->edd_request( 'activate_license', array(
			'license' => $license,
			)
		);
	}

	public function deactivate_license( $license ) {
		return $this->edd_request( 'deactivate_license', array(
			'license' => $license,
			)
		);
	}

	public function attempt_license_deactivation( $license ) {
		$deactivate = $this->deactivate_license( $license );
		if ( ! $deactivate ) {
			return (object) array( 'message' => 'http_fail', 'data' => new stdClass );;
		} else {
			return (object) array( 'message' => 'deactivated', 'data' => $deactivate );
		}
		/*
		} elseif ( 'deactivated' === $deactivate->license ) {
			return (object) array( 'message' => 'deactivated', 'data' => $deactivate );
		} else {
			return (object) array( 'message' => 'not_deactivated', 'data' => $deactivate );
		}
		*/
	}

	public function attempt_license_activation( $new_license ) {
		$current_license = $this->get_license();
		$http_fail = (object) array( 'message' => 'http_fail', 'data' => new stdClass );
		if ( $current_license === $new_license && is_object( $this->get_license_status() ) ) {
			return (object) array( 'message' => 'no_change', 'data' => new stdClass );
		} elseif ( $new_license ) {
			// Passing in a new license. Let's check it out
			$check = $this->check_license( $new_license );
			if ( ! $check ) {
				return $http_fail;
			} else {
				// Got a good server response
				if ( in_array( $check->license, array( 'valid', 'inactive', 'site_inactive' ) ) ) {
					// So any of these three responses means the license key is good
					// * valid — it is already active for this site
					// * inactive — it has not been activated at all
					// * site_inactive — it has been activated elsewhere, but not for this site
					if ( 'valid' === $check->license ) {
						return (object) array( 'message' => 'already_valid', 'data' => $check );
					} else {
						if ( $current_license ) {
							// Attempt the swap
							$deactivate = $this->attempt_license_deactivation( $current_license );
						}
						$activate = $this->activate_license( $new_license );
						if ( ! $activate ) {
							return $http_fail;
						} elseif ( 'valid' === $activate->license ) {
								return (object) array( 'message' => 'valid', 'data' => $activate );
						} elseif ( 'invalid' === $check->license && $current_license ) {
							return (object) array( 'message' => 'invalid_revert', 'data' => $activate );
						} else {
								return (object) array( 'message' => $activate->license, 'data' => $activate );
						}
					}
				} elseif ( 'invalid' === $check->license && $current_license ) {
					return (object) array( 'message' => 'invalid_revert', 'data' => $check );
				} else {
					// Not good results:
					// * invalid — WTF are you talking about
					// * expired
					// * disabled — we revoked the license
					return (object) array( 'message' => $check->license, 'data' => $check );
				}
			}
		} else {
			// New license is blank
			return $this->attempt_license_deactivation( $current_license );
		}
	}

	public function save_settings() {
		check_admin_referer( self::PREFIX . 'save' );
		if ( isset( $_POST[self::PREFIX . 'deactivate'] ) ) {
			$_POST[self::PREFIX . 'license_key'] = '';
		}
		$posted_license = trim( stripslashes( $_POST[self::PREFIX . 'license_key'] ) );
		$update = $this->attempt_license_activation( $posted_license );
		if ( in_array( $update->message, array( 'already_valid', 'valid', 'deactivated' ) ) ) {
			$update->message = 'already_valid' === $update->message ? 'valid' : $update->message;
			$this->update_license_status( $update );
			$this->update_license( $posted_license );
		}
		wp_redirect( admin_url( 'plugins.php?page=velocitypage&message=' . $update->message ) );
		exit;
	}

	public function register_modules() {
		include( $this->dir . 'classes/core-modules/row.php' );
		include( $this->dir . 'classes/core-modules/row-area.php' );
		include( $this->dir . 'classes/core-modules/item-area.php' );
		include( $this->dir . 'classes/core-modules/item.php' );
		include( $this->dir . 'classes/core-modules/field.php' );
	}

	public function enabled_post_types() {
		return apply_filters( self::PREFIX . 'enabled_post_types', array( 'page' ) );
	}

	public function is_enabled_post_type( $post_type ) {
		return in_array( $post_type, $this->enabled_post_types() );
	}

	public function add_meta_boxes() {
		$post_types = $this->enabled_post_types();
		$post = get_post();
		if ( $post && isset( $post->ID ) && $this->page_enabled( $post->ID ) ) {
			foreach ( $post_types as $post_type ) {
				add_meta_box( self::DASHED_PREFIX . 'meta', __( 'VelocityPage', 'velocitypage' ), array( $this, 'meta_box' ), $post_type, 'side' );
			}
		}
	}

	public function meta_box() {
		$post = get_post();
		wp_nonce_field( self::DASHED_PREFIX . 'save-post_' . $post->ID, self::PREFIX . 'nonce', false );
		$this->include_file( 'templates/post-meta-box.php', compact( 'post' ) );
	}

	public function save_post( $post_id ) {
		if ( isset( $_POST[self::PREFIX . 'nonce'] ) && wp_verify_nonce( $_POST[self::PREFIX . 'nonce'], self::DASHED_PREFIX . 'save-post_' . $post_id ) ) {
			$this->update_post_meta( $post_id, 'theme', stripslashes( $_POST[self::PREFIX . 'theme'] ) );
			$this->update_post_meta( $post_id, 'enabled', $_POST[self::PREFIX . 'enabled'] );
		}
	}

	public function export_post_from_data( $data ) {
		// Save the previous theme
		$previous_theme = $this->theme;
		// Set to the user-theme, so there are no surprises
		$this->theme = $this->get_theme( 'user-theme' );
		$this->page( $data );
		$this->wrap = false;
		ob_start();
		include( $this->theme->path . 'index.php' );
		$output = ob_get_clean();
		$this->wrap = true;
		// Restore the previous theme
		$this->theme = $previous_theme;
		return $output;
	}

	public function wp_insert_post_data( $data, $postarr ) {
		// $data is slashed!
		if ( $this->updating_post && ( ( isset( $postarr['ID'] ) && absint( $postarr['ID'] ) === $this->updating_post ) || absint( $data['post_parent'] ) === $this->updating_post ) ) {
			$data['post_content'] = addslashes( $this->export_post_from_data( $this->updating_data ) );
		}
		return $data;
	}

	public function wp_insert_post( $post_id, $post ) {
		if ( $this->updating_post && ( absint( $post_id ) === $this->updating_post || absint( $post->post_parent ) === $this->updating_post ) ) {
			$this->update_post_meta( $post_id, 'data', $this->updating_data );
			$this->update_post_meta( $post_id, 'enabled', true );
			if ( isset( $this->updating_data->theme ) ) {
				$this->update_post_meta( $post_id, 'theme', $this->updating_data->theme );
			}
			if ( absint( $post->post_parent ) === $this->updating_post ) {
				// This is a revision
				foreach( array( 'enabled', 'theme' ) as $key ) {
					$post_value = $this->get_post_meta( $post->post_parent, $key );
					$this->update_post_meta( $post_id, $key, $post_value );
				}
			}
		}
	}

	public function wp_restore_post_revision( $post_id, $revision_id ) {
		foreach( array( 'enabled', 'theme', 'data' ) as $key ) {
			$revision_value = $this->get_post_meta( $revision_id, $key );
			$this->update_post_meta( $post_id, $key, $revision_value );
		}
	}

	public function get_post_meta( $post_id, $key ) {
		$meta_key = $this->meta_key( $key );
		$value = get_metadata( 'post', $post_id, $meta_key, true );
		switch( $key ) {
			case 'enabled':
			case 'demo':
				$value = !! $value;
				break;
		}
		return $value;
	}

	public function update_post_meta( $post_id, $key, $value ) {
		$meta_key = $this->meta_key( $key );
		$delete = false;
		switch ( $key ) {
			case 'enabled':
			case 'demo':
				if ( $value ) {
					$value = 1;
				} else {
					$delete = true;
				}
				break;
			case 'data':
				if ( empty( $value ) ) {
					$delete = true;
				}
				break;
		}
		if ( $delete ) {
			delete_metadata( 'post', $post_id, $meta_key );
		} else {
			// echo "CALLING update_metadata($post_id, $meta_key, value) ";
			update_metadata( 'post', $post_id, $meta_key, $value );
		}
	}

	public function ajax() {
		$post = stripslashes_deep( $_POST );
		switch( $post['method'] ) {
			case 'update':
				if ( ! wp_verify_nonce( $post['_ajax_nonce'], 'velocity-page_' . $post['post_id'] ) ) {
					wp_send_json_error( array( 'message' => 'invalid_nonce' ) );
				}
				$this->updating_post = absint( $post['post_id'] );
				$this->updating_data = json_decode( $post['data'] );
				$p = get_post( absint( $post['post_id'] ) );
				wp_update_post( array(
					'ID' => absint( $post['post_id'] ),
					'post_content' => $p->post_content . '<!--' . time() . '-->',
				));
				$this->updating_post = $this->updating_data = false;
				wp_send_json_success( array( 'message' => 'updated' ) );
				break;
			case 'oembed':
				$oembed = wp_oembed_get( $post['url'] );
				if ( $oembed ) {
					wp_send_json_success( array( 'html' => $oembed ) );
				} else {
					wp_send_json_error( array( 'message' => 'Oembed failure' ) );
				}
				break;
			case 'shortcode':
				$shortcode = do_shortcode( $post['shortcode'] );
				if ( $shortcode ) {
					wp_send_json_success( array( 'html' => $shortcode ) );
				} else {
					wp_send_json_error( array( 'message' => 'Shortcode failure' ) );
				}
				break;
			default:
				wp_send_json_error( array( 'message' => 'unknown_method' ) );
		}
	}

	public function load_theme() {
		$this->hook( 'wp_print_styles' );
		$this->hook( 'loop_start', 'loop_start' );
		$this->hook( 'loop_end', 'loop_end' );
	}

	public function wp_print_styles() {
		if ( 'user-theme' !== $this->theme->slug ) {
			// Dequeue styles that exist in the current theme's stylesheet directory
			foreach ( $GLOBALS['wp_styles']->registered as $handle => $data ) {
				if ( strpos( $data->src, get_stylesheet_directory_uri() ) !== false ) {
					wp_dequeue_style( $handle );
				}
			}
		}
	}

	public function add_theme_scripts_and_styles() {
		// enqueue the theme's styles
		if ( $this->theme ) {
			wp_enqueue_style( self::DASHED_PREFIX . 'theme-' . $this->theme->slug, $this->get_url() . 'themes/' . $this->theme->slug . '/style.css', NULL, '2014-02-03' );
		}

		// enqueue the VP style
		wp_enqueue_style( self::DASHED_PREFIX . 'editor', $this->get_url() . 'css/editor.css', NULL, self::CSS_JS_VERSION );

		// Enqueue external JS libs
		wp_enqueue_script( self::DASHED_PREFIX . 'libs', $this->get_url() . 'js/lib.min.js', array( 'jquery', 'underscore' ), self::CSS_JS_VERSION );

		// enqueue the VP script (editor or normal variant)
		if ( ( $this->page_enabled() || $this->transitioning ) && ( $this->can_edit || $this->demo ) ) {
			wp_enqueue_script( self::DASHED_PREFIX . 'editor', $this->get_url() . 'js/editor.min.js', array( self::DASHED_PREFIX . 'libs', 'jquery-ui-sortable', 'jquery-ui-resizable', 'jquery-ui-slider', 'jquery', 'backbone', 'wp-backbone', 'hoverIntent' ), self::CSS_JS_VERSION );
			if ( $this->can_edit ) {
				require_once( ABSPATH . '/wp-admin/includes/media.php' );
				wp_enqueue_media();
			}
			if ( $this->theme ) {
				$this->hook( 'wp_footer', 'enqueue_js_templates' );
				$this->hook( 'wp_footer', 'enqueue_js_data' );
				$this->hook( 'wp_footer', 'tinymce_toolbar' );
			}
			$this->hook( 'wp_footer', 'control_buttons' );
		} elseif ( $this->can_add ) {
			// enqueue the VP transition script
			wp_enqueue_script( self::DASHED_PREFIX . 'editor', $this->get_url() . 'js/potential-editor.min.js', array( self::DASHED_PREFIX . 'libs', 'jquery', 'underscore' ), self::CSS_JS_VERSION );
			$this->hook( 'wp_footer', 'control_buttons' );
		} else {
			wp_enqueue_script( self::DASHED_PREFIX . 'user', $this->get_url() . 'js/user.min.js', array( self::DASHED_PREFIX . 'libs' ), self::CSS_JS_VERSION );
		}
	}

	public function print_js_template( $id, $object ) {
		echo "\n";
		echo '<script type="text/html" id="tmpl-' . $id . '">';
		$object->render_js();
		echo '</script>';
		echo "\n";
	}

	public function print_control_templates() {
		$this->wrap( "\n" );
		$this->include_file( 'templates/js-controls.php' );
		$this->wrap( "\n" );
	}

	public function enqueue_js_templates() {
		$this->wrap( "\n\n<!-- Velocity Page Templates ======================= -->" );
		$this->print_control_templates();
		$this->print_js_template( 'velocity-page-wrapper', $this->page() );

		$expectations = array();
		foreach ( array( 'row', 'row_area', 'item_area', 'item', 'field' ) as $thing ) {
			$thing_dashed = str_replace( '_', '-', $thing );
			$thing_plural = $thing . 's';
			$expectations[$thing_plural] = array();
			foreach ( $this->{$thing_plural} as $slug => $item ) {
				if ( isset( $item['class'] ) ) {
					$object = new $item['class'];
					$this->print_js_template( $thing_dashed . '-' . $slug, $object );
					if ( $object->get_expectations() ) {
						$expectations[$thing_plural][$slug] = $object->get_expectations();
					}
				}
			}
		}
		$this->wrap( '<script>velocityPageApp.expectations = ' . json_encode( $expectations ) . ';</script>' );
		$this->wrap( '<script>velocityPageApp.devMode = ' . ( isset( $_GET['vp-dev'] ) ? 'true' : 'false' ) . ';</script>' );
		$this->wrap( '<script>velocityPageApp.nonce = ' . json_encode( wp_create_nonce( 'velocity-page_' . get_queried_object_id() ) ) . ';</script>' );
		$this->wrap( "\n\n<!-- =============================================== -->\n\n\n" );
	}

	public function enqueue_js_data() {
		VelocityPage()->page()->js_data();
	}

	public function tinymce_toolbar() {
		$this->include_file( 'templates/tinymce-toolbar.php' );
	}

	public function control_buttons() {
		$this->include_file( 'templates/control-buttons.php' );
	}

	public function init_theme( $theme_object ) {
		$this->theme_object = $theme_object;
	}

	public function page_enabled( $id = null ) {
		if ( is_null( $id ) ) {
			if ( is_page() ) {
				$id = get_queried_object_id();
			} else {
				return false;
			}
		}
		return !! $this->get_post_meta( $id, 'enabled', true );
	}

	public function frontend_add_new_page( $args ) {
		$user = wp_get_current_user();
		$id = wp_insert_post( array_merge( $args, array(
			'post_type' => 'page',
			'post_status' => 'publish',
			'post_author' => $user->ID,
			'post_name' => $args['post_title'],
		)));
		$url = get_permalink( $id );
		wp_redirect( add_query_arg( 'vp-instant-transition', '1', $url ) );
		exit();
	}

	public function template_include( $template ) {
		$this->can_add = current_user_can( 'publish_pages' );
		if ( is_page() ) {
			$this->can_edit = current_user_can( 'edit_page', get_queried_object_id() );
			$this->transitioning = $this->can_edit && isset( $_GET['vp-transition'] );
			$this->enabled = $this->page_enabled();
			$this->demo = $this->get_post_meta( get_queried_object_id(), 'demo' );
		}

		if ( isset( $_POST['vp-action'] ) ) {
			switch ( $_POST['vp-action'] ) {
				case 'addnew':
					if ( $this->can_add ) {
						$this->frontend_add_new_page( array(
							'post_title' => stripslashes( $_POST['vp-addnew-title'] ),
							'post_parent' => stripslashes( $_POST['vp-page-parent'] ),
						));
					}
					break;
			}
		}

		if ( is_page() ) {
			if ( $this->enabled || $this->transitioning ) {
				if ( $this->transitioning ) {
					$theme_slug = $_GET['vp-transition'];
					$this->layout = isset( $_GET['vp-layout'] ) ? $_GET['vp-layout'] : '';
				} else {
					$theme_slug = $this->get_post_meta( get_queried_object_id(), 'theme' );
					if ( ! $theme_slug ) {
						$theme_slug = 'user-theme';
					}
				}
				if ( $theme_slug ) {
					$this->theme = $this->get_theme( $theme_slug );
					if ( $this->theme ) {
						do_action( self::PREFIX . 'load-theme', $theme_slug, $this->theme );
						include_once( $this->theme->path . 'functions.php' );
						do_action( self::PREFIX . 'after-functions', $theme_slug, $this->theme );
						if ( 'user-theme' === $theme_slug ) {
							// Really high because we want to inject last (but shove to front)
							$this->hook( 'post_class', 99999 );
							ob_start();
							include( $this->theme->path . 'index.php' );
							$this->output = ob_get_clean();
							$this->capture_main_loop = true;
						} else {
							// Stop Genesis from double-wrapping our title burrito
							remove_filter( 'wp_title', 'genesis_doctitle_wrap', 20 );

							// Stop Twenty Fourteen from enqueueing its JS that will break our themes
							$this->hook( 'wp_enqueue_scripts', 'dequeue_theme_scripts', 999 );

							$template = $this->theme->path . 'index.php';
						}
					}
				}
			}
		}
		$this->add_theme_scripts_and_styles();
		return $template;
	}

	public function dequeue_theme_scripts() {
		wp_dequeue_script( 'twentyfourteen-script' );
	}

	public function post_class( $classes ) {
		array_unshift( $classes, 'velocity-page-injected' );
		return $classes;
	}

	public function loop_start( $q ) {
		if ( $this->capture_main_loop && $q->is_main_query() ) {
			ob_start();
			echo self::MARKER_START;
		}
	}

	public function loop_end( $q ) {
		if ( $this->capture_main_loop && $q->is_main_query() ) {
			echo self::MARKER_END;
			$output = ob_get_clean();
			echo $this->inject_into_page( $output );
			$this->capture_main_loop = false;
		}
	}

	public function inject_into_page( $content ) {
		preg_match( '#<(div|article)\s*?[^>]+?class=[\'"]velocity-page-injected[^>]+>#i', $content, $matches );
		if ($matches ) {
			// If we find a wrapper div/article element, we go inside that
			return $matches[0] . $this->output . "</{$matches[1]}>";
		} else {
			// Otherwise, replace the whole loop row
			return $this->output;
		}
	}

	public function register_layout( $slug, $info = array() ) {
		$info['slug'] = $slug;
		if ( ! isset( $info['name'] ) ) {
			$info['name'] = $info['slug'];
		}
		$this->layouts[$slug] = (object) $info;
	}

	public function get_layouts() {
		return $this->layouts;
	}

	public function register_theme( $slug, $info = array() ) {
		if ( !isset( $info['path'] ) )
			return $this->doing_it_wrong( __FUNCTION__, sprintf( __( 'You must pass "%s" in the info array.', 'velocitypage'), 'path' ) );

		$info['slug'] = $slug;
		$info['path'] = trailingslashit( $info['path'] );
		$info['url'] = str_replace( $_SERVER['DOCUMENT_ROOT'], '', $info['path'] );
		if ( ! isset( $info['name'] ) ) {
			$info['name'] = $info['slug'];
		}
		$this->themes[$slug] = (object) $info;
	}

	public function get_themes() {
		$themes = $this->themes;
		unset( $themes['user-theme'] );
		return $themes;
	}

	public function register_thing( $thing, $slug, $info = array() ) {
		$thing .= 's'; // Pluralize
		$info['slug'] = $slug;
		$this->{$thing}[$slug] = $info;
		if ( ! isset( $this->{$thing}[$slug]['nicename']) ) {
			$this->{$thing}[$slug]['nicename'] = $slug;
		}
	}

	public function register_row_area( $slug, $info = array() ) {
		$this->register_thing( 'row_area', $slug, $info );
	}

	public function register_item_area( $slug, $info = array() ) {
		$this->register_thing( 'item_area', $slug, $info );
	}

	public function register_row( $slug, $info = array() ) {
		$this->register_thing( 'row', $slug, $info );
	}

	public function register_item( $slug, $info = array() ) {
		$this->register_thing( 'item', $slug, $info );
	}

	public function register_field( $slug, $info = array() ) {
		$this->register_thing( 'field', $slug, $info );
	}

	public function get_thing_class( $thing, $slug ) {
		$thing .= 's'; // Pluralize
		if ( isset( $this->{$thing}[$slug]['class'] ) )
			return $this->{$thing}[$slug]['class'];
		return false;
	}

	public function page( $data = null )  {
		if ( ! is_object( $this->page ) ) {
			if ( is_null( $data ) ) {
				$data = $this->get_post_meta( get_queried_object_id(), 'data' );
			}
			$data = is_object( $data ) ? $data : NULL;
			if ( is_null( $data ) ) {
				$post = get_queried_object();
				$this->page = new AdLabs_VP_Page;
				$this->theme_object->bootstrap_data( $this->page, $post );
			} else {
				$this->page = new AdLabs_VP_Page( $data );
			}
			include_once( $this->theme->path . 'functions.php' );
			$this->theme_object->ensure_data( $this->page );
		}
		return $this->page;
	}

	public function wrap( $output ) {
		if ( $this->wrap ) {
			echo $output;
		}
	}

	/* Internal methods */
	public function get_url() {
		return plugin_dir_url( $this->__FILE__ );
	}

	public function get_path() {
		return plugin_dir_path( $this->__FILE__ );
	}

	protected function get_theme_dir_path() {
		return $this->get_path() . 'themes/';
	}

	public function get_theme_dir_url() {
		return $this->get_url() . 'themes/';
	}

	protected function get_theme( $slug ) {
		if ( isset( $this->themes[$slug] ) )
			return $this->themes[$slug];
	}

	protected function include_file( $file, $data = array() ) {
		extract( $data, EXTR_SKIP );
		include( $this->get_path() . $file );
	}

	protected function meta_key( $key ) {
		return '_' . self::PREFIX . $key;
	}

	protected function doing_it_wrong( $function, $message ) {
		if ( WP_DEBUG && apply_filters( 'doing_it_wrong_trigger_error', true ) ) {
			trigger_error( sprintf( __( '%1$s was called <strong>incorrectly</strong>. %2$s', 'velocitypage'), $function, $message ) );
		}
	}
}
