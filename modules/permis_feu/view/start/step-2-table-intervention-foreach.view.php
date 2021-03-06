<?php
/**
 * Evaluation d'une causerie: étape 2, permet d'afficher les images associées à la causerie dans un format "slider".
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

 <table class="table intervention">
 	<thead>
 		<tr>
			<th class="w100 padding"><?php esc_html_e( 'IdRPP', 'digirisk' ); ?></th> <!--  class="w50 padding" -->
			<th class="padding" style="width: 15%;"><?php esc_html_e( 'Unité de travail', 'digirisk' ); ?></th> <!--  class="w50 padding" -->
			<th class="padding"><?php esc_html_e( 'Description des actions réalisées', 'digirisk' ); ?></th>
			<th class="w100 padding" ><?php esc_html_e( 'Risque IRNF', 'digirisk' ); ?></th>
 			<th class="padding"><?php esc_html_e( 'Matériels utilisés', 'digirisk' ); ?></th> <!--  class="w50" -->
			<th class="w50 padding"></th> <!--  DL unité de travail -->
			<th class="w50 padding"></th> <!--  Modification de la ligne -->
 			<th class="w50 padding"></th> <!--  Suppression de la ligne -->
 		</tr>
 	</thead>
 	<tbody>
 		<?php
 		if ( ! empty( $interventions ) ) :
 			foreach ( array_reverse( $interventions ) as $intervention ) :
 				\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-foreach-item', array(
 					'intervention' => $intervention
 				) );
 			endforeach;
 		endif;
 		?>
 	</tbody>
 	<tfoot>
 		<?php
 		\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-edit', array(
 			'permis_feu' => $permis_feu,
			'new_line'   => true
 		) );
 		?>
 	</tfoot>
 </table>
