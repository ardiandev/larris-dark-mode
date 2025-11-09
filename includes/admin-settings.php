<?php
/**
 * Admin settings page for Larris Dark Mode (popup color picker).
 *
 * @package LarrisDarkMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register settings with default values.
 */
function larris_dark_mode_register_settings() {
	$options = array(
		// 🌞 Light Mode.
		'larris_dark_mode_light_bg'             => '#F9FAFB',
		'larris_dark_mode_light_bg_hover'       => '#EDEFF2',
		'larris_dark_mode_light_text'           => '#1A1F2B',
		'larris_dark_mode_light_text_hover'     => '#111826',
		'larris_dark_mode_light_link'           => '#2563EB',
		'larris_dark_mode_light_link_hover'     => '#1E40AF',
		'larris_dark_mode_light_btn_bg'         => '#1A1F2B',
		'larris_dark_mode_light_btn_bg_hover'   => '#111826',
		'larris_dark_mode_light_btn_text'       => '#FFFFFF',
		'larris_dark_mode_light_btn_text_hover' => '#F9FAFB',
		'larris_dark_mode_light_metadata'       => '#6B7280',
		'larris_dark_mode_light_metadata_hover' => '#374151',

		// 🌚 Dark Mode.
		'larris_dark_mode_dark_bg'              => '#0F172A',
		'larris_dark_mode_dark_bg_hover'        => '#1E293B',
		'larris_dark_mode_dark_text'            => '#E2E8F0',
		'larris_dark_mode_dark_text_hover'      => '#FFFFFF',
		'larris_dark_mode_dark_link'            => '#60A5FA',
		'larris_dark_mode_dark_link_hover'      => '#93C5FD',
		'larris_dark_mode_dark_btn_bg'          => '#E2E8F0',
		'larris_dark_mode_dark_btn_bg_hover'    => '#CBD5E1',
		'larris_dark_mode_dark_btn_text'        => '#0F172A',
		'larris_dark_mode_dark_btn_text_hover'  => '#111826',
		'larris_dark_mode_dark_metadata'        => '#94A3B8',
		'larris_dark_mode_dark_metadata_hover'  => '#60A5FA',
	);
	foreach ( $options as $key => $val ) {
		add_option( $key, $val );
		register_setting( 'larris_dark_mode_options_group', $key );
	}
}
add_action( 'admin_init', 'larris_dark_mode_register_settings' );

/**
 * Add menu page.
 */
function larris_dark_mode_register_options_page() {
	add_menu_page(
		'🎨 Larris Dark Mode',
		'Dark Mode',
		'manage_options',
		'larris-dark-mode',
		'larris_dark_mode_options_page_html',
		'dashicons-lightbulb',
		60
	);
}
add_action( 'admin_menu', 'larris_dark_mode_register_options_page' );

/**
 * Enqueue and customize the WP color picker.
 *
 * @param string $hook Current admin page hook suffix.
 */
