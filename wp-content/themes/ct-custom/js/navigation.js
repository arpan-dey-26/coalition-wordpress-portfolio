( function() {
	'use strict';

	var container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}
	var button = container.querySelector( '.menu-toggle' );
	var menu = document.getElementById( 'primary-menu' );
	if ( ! menu ) {
		button.hidden = true;
		return;
	}
	var mobile = window.matchMedia( '(max-width: 767px)' );
	var hover = window.matchMedia( '(hover: hover)' );
	var parents = [];
	container.classList.add( 'navigation-ready' );
	menu.classList.add( 'nav-menu' );

	function setOpen( item, open ) {
		item.classList.toggle( 'is-open', open );
		item.querySelector( ':scope > .submenu-toggle' ).setAttribute( 'aria-expanded', String( open ) );
		var submenu = item.querySelector( ':scope > ul' );
		submenu.classList.remove( 'opens-left' );
		if ( open && ! mobile.matches && submenu.getBoundingClientRect().right > window.innerWidth - 16 ) {
			submenu.classList.add( 'opens-left' );
		}
		if ( ! open ) {
			item.querySelectorAll( 'li.is-open' ).forEach( function( child ) {
				setOpen( child, false );
			} );
		}
	}

	menu.querySelectorAll( 'li' ).forEach( function( item, index ) {
		var submenu = item.querySelector( ':scope > ul' );
		var link = item.querySelector( ':scope > a' );
		if ( ! submenu || ! link ) {
			return;
		}
		var toggle = document.createElement( 'button' );
		submenu.id = 'primary-submenu-' + index;
		toggle.type = 'button';
		toggle.className = 'submenu-toggle';
		toggle.setAttribute( 'aria-controls', submenu.id );
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-label', ctCustomNavigation.submenu + ' ' + link.textContent.trim() );
		item.insertBefore( toggle, submenu );
		parents.push( item );
		toggle.addEventListener( 'click', function() {
			setOpen( item, ! item.classList.contains( 'is-open' ) );
		} );
		item.addEventListener( 'pointerenter', function() {
			if ( ! mobile.matches && hover.matches ) {
				setOpen( item, true );
			}
		} );
		item.addEventListener( 'pointerleave', function() {
			if ( ! mobile.matches && ! item.contains( document.activeElement ) ) {
				setOpen( item, false );
			}
		} );
	} );

	function closeMenu() {
		container.classList.remove( 'toggled' );
		button.setAttribute( 'aria-expanded', 'false' );
		parents.forEach( function( item ) { setOpen( item, false ); } );
	}

	button.addEventListener( 'click', function() {
		if ( container.classList.contains( 'toggled' ) ) {
			closeMenu();
		} else {
			container.classList.add( 'toggled' );
			button.setAttribute( 'aria-expanded', 'true' );
		}
	} );

	menu.addEventListener( 'focusin', function( event ) {
		parents.forEach( function( item ) {
			if ( ! item.contains( event.target ) ) {
				setOpen( item, false );
			} else if ( ! mobile.matches && event.target !== item.querySelector( ':scope > .submenu-toggle' ) ) {
				setOpen( item, true );
			}
		} );
	} );

	container.addEventListener( 'focusout', function( event ) {
		if ( ! container.contains( event.relatedTarget ) ) {
			closeMenu();
		}
	} );
	container.addEventListener( 'keydown', function( event ) {
		if ( event.key !== 'Escape' ) {
			return;
		}
		var item = event.target.closest( 'li.is-open' );
		if ( item ) {
			setOpen( item, false );
			item.querySelector( ':scope > .submenu-toggle' ).focus();
		} else if ( mobile.matches ) {
			closeMenu();
			button.focus();
		}
		event.preventDefault();
	} );
	document.addEventListener( 'click', function( event ) {
		if ( ! container.contains( event.target ) ) {
			closeMenu();
		}
	} );
	mobile.addEventListener( 'change', closeMenu );
} )();