<?php
/**
 * Admin settings page for Larris Dark Mode.
 *
 * @package LarrisDarkMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register settings for dark/light colors.
 */
function larris_dark_mode_register_settings() {
	$options = array(
		// 🌞 Light Theme Defaults
		'larris_dark_mode_light_bg'             => '#F4EEFF',
		'larris_dark_mode_light_text'           => '#142850',
		'larris_dark_mode_light_link'           => '#1e73be',
		'larris_dark_mode_light_hover'          => '#125688',
		'larris_dark_mode_light_btn_bg'         => '#A6B1E1',
		'larris_dark_mode_light_btn_text'       => '#ffffff',
		'larris_dark_mode_light_btn_bg_hover'   => '#DCD6F7',
		'larris_dark_mode_light_btn_text_hover' => '#ffffff',

		// 🌙 Dark Theme Defaults
		'larris_dark_mode_dark_bg'              => '#142850',
		'larris_dark_mode_dark_text'            => '#dae1e7',
		'larris_dark_mode_dark_link'            => '#4da8da',
		'larris_dark_mode_dark_hover'           => '#90e0ef',
		'larris_dark_mode_dark_btn_bg'          => '#424874',
		'larris_dark_mode_dark_btn_text'        => '#F4EEFF',
		'larris_dark_mode_dark_btn_bg_hover'    => '#A6B1E1',
		'larris_dark_mode_dark_btn_text_hover'  => '#ffffff',
	);

	foreach ( $options as $key => $value ) {
		add_option( $key, $value );
		register_setting( 'larris_dark_mode_options_group', $key );
	}
}
add_action( 'admin_init', 'larris_dark_mode_register_settings' );

/**
 * Add settings page.
 */
function larris_dark_mode_register_options_page() {
	add_menu_page(
		__( 'Larris Dark Mode', 'larris-dark-mode' ),
		__( 'Dark Mode', 'larris-dark-mode' ),
		'manage_options',
		'larris-dark-mode',
		'larris_dark_mode_options_page_html',
		'dashicons-lightbulb',
		60
	);
}
add_action( 'admin_menu', 'larris_dark_mode_register_options_page' );

/**
 * Settings page HTML output.
 */
function larris_dark_mode_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Dark Mode Color Settings', 'larris-dark-mode' ); ?></h1>
		<p><?php esc_html_e( 'Customize background, text, link, and button colors for both light and dark themes.', 'larris-dark-mode' ); ?></p>

		<form method="post" action="options.php" id="larris-dark-mode-form">
			<?php settings_fields( 'larris_dark_mode_options_group' ); ?>

			<!-- 🌞 LIGHT THEME -->
			<h2><?php esc_html_e( '🌞 Light Theme', 'larris-dark-mode' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr><th><?php esc_html_e( 'Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_bg' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_text' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Link Color', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_link' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Link Hover', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_hover' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_btn_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_bg' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_btn_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_text' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Hover Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_btn_bg_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_bg_hover' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Hover Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_btn_text_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_btn_text_hover' ) ); ?>" /></td></tr>
			</table>

			<!-- 🌙 DARK THEME -->
			<h2><?php esc_html_e( '🌙 Dark Theme', 'larris-dark-mode' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr><th><?php esc_html_e( 'Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_bg' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_text' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Link Color', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_link' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Link Hover', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_hover' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_btn_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_bg' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_btn_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_text' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Hover Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_btn_bg_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_bg_hover' ) ); ?>" /></td></tr>
				<tr><th><?php esc_html_e( 'Button Hover Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_btn_text_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_btn_text_hover' ) ); ?>" /></td></tr>
			</table>

			<?php submit_button( __( '💾 Save Colors', 'larris-dark-mode' ) ); ?>
		</form>

		<h2><?php esc_html_e( 'Live Preview', 'larris-dark-mode' ); ?></h2>
		<div id="larris-dark-preview" style="padding:20px; border:1px solid #ccc; border-radius:8px;">
			<p><?php esc_html_e( 'This is how your theme will look.', 'larris-dark-mode' ); ?></p>
			<p><a href="#" target="_blank"><?php esc_html_e( 'Sample link', 'larris-dark-mode' ); ?></a></p>
			<p><a href="#" class="larris-btn"><?php esc_html_e( 'Sample Button', 'larris-dark-mode' ); ?></a></p>
		</div>

		<script>
			(function() {
				const form = document.getElementById('larris-dark-mode-form');
				const preview = document.getElementById('larris-dark-preview');
				const inputs = form.querySelectorAll('input[type="color"]');

				function updatePreview() {
					const link = preview.querySelector('a:not(.larris-btn)');
					const button = preview.querySelector('.larris-btn');

					preview.style.background = form.larris_dark_mode_light_bg.value;
					preview.style.color = form.larris_dark_mode_light_text.value;

					link.style.color = form.larris_dark_mode_light_link.value;
					button.style.background = form.larris_dark_mode_light_btn_bg.value;
					button.style.color = form.larris_dark_mode_light_btn_text.value;

					link.onmouseover = () => link.style.color = form.larris_dark_mode_light_hover.value;
					link.onmouseout  = () => link.style.color = form.larris_dark_mode_light_link.value;

					button.onmouseover = () => {
						button.style.background = form.larris_dark_mode_light_btn_bg_hover.value;
						button.style.color = form.larris_dark_mode_light_btn_text_hover.value;
					};
					button.onmouseout = () => {
						button.style.background = form.larris_dark_mode_light_btn_bg.value;
						button.style.color = form.larris_dark_mode_light_btn_text.value;
					};
				}

				inputs.forEach(input => input.addEventListener('input', updatePreview));
				updatePreview();
			})();
		</script>
	</div>
	<?php
}

