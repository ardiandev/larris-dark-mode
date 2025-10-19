/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json`, it will be enqueued on the front end of the site.
 *
 * @package
 */

/* global localStorage */ // Tell ESLint that localStorage is a browser global

document.addEventListener( 'DOMContentLoaded', function () {
	const toggle = document.getElementById( 'theme-toggle' );
	const html = document.documentElement;

	if ( ! toggle ) {
		return;
	}

	// Load saved theme
	const savedTheme = localStorage.getItem( 'theme' );
	if ( savedTheme === 'dark' ) {
		html.setAttribute( 'data-theme', 'dark' );
		toggle.checked = true;
	}

	// Change theme
	toggle.addEventListener( 'change', function () {
		if ( this.checked ) {
			html.setAttribute( 'data-theme', 'dark' );
			localStorage.setItem( 'theme', 'dark' );
		} else {
			html.removeAttribute( 'data-theme' );
			localStorage.setItem( 'theme', 'light' );
		}
	} );
} );
