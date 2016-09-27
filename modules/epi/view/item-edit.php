<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<li class="wp-digi-list-item">
		<input name="epi[<?php echo $epi->id; ?>][id]" type="hidden" value="<?php echo $epi->id; ?>" />
		<?php echo do_shortcode( '[eo_upload_button id="' . $epi->id . '" type="epi"]' ); ?>
		<span class="padded"><?php echo $epi->unique_identifier; ?></span>
		<span class="padded"><input type="text" name="epi[<?php echo $epi->id; ?>][title]" value="<?php echo $epi->title; ?>" placeholder="Nom" /></span>
		<span class="padded"><input type="text" name="epi[<?php echo $epi->id; ?>][serial_number]" value="<?php echo $epi->serial_number; ?>" placeholder="Numéro de série" /></span>
		<span class="padded"><input type="text" name="epi[<?php echo $epi->id; ?>][frequency_control]" value="<?php echo $epi->frequency_control; ?>" placeholder="10" /></span>
		<span class="padded"><input type="text" class="wpdigi_date" name="epi[<?php echo $epi->id; ?>][control_date]" value="<?php echo $epi->control_date; ?>" placeholder="Date de contrôle" /></span>
		<span class="padded"><?php echo $epi->compiled_remaining_time; ?></span>
		<span class="wp-digi-epi-action wp-digi-action-new wp-digi-action" >
			<?php
			if ( empty( $epi->id ) ):
				?>
				<a href="#" class="wp-digi-action dashicons dashicons-plus" ></a>
				<?php
			else:
				?>
				<a href="#" data-id="<?php echo $epi->id; ?>" class="wp-digi-action wp-digi-action-edit fa fa-floppy-o" aria-hidden="true" ></a>
				<?php
			endif;
			?>
		</span>
</li>
