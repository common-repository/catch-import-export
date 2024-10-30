<?php

/**
 * A customizer control for rendering the export/import form.
 *
 * @since 1.0
 */
final class Catch_Import_Export_Control extends WP_Customize_Control {
	
	/**
	 * Renders the control content.
	 *
	 * @since 1.0
	 * @access protected
	 * @return void
	 */
	protected function render_content()
	{
		include plugin_dir_path( __FILE__ ) . 'control.php';
	}
}