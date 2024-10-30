<?php
	
/**
 * A class that extends WP_Customize_Setting so we can access
 * the protected updated method when importing options.
 *
 * @since 1.0
 */

final class Catch_Import_Export_Option extends WP_Customize_Setting {
	
	/**
	 * Import an option value for this setting.
	 *
	 * @since 1.0
	 * @param mixed $value The option value.
	 * @return void
	 */
	public function import( $value ) 
	{
		$this->update( $value );	
	}
}