function larris_dark_mode_enqueue_color_picker( $hook ) {
	if ( 'toplevel_page_larris-dark-mode' !== $hook ) {
		return;
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );

	// Default colors array for reset logic.
	$defaults = array(
		// 🌞 Light Mode.
		'larris_dark_mode_light_bg'             => '#F9FAFB',
		'larris_dark_mode_light_bg_hover'       => '#EDEFF2',
		'larris_dark_mode_light_text'           => '#1A1F2B',
		'larris_dark_mode_light_text_hover'     => '#111826',
		'larris_dark_mode_light_link'           => '#2563EB',
		'larris_dark_mode_light_link_hover'     => '#1E40AF',
		'larris_dark_mode_light_btn_bg'         => '#1A1F2B',
		'larris_dark_mode_light_btn_bg_hover'   => '#111826',
		'larris_dark_mode_light_btn_text'       => '#FFFFFF',
		'larris_dark_mode_light_btn_text_hover' => '#F9FAFB',
		'larris_dark_mode_light_metadata'       => '#6B7280',
		'larris_dark_mode_light_metadata_hover' => '#374151',

		// 🌚 Dark Mode.
		'larris_dark_mode_dark_bg'              => '#0F172A',
		'larris_dark_mode_dark_bg_hover'        => '#1E293B',
		'larris_dark_mode_dark_text'            => '#E2E8F0',
		'larris_dark_mode_dark_text_hover'      => '#FFFFFF',
		'larris_dark_mode_dark_link'            => '#60A5FA',
		'larris_dark_mode_dark_link_hover'      => '#93C5FD',
		'larris_dark_mode_dark_btn_bg'          => '#E2E8F0',
		'larris_dark_mode_dark_btn_bg_hover'    => '#CBD5E1',
		'larris_dark_mode_dark_btn_text'        => '#0F172A',
		'larris_dark_mode_dark_btn_text_hover'  => '#111826',
		'larris_dark_mode_dark_metadata'        => '#94A3B8',
		'larris_dark_mode_dark_metadata_hover'  => '#60A5FA',
	);

	wp_add_inline_script(
		'wp-color-picker',
		'
		jQuery(document).ready(function($){
			const defaults = ' . wp_json_encode( $defaults ) . ";

			$('.larris-color').each(function(){
				const \$input = $(this);
				\$input.wpColorPicker({
					hide: true,
					palettes: true,
					clear: function() {
						const name = \$input.attr('name');
						const defaultColor = defaults[name] || '#ffffff';
						\$input.val(defaultColor).change();
						\$input.wpColorPicker('color', defaultColor);
					}
				});
			});

			// Make color picker popup absolute.
			$(document).on('click', '.wp-color-result', function(){
				const \$picker = $(this).closest('.wp-picker-container').find('.wp-picker-holder');
				\$picker.css({
					position: 'absolute',
					zIndex: 9999,
					background: '#fff',
					boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
					borderRadius: '6px',
					padding: '6px'
				});
			});
		});
	"
	);
}
add_action( 'admin_enqueue_scripts', 'larris_dark_mode_enqueue_color_picker' );

/**
 * Render admin settings page (hardcoded, no loops).
 */
function larris_dark_mode_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	} ?>

	<div class="wrap larris-dark-mode-admin">
		<h1>🎨 Larris Dark Mode Settings</h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'larris_dark_mode_options_group' ); ?>

			<table class="widefat fixed striped larris-table">
				<thead>
					<tr>
						<th rowspan="2">Elements</th>
						<th colspan="2" class="light-header">Light</th>
						<th colspan="2" class="dark-header">Dark</th>
					</tr>
					<tr>
						<th>Color</th>
						<th>Hover</th>
						<th>Color</th>
						<th>Hover</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Background</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_bg' ) ); ?>"></td>
						<td></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_bg' ) ); ?>"></td>
						<td></td>
					</tr>
					<tr>
						<th>Text</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_text' ) ); ?>"></td>
						<td></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_text' ) ); ?>"></td>
						<td></td>
					</tr>
					<tr>
						<th>Link</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_link' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_link_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_link_hover' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_link' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_link_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_link_hover' ) ); ?>"></td>
					</tr>
					<tr>
						<th>Button Background</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_btn_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_bg' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_btn_bg_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_bg_hover' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_btn_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_bg' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_btn_bg_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_bg_hover' ) ); ?>"></td>
					</tr>
					<tr>
						<th>Button Text</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_btn_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_text' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_btn_text_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_text_hover' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_btn_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_text' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_btn_text_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_text_hover' ) ); ?>"></td>
					</tr>
					<tr>
						<th>Meta Data</th>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_metadata" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_metadata' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_light_metadata_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_metadata_hover' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_metadata" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_metadata' ) ); ?>"></td>
						<td><input type="text" class="larris-color" name="larris_dark_mode_dark_metadata_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_metadata_hover' ) ); ?>"></td>
					</tr>
				</tbody>
			</table>

			<?php submit_button( '💾 Save Settings' ); ?>
		</form>
	</div>

	<style>
		.larris-table th {
			font-weight: 600;
			text-align: center;
		}
		.larris-color {
			width: 110px;
		}
		.wp-picker-holder {
			position: absolute !important;
			z-index: 9999;
			margin-top: 6px;
			opacity: 0;
			transform: scale(0.95);
			transition: opacity .15s ease, transform .15s ease;
		}
		.wp-picker-container.wp-picker-active .wp-picker-holder {
			opacity: 1;
			transform: scale(1);
		}
		.iris-picker.iris-border {
			border-radius: 8px;
			border: 1px solid #ccc;
			box-shadow: 0 4px 15px rgba(0,0,0,0.15);
			background: #fff;
		}
		.wp-picker-container {
			position: relative;
		}
	</style>

	<?php
}
