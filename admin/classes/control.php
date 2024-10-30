<span class="customize-control-title">
	<?php _e( 'Export', 'catch-import-export' ); ?>
</span>
<span class="description customize-control-description">
	<?php _e( 'Click the button below to export the customization settings for this theme.', 'catch-import-export' ); ?>
</span>
<input type="button" class="button" name="cie-export-button" value="<?php esc_attr_e( 'Export', 'catch-import-export' ); ?>" />

<hr class="cie-hr" />

<span class="customize-control-title">
	<?php _e( 'Import', 'catch-import-export' ); ?>
</span>
<span class="description customize-control-description">
	<?php _e( 'Upload a file to import customization settings for this theme.', 'catch-import-export' ); ?>
</span>
<div class="cie-import-controls">
	<input type="file" name="cie-import-file" class="cie-import-file" />
	<label class="cie-import-images">
		<input type="checkbox" name="cie-import-images" value="1" /> <?php _e( 'Download and import image files?', 'catch-import-export' ); ?>
	</label>
	<?php wp_nonce_field( 'cie-importing', 'cie-import' ); ?>
</div>
<div class="cie-uploading"><?php _e( 'Uploading...', 'catch-import-export' ); ?></div>
<input type="button" class="button" name="cie-import-button" value="<?php esc_attr_e( 'Import', 'catch-import-export' ); ?>" />