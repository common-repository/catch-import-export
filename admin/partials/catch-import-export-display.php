<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://catchplugins.com/plugins
 * @since      1.0
 *
 * @package    Catch_Import_Export
 * @subpackage Catch_Import_Export/admin/partials
 */

?>

<div id="catch-import-export" class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Catch Import/Export', 'catch-import-export' ); ?></h1>
	<div id="plugin-description">
		<p><?php esc_html_e( 'Catch Import/Export is a simple and easy-to-use import/export plugin that addresses the need for importing and exporting of customizer settings from any WordPress theme to another website without any exertion.', 'catch-import-export' ); ?></p>
	</div>
	<div class="catchp-content-wrapper">
		<div class="catchp_widget_settings">

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" id="dashboard-tab" href="#dashboard"><?php esc_html_e( 'Dashboard', 'catch-import-export' ); ?></a>
				<a class="nav-tab" id="features-tab" href="#features"><?php esc_html_e( 'Features', 'catch-import-export' ); ?></a>
			</h2>

			<div id="dashboard" class="wpcatchtab  nosave active">

				<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/dashboard-display.php'; ?>
				<div id="ctp-switch" class="content-wrapper col-3 catch-import-export-main">
						<div class="header">
							<h2><?php esc_html_e( 'Catch Themes & Catch Plugins Tabs', 'catch-import-export' ); ?></h2>
						</div> <!-- .Header -->

						<div class="content">

							<p><?php echo esc_html__( 'If you want to turn off Catch Themes & Catch Plugins tabs option in Add Themes and Add Plugins page, please uncheck the following option.', 'catch-import-export' ); ?>
							</p>
							<table>
								<tr>
									<td>
										<?php echo esc_html__( 'Turn On Catch Themes & Catch Plugin tabs', 'catch-import-export' ); ?>
									</td>
									<td>
										<?php $ctp_options = ctp_get_options(); ?>
										<div class="module-header <?php echo $ctp_options['theme_plugin_tabs'] ? 'active' : 'inactive'; ?>">
											<div class="switch">
												<input type="hidden" name="ctp_tabs_nonce" id="ctp_tabs_nonce" value="<?php echo esc_attr( wp_create_nonce( 'ctp_tabs_nonce' ) ); ?>" />
												<input type="checkbox" id="ctp_options[theme_plugin_tabs]" class="ctp-switch" rel="theme_plugin_tabs" <?php checked( true, $ctp_options['theme_plugin_tabs'] ); ?> >
												<label for="ctp_options[theme_plugin_tabs]"></label>
											</div>
											<div class="loader"></div>
										</div>
									</td>
								</tr>
							</table>

						</div>
					</div><!-- #ctp-switch -->

			</div><!-- .dashboard -->

			<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/features-display.php'; ?>


		</div><!-- .catchp_widget_settings -->
		<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/sidebar.php'; ?>

	</div> <!-- .catchp-content-wrapper -->

	<?php require_once plugin_dir_path( dirname( __FILE__ ) ) . '/partials/footer.php'; ?>

</div><!-- .wrap -->
