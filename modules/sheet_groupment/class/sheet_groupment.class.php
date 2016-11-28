<?php
/**
 * Gères la génération de la fiche de groupement
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères la génération de la fiche de groupement
 */
class Sheet_Groupment_Class extends Singleton_Util {

	/**
	 * Le constructeur est obligatoire pour étendre la classe Singleton_Util
	 *
	 * @return void
	 */
	protected function construct() {}

	/**
	 * Cette méthode génère la fiche de groupement
	 *
	 * @param  int $element_id L'ID de la société.
	 *
	 * @return Fiche_De_Groupement_Model L'objet généré par cette méthode
	 */
	public function generate_sheet( $element_id ) {
		$response = array(
			'status' 	=> true,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'digirisk' ),
			'link'		=> null,
		);

		$group = society_class::g()->show_by_type( $element_id, array( 'list_risk', 'list_workunit', 'comment', 'evaluation_method', 'evaluation', 'danger_category', 'danger' ) );

		$picture = __( 'No picture defined', 'digirisk' );
		if ( ! empty( $group->thumbnail_id ) && ( true === is_int( $group->thumbnail_id ) ) ) {
			$picture_definition = wp_get_attachment_image_src( $group->thumbnail_id, 'full' );
			$picture_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] );
			if ( is_file( $picture_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> str_replace( site_url( '/' ), ABSPATH, $picture_definition[0] ),
					'option'	=> array(
						'size'	=> 8,
					),
				);
			}
		}

		/**	Définition des informations de l'adresse de l'unité de travail / Define informations about workunit address	*/
		$option['address'] = $option['postcode'] = $option['town'] = '-';
		if ( ! empty( $group->contact['address'] ) && ( true === is_int( $group->contact['address'] ) ) ) {
			$work_unit_address_definition = address_class::g()->get( array( 'id' => $group->contact['address'][0] ) );
		}

		/**	Définition finale de l'unité de travail / Final definition for group	*/
		$group_sheet_details = array(
			'reference'			=> $group->unique_identifier,
			'nom'						=> $group->title,
			'photoDefault'	=> $picture,
			'description'		=> $group->content,
			'adresse'				=> $option['address'],
			'telephone'			=> implode( ', ', $group->contact['phone'] ),
		);

		/**	Ajout des utilisateurs dans le document final / Add affected users' into final document	*/
		$group_sheet_details['utilisateursAffectes'] = $group_sheet_details['utilisateursDesaffectes'] = array( 'type' => 'segment', 'value' => array() );
		$affected_users = $unaffected_users = null;
		if ( ! empty( $group->user_info['affected_id']['user'] ) ) {
			$user_affectation_for_export = user_digi_class::g()->build_list_for_document_export( $group->user_info['affected_id']['user'] );
			if ( null !== $user_affectation_for_export ) {
				$group_sheet_details['utilisateursAffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['affected'],
				);
				$group_sheet_details['utilisateursDesaffectes'] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export['unaffected'],
				);
			}
		}

		/**	Ajout des personnes présentes lors de l'évaluation dans le document final / Add users' who were present when evaluation have been done into final document	*/
		$group_sheet_details['utilisateursPresents'] = array( 'type' => 'segment', 'value' => array() );
		$affected_users = $unaffected_users = null;
		if ( ! empty( $group->user_info['affected_id']['evaluator'] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = evaluator_class::g()->get_list_affected_evaluator( $group );
			if ( ! empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' === $evaluator_affectation_info['affectation_info']['status'] ) {
							$affected_users[] = array(
								'idUtilisateur'			=> evaluator_class::g()->element_prefix . $evaluator_affectation_info['user_info']->id,
								'nomUtilisateur'		=> $evaluator_affectation_info['user_info']->lastname,
								'prenomUtilisateur'	=> $evaluator_affectation_info['user_info']->firstname,
								'dateEntretien'			=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info['affectation_info']['start']['date'], true ),
								'dureeEntretien'		=> evaluator_class::g()->get_duration( $evaluator_affectation_info['affectation_info'] ),
							);
						}
					}
				}

				$group_sheet_details['utilisateursPresents'] = array(
					'type'	=> 'segment',
					'value'	=> $affected_users,
				);
			}
		}

		/**	Construction de l'affichage des risques dans la fiche imprimée / Build risks display into printed sheet	*/
		$group_sheet_details['risq80'] = $group_sheet_details['risq51'] = $group_sheet_details['risq48'] = $group_sheet_details['risq'] = array( 'type' => 'segment', 'value' => array() );
		/**	On récupère la définition des risques associés à l'unité de travail / Get definition of risks associated to group	*/

		$risk_list_to_order = array();
		foreach ( $group->list_risk as $risk ) {
			$comment_list = '';
			if ( ! empty( $risk->comment ) ) :
				foreach ( $risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$risk_list_to_order[ $risk->evaluation[0]->scale ][] = array(
				'nomDanger'					=> $risk->danger_category[0]->danger[0]->name,
				'identifiantRisque'	=> $risk->unique_identifier . '-' . $risk->evaluation[0]->unique_identifier,
				'quotationRisque'		=> $risk->evaluation[0]->risk_level['equivalence'],
				'commentaireRisque'	=> $comment_list,
			);
		}
		krsort( $risk_list_to_order );

		if ( ! empty( $risk_list_to_order ) ) {
			$result_treshold = scale_util::get_scale( 'score' );
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = ! empty( evaluation_method_class::g()->list_scale[ $risk_level ] ) ? evaluation_method_class::g()->list_scale[ $risk_level ] : '';
				$group_sheet_details[ 'risq' . $final_level ]['value'] = $risk_for_export;
			}
		}

		/**	Permet d'étendre les donnée que l'on souhaite intégrer au document / Allows to extend data we want to send to the final document	*/
		$group_sheet_details = apply_filters( 'wpdigi_group_sheet_details', $group_sheet_details );

		/**	Call document creation function / Appel de la fonction de création du document	*/
		$document_creation_response = document_class::g()->create_document( $group, array( 'fiche_de_groupement' ), $group_sheet_details );
		if ( ! empty( $document_creation_response['id'] ) ) {
			$group->associated_document_id['document'][] = $document_creation_response['id'];
			$group = group_class::g()->update( $group );
		}

		return $document_creation_response;
	}

}

sheet_groupment_class::g();
