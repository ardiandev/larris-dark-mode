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
	exit;
}

/**
 * Registers block(s) for this plugin.
 */
function create_block_larris_dark_block_init() {
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}

	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', 'create_block_larris_dark_block_init' );

// Include admin settings page.
if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/admin-settings.php';
}

/**
 * Add inline script early — sets theme and dynamically injects user-defined classes.
 */
function larris_dark_mode_inline_theme_script() {
	$class_map = get_option( 'larris_dark_mode_class_map', array() );
	$json_map  = wp_json_encode( $class_map );
	?>
	<script>
	(function() {
		try {
			// 🌗 1. Apply saved theme before CSS paint.
			const saved = localStorage.getItem('theme');
			const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
			const theme = saved || (prefersDark ? 'dark' : 'light');
			if (theme === 'dark') {
				document.documentElement.setAttribute('data-theme', 'dark');
			}

			// 🌈 2. Dynamically inject user-specified classes before CSS paint.
			const classMap = <?php echo $json_map ? esc_js( $json_map ) : '{}'; ?>;
			if (Object.keys(classMap).length) {
				const applyClasses = () => {
					for (const [selector, injectClass] of Object.entries(classMap)) {
						document.querySelectorAll(selector).forEach(el => {
							if (!el.classList.contains(injectClass)) {
								el.classList.add(injectClass);
							}
						});
					}
				};
				// Run immediately.
				applyClasses();
				// Observe for dynamic DOM changes (like Gutenberg or AJAX).
				const observer = new MutationObserver(applyClasses);
				observer.observe(document.documentElement, { childList: true, subtree: true });
			}
		} catch (e) {
			console.warn('Larris Dark Mode: Script error', e);
		}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'larris_dark_mode_inline_theme_script', 1 );

/**
 * Output custom colors as CSS variables and enqueue the external stylesheet.
 */
function larris_dark_mode_enqueue_styles() {

	// 1️⃣ Enqueue the external stylesheet (for layout and style rules).
	$css_file = plugin_dir_path( __FILE__ ) . 'assets/css/larris-dark.css';
	wp_enqueue_style(
		'larris-dark-mode-base',
		plugin_dir_url( __FILE__ ) . 'assets/css/larris-dark.css',
		array(),
		filemtime( $css_file )
	);

	// 2️⃣ Fetch the dynamic color values from the plugin options.
	$light_bg             = get_option( 'larris_dark_mode_light_bg', '#dae1e7' );
	$light_txt            = get_option( 'larris_dark_mode_light_text', '#142850' );
	$light_link           = get_option( 'larris_dark_mode_light_link', '#142850' );
	$light_link_hover     = get_option( 'larris_dark_mode_light_link_hover', '#112233' );
	$light_btn_bg         = get_option( 'larris_dark_mode_light_btn_bg', '#112233' );
	$light_btn_bg_hover   = get_option( 'larris_dark_mode_light_btn_bg_hover', '#112233' );
	$light_btn_text       = get_option( 'larris_dark_mode_light_btn_text', '#112233' );
	$light_btn_text_hover = get_option( 'larris_dark_mode_light_btn_text_hover', '#112233' );
	$light_metadata       = get_option( 'larris_dark_mode_light_metadata', '#112233' );
	$light_metadata_hover = get_option( 'larris_dark_mode_light_metadata_hover', '#112233' );

	$dark_bg             = get_option( 'larris_dark_mode_dark_bg', '#142850' );
	$dark_txt            = get_option( 'larris_dark_mode_dark_text', '#dae1e7' );
	$dark_link           = get_option( 'larris_dark_mode_dark_link', '#ffffff' );
	$dark_link_hover     = get_option( 'larris_dark_mode_dark_link_hover', '#bbbbbb' );
	$dark_btn_bg         = get_option( 'larris_dark_mode_dark_btn_bg', '#112233' );
	$dark_btn_bg_hover   = get_option( 'larris_dark_mode_dark_btn_bg_hover', '#112233' );
	$dark_btn_text       = get_option( 'larris_dark_mode_dark_btn_text', '#112233' );
	$dark_btn_text_hover = get_option( 'larris_dark_mode_dark_btn_text_hover', '#112233' );
	$dark_metadata       = get_option( 'larris_dark_mode_dark_metadata', '#112233' );
	$dark_metadata_hover = get_option( 'larris_dark_mode_dark_metadata_hover', '#112233' );

	// 3️⃣ Define the CSS variables (these will be available globally).
	$custom_css = "
		:root {
			--light-bg: {$light_bg};
			--light-text: {$light_txt};
			--light-link: {$light_link};
			--light-link-hover: {$light_link_hover};
			--light-btn-bg: {$light_btn_bg};
			--light-btn-bg-hover: {$light_btn_bg_hover};
			--light-btn-text: {$light_btn_text};
			--light-btn-text-hover: {$light_btn_text_hover};
			--light-metadata: {$light_metadata};
			--light-metadata-hover: {$light_metadata_hover};
		}

		html[data-theme='dark'] {
			--light-bg: {$dark_bg};
			--light-text: {$dark_txt};
			--light-link: {$dark_link};
			--light-link-hover: {$dark_link_hover};
			--light-btn-bg: {$dark_btn_bg};
			--light-btn-bg-hover: {$dark_btn_bg_hover};
			--light-btn-text: {$dark_btn_text};
			--light-btn-text-hover: {$dark_btn_text_hover};
			--light-metadata: {$dark_metadata};
			--light-metadata-hover: {$dark_metadata_hover};
		}
	";

	// 4️⃣ Inject the CSS variables inline (so they’re available before your CSS uses them).
	wp_add_inline_style( 'larris-dark-mode-base', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'larris_dark_mode_enqueue_styles' );
