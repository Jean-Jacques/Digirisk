<?php
/**
 * Etape du liste des intervenants
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
	$legal_display = Legal_Display_Class::g()->get( array(
		'posts_per_page' => 1
	), true );

	if ( empty( $legal_display ) ) {
		$legal_display = Legal_Display_Class::g()->get( array(
			'schema' => true,
		), true );
	}
?>
<div class="information-society" style="background-color: #fff; padding: 1em;">
	<h2>
		<?php esc_html_e( 'Information société extérieure', 'digirisk' ); ?>
		<span class="wpeo-tooltip-event"
		aria-label="<?php esc_html_e( 'Information de la société intervenante', 'digirisk' ); ?>"
		style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>
	<section class="wpeo-gridlayout padding grid-4" style="margin-bottom: 10px;">
		<div class="wpeo-form">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Nom de l\'entreprise', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="far fa-building"></i></span>
					<input type="text" class="form-field" name="outside_name" value="<?php echo esc_attr( $prevention->data[ 'society_outside' ][ 'name' ] ); ?>">
				</label>
			</div>
		</div>

		<div class="wpeo-form">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Numero Siret', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<input type="text" class="form-field" name="outside_siret" value="<?php echo esc_attr( $prevention->data[ 'society_outside' ][ 'siret' ] ); ?>">
				</label>
			</div>
		</div>
	</section>
	<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
		<div class="wpeo-form">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Adresse', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-map-marker-alt"></i></span>
						<input type="text" class="form-field" name="outside_address" value="<?php echo esc_attr( $prevention->data[ 'society_outside' ][ 'address' ] ); ?>">
				</label>
			</div>
		</div>
		<section class="wpeo-gridlayout padding grid-2" style="margin-bottom: 10px;">
			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Code Postal', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<input type="text" class="form-field" name="outside_postalcode" value="<?php echo esc_attr( $prevention->data[ 'society_outside' ][ 'postal' ] ); ?>">
					</label>
				</div>
			</div>
			<div class="wpeo-form">
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Ville', 'digirisk' ); ?></span>
					<label class="form-field-container">
						<input type="text" class="form-field" name="outside_town" value="<?php echo esc_attr( $prevention->data[ 'society_outside' ][ 'town' ] ); ?>">
					</label>
				</div>
			</div>
		</section>


	</section>

	<div class="intervenant-bloc">
	   <h2>
		   <?php esc_html_e( 'Liste des intervenants extérieurs', 'digirisk' ); ?>
		   <span class="wpeo-tooltip-event"
		   aria-label="<?php esc_html_e( 'Liste des intervenants du plan de prévention', 'digirisk' ); ?>"
		   style="color : dodgerblue; cursor : pointer">
			   <i class="fas fa-info-circle"></i>
		   </span>
		   <a class="page-title-action wpeo-tooltip-event display-line-intervenant"
			aria-label="<?php esc_html_e( 'Ajouter un intervenant', 'digirisk' ); ?>"
			style="margin-left: 5px; height: 100%; margin-top: 24px;">
			   <?php esc_html_e( 'Nouveau', 'digirisk' ); ?>
		   </a>
	   </h2>
		<?php Prevention_Class::g()->display_list_intervenant( $prevention->data['id'] ); ?>
	</div>
</div>

