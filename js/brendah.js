(function( $ ) {
	'use strict';

	// make dropdowns functional on focus to aid screen readers
	$( '.main-navigation' ).find( 'a' ).on( 'focus blur', function() {
		$( this ).closest( '.menu-item-has-children' ).toggleClass( 'focus' );
	} );
	
	// menu navigation with arrow keys 
	  $('.menu-item a').on('keydown', function(e) {

		// left key
		if(e.which === 37) {
			e.preventDefault();
			$(this).parent().prev().children('a').focus();
		}
		// right key
		else if(e.which === 39) {
			e.preventDefault();
			$(this).parent().next().children('a').focus();
		}
		// down key
		else if(e.which === 40) {
			e.preventDefault();
			if($(this).next().length){
				$(this).next().find('li:first-child a').first().focus();
			}
			else {
				$(this).parent().next().children('a').focus();
			}
		}
		// up key
		else if(e.which === 38) {
			e.preventDefault();
			if($(this).parent().prev().length){
				$(this).parent().prev().children('a').focus();
			}
			else {
				$(this).parents('ul').first().prev('a').focus();
			}
		}

	});
	
	// menu toggle	
	$( '.menu-toggle' ).on( 'click', function() {
		$(this)
			.closest('.main-navigation')
			.find('#brendah-top-menu')
			.slideToggle()
	} );

	//Skip link fix 
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
	
}(jQuery));