( function( $ ) {
	wp.customize('blogname', function( value ) {
		value.bind( function( to ) {
			$('.blog-title a').html( to );
		} );
	} );
	wp.customize('blogdescription', function( value ) {
		value.bind( function( to ) {
			$('.blog-description').html( to );
		} );
	} );
} )( jQuery );