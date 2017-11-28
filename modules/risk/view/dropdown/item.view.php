<?php
/**
 * Affiches la catégorie de risque d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="categorie-container toggle grid padding">
	<div class="action">
		<div class="tooltip hover" aria-label="<?php echo esc_attr( $risk->risk_category->name ); ?>">
			<?php echo wp_get_attachment_image( $risk->risk_category->thumbnail_id, 'thumbnail', false ); ?>
		</div>
		<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo esc_attr( $risk->risk_category->id ); ?>' />
	</div>
</div>
