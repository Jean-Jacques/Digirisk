"use strict";

var digi_installer = {
	$: undefined,
	event: function($) {
		digi_installer.$ = $;
		digi_installer_user.event( $ );
		digi_installer.$( document ).on( 'click', '.wpdigi-installer form input[type="button"]', function() { digi_installer.form_groupement( digi_installer.$( this ) ); } );
		digi_installer.$( document ).on( 'click', '.wpdigi-staff .more-option', function( event ) { digi_installer.toggle_form( event, digi_installer.$( this ) ); } );

		digi_installer.$( document ).on( 'keyup', '.wpdigi-staff .input-domain-mail', function( event ) { digi_installer.keyp_update_email( event, digi_installer.$( this ) ); } );
		digi_installer.$( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][lastname]"]', function( event ) { digi_installer.keyp_update_email( event, digi_installer.$( this ) ); } );
		digi_installer.$( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][firstname]"]', function( event ) { digi_installer.keyp_update_email( event, digi_installer.$( this ) ); } );
    digi_installer.$( document ).on( 'click', '.wp-digi-action-save-domain-mail', function( event ) { digi_installer.save_domain_mail( event, digi_installer.$( this ) ); } );
  },

	form_groupement: function( element ) {
		digi_installer.$( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				if ( digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).val() === '' ) {
					digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', 'solid red 2px' );
					return false;
				}

				digi_installer.$( element ).closest( 'div' ).addClass( "wp-digi-bloc-loading" );
				digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', '2px solid #272a35' );
			},
			'success': function( response ) {
				digi_installer.$( element ).closest( 'div' ).hide();
				digi_installer.$( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
				digi_installer.$( '.wpdigi-installer ul.step li:first' ).removeClass( 'active' );
				digi_installer.$( '.wpdigi-installer ul.step li:last' ).addClass( 'active' );
	      digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href', digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
	    }
		} );

  },

	keyp_update_email: function( event, element ) {
		digi_installer.$( ".wpdigi-staff input[name='user[email]']" ).val( digi_installer.$( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val() + '.' + digi_installer.$( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val() + '@' + digi_installer.$( '.wpdigi-staff .input-domain-mail' ).val() );
		if( event.keyCode == 13 ) {
			digi_installer.$( ".wpdigi-staff .add-staff" ).click();
		}
	},

  save_domain_mail: function( event, element ) {
    event.preventDefault();

    var data = {
      action: 'save_domain_mail',
      _wpnonce: digi_installer.$( element ).data( 'nonce' ),
      domain_mail: digi_installer.$( element ).closest( '.form-element' ).find( 'input' ).val(),
    };

    digi_installer.$.post( window.ajaxurl, data, function() { } );
  },

	save_last_step: function( event, element ) {
		digi_installer.$( '.wpdigi-installer .dashicons-plus:last' ).click();
	},

  toggle_form: function( event, element ) {
    event.preventDefault();

		digi_installer.$( element ).find( '.dashicons' ).toggleClass( 'dashicons-plus dashicons-minus' );
    digi_installer.$( element ).closest( 'form' ).find( '.form-more-option' ).toggle();
  }
};
