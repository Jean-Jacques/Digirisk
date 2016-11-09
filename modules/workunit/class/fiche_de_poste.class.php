<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class fiche_de_poste_class extends document_class {

	protected $model_name   				= '\digi\fiche_de_poste_model';
	protected $post_type    				= 'attachment';
	public $attached_taxonomy_type  = 'attachment_category';
	protected $meta_key    					= '_wpdigi_document';
	protected $base 								= 'digirisk/fiche-de-poste';
	protected $version 							= '0.1';
	public $element_prefix 					= 'FP';
	protected $before_put_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche de poste';

	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

}

fiche_de_poste_class::g();
