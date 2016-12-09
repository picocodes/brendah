/**
 * Live-update changed settings in real time in the Customizer preview.
 */

( function( $ ) {	
	
	'use strict';
		
	var css_box = $( '#brendah-style-inline-css' ), 
		api = wp.customize;
	
	if ( ! css_box.length ) {
		css_box = $( 'head' ).append( '<style type="text/css" id="brendah-style-inline-css" />' )
		                    .find( '#brendah-style-inline-css' );
	}
	
	// Site title and description.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	
	// Sidebar
	api( 'sidebar', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( 'no-sidebar left-sidebar right-sidebar' )
				.addClass( to );
		} );
	} );
	
	// Color CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-css', function( css ) {
			css_box.html( css );
		} );
	} );
	
} )( jQuery );
