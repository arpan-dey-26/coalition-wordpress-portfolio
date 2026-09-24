( function() {
	'use strict';

	var select = document.getElementById( 'ct-custom-logo-select' );
	var remove = document.getElementById( 'ct-custom-logo-remove' );
	var input = document.getElementById( 'ct-custom-logo-id' );
	var preview = document.getElementById( 'ct-custom-logo-preview' );
	var frame;

	if ( ! select || ! remove || ! input || ! preview ) {
		return;
	}

	select.addEventListener( 'click', function() {
		if ( ! frame ) {
			frame = wp.media( {
				title: ctCustomSettings.title,
				button: { text: ctCustomSettings.button },
				library: { type: 'image' },
				multiple: false
			} );

			frame.on( 'open', function() {
				var selection = frame.state().get( 'selection' );
				selection.reset();
				if ( Number( input.value ) ) {
					selection.add( wp.media.attachment( Number( input.value ) ) );
				}
			} );

			frame.on( 'select', function() {
				var attachment = frame.state().get( 'selection' ).first();
				if ( ! attachment ) {
					return;
				}
				var image = attachment.toJSON();
				var thumbnail = document.createElement( 'img' );
				thumbnail.src = image.sizes && image.sizes.thumbnail ? image.sizes.thumbnail.url : image.url;
				thumbnail.alt = ctCustomSettings.alt;
				thumbnail.style.maxWidth = '150px';
				thumbnail.style.maxHeight = '150px';
				input.value = image.id;
				preview.textContent = '';
				preview.appendChild( thumbnail );
				remove.disabled = false;
				wp.a11y.speak( ctCustomSettings.selected );
			} );

			frame.on( 'close', function() {
				select.focus();
			} );
		}
		frame.open();
	} );

	remove.addEventListener( 'click', function() {
		input.value = '0';
		preview.textContent = '';
		remove.disabled = true;
		select.focus();
		wp.a11y.speak( ctCustomSettings.removed );
	} );
} )();