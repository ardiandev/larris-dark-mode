<?php
/**
 * Plugin Name:       Larris Dark Mode
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       larris-dark
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_larris_dark_block_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', 'create_block_larris_dark_block_init' );

/**
 * Add inline script early to set the saved theme before CSS loads.
 */
function larris_dark_mode_inline_theme_script() {
	?>
	<script>
		(function() {
			try {
				const saved = localStorage.getItem('theme');
				const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
				const theme = saved || (prefersDark ? 'dark' : 'light');
				if (theme === 'dark') {
					document.documentElement.setAttribute('data-theme', 'dark');
				}
			} catch (e) {}
		})();
	</script>
	<?php
}
add_action( 'wp_head', 'larris_dark_mode_inline_theme_script', 1 );

/**
 * Output custom colors as CSS variables for both themes.
 */
function larris_dark_mode_inline_styles() {
	// Light theme colors.
	$light_bg    = get_option( 'larris_dark_mode_light_bg', '#dae1e7' );
	$light_txt   = get_option( 'larris_dark_mode_light_text', '#142850' );
	$light_link  = get_option( 'larris_dark_mode_light_link', '#1e73be' );
	$light_hover = get_option( 'larris_dark_mode_light_hover', '#125688' );

	// Dark theme colors.
	$dark_bg    = get_option( 'larris_dark_mode_dark_bg', '#142850' );
	$dark_txt   = get_option( 'larris_dark_mode_dark_text', '#dae1e7' );
	$dark_link  = get_option( 'larris_dark_mode_dark_link', '#4da8da' );
	$dark_hover = get_option( 'larris_dark_mode_dark_hover', '#90e0ef' );

	// Dynamic CSS output.
	$custom_css = "
		:root {
			--light-bg: {$light_bg};
			--light-text: {$light_txt};
			--light-link: {$light_link};
			--light-hover: {$light_hover};
		}
		html[data-theme='dark'] {
			--light-bg: {$dark_bg};
			--light-text: {$dark_txt};
			--light-link: {$dark_link};
			--light-hover: {$dark_hover};
		}

		body {
			background-color: var(--light-bg);
			color: var(--light-text);
			transition: background-color 0.3s, color 0.3s;
		}

		a {
			color: var(--light-link);
			text-decoration: none;
			transition: color 0.3s;
		}

		a:hover,
		a:focus {
			color: var(--light-hover);
		}
	";

	// Cache-busting version.
	$version = defined( 'LARRIS_DARK_MODE_VERSION' ) ? LARRIS_DARK_MODE_VERSION : filemtime( __FILE__ );

	wp_register_style( 'larris-dark-mode-dynamic', false, array(), $version );
	wp_enqueue_style( 'larris-dark-mode-dynamic' );
	wp_add_inline_style( 'larris-dark-mode-dynamic', $custom_css );
}





															add_action( 'wp_enqueue_scripts', 'larris_dark_mode_inline_styles' );



// Include admin settings page.
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/admin-settings.php';
}




