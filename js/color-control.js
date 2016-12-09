/**
 * Add a listener to the Primary color control to update background value
 * Also trigger an update of the Color CSS when a color is changed.
 */

( function( api ) {
	var cssTemplate = wp.template( 'brendah-colors' );

	// Generate the CSS
	function updateCSS(pri, sec) {
			var colors = {
				primary_color : pri,
				secondary_color : sec,
			}	
			
			api.previewer.send( 'update-color-css', cssTemplate( colors) );
		}

						
	// Primary Color
	api( 'primary_color', function( value ) {
		value.bind( function( to ) {
			//Background
			api( 'background_color' ).set( to );
			api.control( 'background_color' ).container.find( '.color-picker-hex' )
							.data( 'data-default-color', to )
							.wpColorPicker( 'defaultColor', to );
							
			updateCSS( to, api( 'secondary_color' ).get() );
		} );
	} );
	
	// Secondary Color
	api( 'secondary_color', function( value ) {
		value.bind( function( to ) {
			updateCSS( api( 'primary_color' ).get(), to );
		} );
	} );
} )( wp.customize );
