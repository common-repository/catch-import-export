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
<div id="catch-import-export">

    <?php if( isset($_GET['settings-updated']) ) { ?>
        <div id="message" class="notice updated fade">
            <p><strong><?php esc_html_e( 'Plugin Options Saved.', 'catch-import-export' ) ?></strong></p>
        </div>
    <?php } ?>

    <?php // Use nonce for verification.
        wp_nonce_field( basename( __FILE__ ), 'catch_import_export_nounce' );
    ?>

    <div id="catch_import_export_main">
        <div class="content-wrapper">
            <div class="header">
                <h2><?php esc_html_e( 'Settings', 'catch-import-export' ); ?></h2>
            </div> <!-- .Header -->
            <div class="content">
                <span class="customize-control-title">
                    <?php _e( '<h3>Export</h3>', 'catch-import-export' ); ?>
                </span>
                <span class="description customize-control-description">
                    <?php _e( 'Click the button below to export the customization settings for this theme.', 'catch-import-export' ); ?>
                </span>
                <p>
                <input type="button" class="button" name="cie-export-button" value="<?php esc_attr_e( 'Export', 'catch-import-export' ); ?>" />
                </p>

                <hr class="cie-hr" />
                
                <form id="catch-import-export-settings" action="<?php echo admin_url( 'customize.php' ) . '?settings-page=true&cie-import=' . wp_create_nonce( 'cie-importing' ); ?>" method="POST" enctype="multipart/form-data">
                    <span class="customize-control-title">
                        <?php _e( '<h3>Import</h3>', 'catch-import-export' ); ?>
                    </span>
                    <span class="description customize-control-description">
                        <?php _e( 'Upload a file to import customization settings for this theme.', 'catch-import-export' ); ?>
                    </span>
                    <div class="cie-import-controls">
                        <input type="file" name="cie-import-file" class="cie-import-file" />
                        <label class="cie-import-images">
                            <input type="checkbox" name="cie-import-images" value="1" /> <?php _e( 'Download and import image files?', 'catch-import-export' ); ?>
                        </label>
                    </div>
                    <div class="cie-uploading"><?php _e( 'Uploading...', 'catch-import-export' ); ?></div>
                    <input type="submit" class="button" value="<?php esc_attr_e( 'Import', 'catch-import-export' ); ?>" />
                </form>
            </div><!-- .content -->
        </div><!-- .content-wrapper -->
    </div><!-- #catch_infinite_scroll_main -->
</div><!-- .wrap -->