<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://catchplugins.com/plugins
 * @since      1.0
 *
 * @package    Catch_Import_Export
 * @subpackage Catch_Import_Export/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Catch_Import_Export
 * @subpackage Catch_Import_Export/admin
 * @author     Catch Plugins
 */
class Catch_Import_Export_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * An array of core options that shouldn't be imported.
	 *
	 * @since 1.0
	 * @access private
	 * @var array $core_options
	 */
	static private $core_options = array(
		'blogname',
		'blogdescription',
		'show_on_front',
		'page_on_front',
		'page_for_posts',
	);

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catch_Import_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catch_Import_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
	*	 */

		if( isset( $_GET['page'] ) && 'catch-import-export' == $_GET['page'] ) {
			
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin-dashboard.css', array(), $this->version, 'all' );
		
		}

			wp_enqueue_style( $this->plugin_name . '-customizer', plugin_dir_url( __FILE__ ) . 'css/customizer.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Catch_Import_Export_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Catch_Import_Export_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/catch-import-export-admin.js', array( 'jquery', 'matchHeight' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name . '-customizer', plugin_dir_url( __FILE__ ) . 'js/customizer.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( 'matchHeight', plugin_dir_url( __FILE__ ) . 'js/jquery-matchHeight.min.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name . '-customizer', 'CIEConfig', array(
			'customizerURL'	  => admin_url( 'customize.php' ),
			'exportNonce'	  => wp_create_nonce( 'cie-exporting' )
		));
			
		// Localize
		wp_localize_script( $this->plugin_name . '-customizer', 'CIEl10n', array(
			'emptyImport'	=> __( 'Please choose a file to import.', 'catch-import-export' )
		));
		wp_localize_script( $this->plugin_name, 'CIEl10n', array(
			'emptyImport'	=> __( 'Please choose a file to import.', 'catch-import-export' )
		));
	}

	/**
	 * Catch Import/Export: action_links
	 * Catch Import/Export Settings Link function callback
	 *
	 * @param arrray $links Link url.
	 *
	 * @param arrray $file File name.
	 */
	public function action_links( $links, $file ) {
		if ( $file === $this->plugin_name . '/' . $this->plugin_name . '.php' ) {
			$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=catch-import-export' ) ) . '">' . esc_html__( 'Settings', 'catch-import-export' ) . '</a>';

			array_unshift( $links, $settings_link );
		}
		return $links;
	}


	public function add_plugin_settings_menu() {
		// Add Main Menu
		add_menu_page(
			esc_html__( 'Catch Import/Export', 'catch-import-export' ), // $page_title.
			esc_html__( 'Catch Import/Export', 'catch-import-export' ), // $menu_title.
			'manage_options', // $capability.
			'catch-import-export', // $menu_slug.
			array( $this, 'settings_page' ), // $callback_function.
			'dashicons-migrate', // $icon_url.
			'99.01564' // $position.
		);	
	}

	public function settings_page( $wp_customize ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.' ) );
		}

		require plugin_dir_path( __FILE__ ) . 'partials/catch-import-export-display.php';
	}

	public function customize_options( $wp_customize ) {
		require_once plugin_dir_path( __FILE__ ) . 'classes/class-catch-import-export-control.php';

		// Add the export/import section.
		$wp_customize->add_section( 'cie-section', array(
			'title'	   => __( 'Catch Import/Export', 'catch-import-export' ),
			'priority' => 10000000
		));
		
		// Add the export/import setting.
		$wp_customize->add_setting( 'cie-setting', array(
			'default' => '',
			'type'	  => 'none'
		));
		
		// Add the export/import control.
		$wp_customize->add_control( new Catch_Import_Export_Control( 
			$wp_customize, 
			'cie-setting', 
			array(
				'section'	=> 'cie-section',
				'priority'	=> 1
			)
		));
	}

	function add_plugin_meta_links( $meta_fields, $file ){
		if( CATCH_IMPORT_EXPORT_BASENAME == $file ) {
			$meta_fields[] = "<a href='https://catchplugins.com/support-forum/forum/catch-import-export/' target='_blank'>Support Forum</a>";
			$meta_fields[] = "<a href='https://wordpress.org/support/plugin/catch-import-export/reviews#new-post' target='_blank' title='Rate'>
			        <i class='ct-rate-stars'>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
			  . "</i></a>";

			$stars_color = "#ffb900";

			echo "<style>"
				. ".ct-rate-stars{display:inline-block;color:" . $stars_color . ";position:relative;top:3px;}"
				. ".ct-rate-stars svg{fill:" . $stars_color . ";}"
				. ".ct-rate-stars svg:hover{fill:" . $stars_color . "}"
				. ".ct-rate-stars svg:hover ~ svg{fill:none;}"
				. "</style>";
		}

		return $meta_fields;
	}

	/**
	 * Prints scripts for the control.
	 *
	 * @since 1.0
	 * @return void
	 */
	static public function controls_print_scripts() 
	{	
		global $cie_error, $settings_page;

		if ( $cie_error ) {			
			if( $settings_page ) {
				$url = admin_url( 'admin.php?page=catch-import-export' );
				echo '<script> alert("' . $cie_error . '"); window.location.href = "' . $url . '"; </script>';
			} else{
				echo '<script> alert("' . $cie_error . '"); </script>';
			}
		}

	}	

	/**
	 * Export customizer settings.
	 *
	 * @since 1.0
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _export( $wp_customize )
	{	
		if ( ! wp_verify_nonce( $_REQUEST['cie-export'], 'cie-exporting' ) ) {
			return;
		}
		
		$theme		= get_stylesheet();
		$template	= get_template();
		$charset	= get_option( 'blog_charset' );
		$mods		= get_theme_mods();
		$data		= array(
						  'template'  => $template,
						  'mods'	  => $mods ? $mods : array(),
						  'options'	  => array()
					  );

		// Get options from the Customizer API.
		$settings = $wp_customize->settings();

		foreach ( $settings as $key => $setting ) {

			if ( 'option' == $setting->type ) {

				// Don't save widget data.
				if ( stristr( $key, 'widget_' ) ) {
					continue;
				}

				// Don't save sidebar data.
				if ( stristr( $key, 'sidebars_' ) ) {
					continue;
				}

				// Don't save core options.
				if ( in_array( $key, self::$core_options ) ) {
					continue;
				}

				$data['options'][ $key ] = $setting->value();
			}
		}

		// Plugin developers can specify additional option keys to export.
		$option_keys = apply_filters( 'cie_export_option_keys', array() );

		foreach ( $option_keys as $option_key ) {

			$option_value = get_option( $option_key );

			if ( $option_value ) {
				$data['options'][ $option_key ] = $option_value;
			}
		}

		if( function_exists( 'wp_get_custom_css_post' ) ) {
			$data['wp_css'] = wp_get_custom_css();
		}

		// Set the download headers.
		header( 'Content-disposition: attachment; filename=' . $theme . '-export.dat' );
		header( 'Content-Type: application/octet-stream; charset=' . $charset );

		// Serialize the export data.
		echo serialize( $data );

		// Start the download.
		die('');
	}

	/**
	 * Imports uploaded mods and calls WordPress core customize_save actions so
	 * themes that hook into them can act before mods are saved to the database.
	 *
	 * @since 1.0
	 * @access private
	 * @param object $wp_customize An instance of WP_Customize_Manager.
	 * @return void
	 */
	static private function _import( $wp_customize )
	{
		// Make sure we have a valid nonce.
		if ( ! wp_verify_nonce( $_REQUEST['cie-import'], 'cie-importing' ) ) {
			return;
		}
		
		// Make sure WordPress upload support is loaded.
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
		
		// Load the export/import option class.
		require_once plugin_dir_path( __FILE__ ) . 'classes/class-catch-import-export-option.php';
		
		// Setup global vars.
		global $wp_customize;
		global $cie_error;
		global $settings_page;
		
		// Setup internal vars.
		$settings_page = false;
		$cie_error     = false;
		$template      = get_template();
		$overrides     = array( 'test_form' => false, 'test_type' => false, 'mimes' => array('dat' => 'text/plain') );
		$file          = wp_handle_upload( $_FILES['cie-import-file'], $overrides );
		
		// Make sure the form is submitted through admin settings page.
		if( isset( $_REQUEST['settings-page'] ) && true == $_REQUEST['settings-page'] ){
			$settings_page = true;
		}

		// Make sure we have an uploaded file.
		if ( isset( $file['error'] ) ) {
			$cie_error = $file['error'];
			return;
		}
		if ( ! file_exists( $file['file'] ) ) {
			$cie_error = __( 'Error importing settings! Please try again.', 'catch-import-export' );
			return;
		}
		
		// Get the upload data.
		$raw  = file_get_contents( $file['file'] );
		$data = @unserialize( $raw );
		
		// Remove the uploaded file.
		unlink( $file['file'] );
		

		// Data checks.
		if ( 'array' != gettype( $data ) ) {
			$cie_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'catch-import-export' );
			return;
		}
		if ( ! isset( $data['template'] ) || ! isset( $data['mods'] ) ) {
			$cie_error = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'catch-import-export' );
			return;
		}
		if ( $data['template'] != $template ) {
			$cie_error = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'catch-import-export' );
			return;
		}
		
		// Import images.
		if ( isset( $_REQUEST['cie-import-images'] ) ) {
			$data['mods'] = self::_import_images( $data['mods'] );
		}
		
		// Import custom options.
		if ( isset( $data['options'] ) ) {
			
			foreach ( $data['options'] as $option_key => $option_value ) {
				
				$option = new Catch_Import_Export_Option( $wp_customize, $option_key, array(
					'default'		=> '',
					'type'			=> 'option',
					'capability'	=> 'edit_theme_options'
				) );

				$option->import( $option_value );
			}
		}

		// If wp_css is set then import it.
		if( function_exists( 'wp_update_custom_css_post' ) && isset( $data['wp_css'] ) && '' !== $data['wp_css'] ) {
			wp_update_custom_css_post( $data['wp_css'] );
		}

		// Call the customize_save action.
		do_action( 'customize_save', $wp_customize );

		// Loop through the mods.
		foreach ( $data['mods'] as $key => $val ) {

			// Call the customize_save_ dynamic action.
			do_action( 'customize_save_' . $key );

			// Save the mod.
			set_theme_mod( $key, $val );
		}

		// Call the customize_save_after action.
		do_action( 'customize_save_after', $wp_customize );
		if( isset( $_REQUEST['settings-page'] ) && true == $_REQUEST['settings-page'] ){
			$url = admin_url( 'admin.php?page=catch-import-export' );
			wp_redirect( esc_url( $url ) );
			exit;
		}
	}

	/**
	 * Imports images for settings saved as mods.
	 *
	 * @since 1.0
	 * @access private
	 * @param array $mods An array of customizer mods.
	 * @return array The mods array with any new import data.
	 */
	static private function _import_images( $mods ) 
	{
		foreach ( $mods as $key => $val ) {
			
			if ( self::_is_image_url( $val ) ) {
				
				$data = self::_sideload_image( $val );
				
				if ( ! is_wp_error( $data ) ) {
					
					$mods[ $key ] = $data->url;
					
					// Handle header image controls.
					if ( isset( $mods[ $key . '_data' ] ) ) {
						$mods[ $key . '_data' ] = $data;
						update_post_meta( $data->attachment_id, '_wp_attachment_is_custom_header', get_stylesheet() );
					}
				}
			}
		}
		
		return $mods;
	}
	
	/**
	 * Taken from the core media_sideload_image function and
	 * modified to return an array of data instead of html.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $file The image file path.
	 * @return array An array of image data.
	 */
	static private function _sideload_image( $file ) 
	{
		$data = new stdClass();
		
		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}
		if ( ! empty( $file ) ) {
			
			// Set variables for storage, fix file filename for query strings.
			preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );
			$file_array = array();
			$file_array['name'] = basename( $matches[0] );
	
			// Download file to temp location.
			$file_array['tmp_name'] = download_url( $file );
	
			// If error storing temporarily, return the error.
			if ( is_wp_error( $file_array['tmp_name'] ) ) {
				return $file_array['tmp_name'];
			}
	
			// Do the validation and storage stuff.
			$id = media_handle_sideload( $file_array, 0 );
	
			// If error storing permanently, unlink.
			if ( is_wp_error( $id ) ) {
				@unlink( $file_array['tmp_name'] );
				return $id;
			}
			
			// Build the object to return.
			$meta					= wp_get_attachment_metadata( $id );
			$data->attachment_id	= $id;
			$data->url				= wp_get_attachment_url( $id );
			$data->thumbnail_url	= wp_get_attachment_thumb_url( $id );
			$data->height			= $meta['height'];
			$data->width			= $meta['width'];
		}
	
		return $data;
	}
	
	/**
	 * Checks to see whether a string is an image url or not.
	 *
	 * @since 1.0
	 * @access private
	 * @param string $string The string to check.
	 * @return bool Whether the string is an image url or not.
	 */
	static private function _is_image_url( $string = '' ) 
	{
		if ( is_string( $string ) ) {
			
			if ( preg_match( '/\.(jpg|jpeg|png|gif)/i', $string ) ) {
				return true;
			}
		}
		
		return false;
	}

	static public function init( $wp_customize ) 
	{
		if ( current_user_can( 'edit_theme_options' ) ) {
			
			if ( isset( $_REQUEST['cie-export'] ) ) {
				self::_export( $wp_customize );
			}
			if ( isset( $_REQUEST['cie-import'] ) && isset( $_FILES['cie-import-file'] ) ) {
				self::_import( $wp_customize );
			}
		}
	}

}
