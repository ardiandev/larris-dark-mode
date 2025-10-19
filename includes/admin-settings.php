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
		'larris_dark_mode_light_bg'    => '#dae1e7',
		'larris_dark_mode_light_text'  => '#142850',
		'larris_dark_mode_light_link'  => '#1e73be',
		'larris_dark_mode_light_hover' => '#125688',
		'larris_dark_mode_dark_bg'     => '#142850',
		'larris_dark_mode_dark_text'   => '#dae1e7',
		'larris_dark_mode_dark_link'   => '#4da8da',
		'larris_dark_mode_dark_hover'  => '#90e0ef',
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
		<p><?php esc_html_e( 'Customize background, text, and hyperlink colors for light and dark themes. Your changes will apply instantly across the site.', 'larris-dark-mode' ); ?></p>
		<form method="post" action="options.php" id="larris-dark-mode-form">
			<?php settings_fields( 'larris_dark_mode_options_group' ); ?>

			<h2><?php esc_html_e( '🌞 Light Theme', 'larris-dark-mode' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_bg' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_text' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Link Color', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_link' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Link Hover', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_light_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_light_hover' ) ); ?>" /></td>
				</tr>
			</table>

			<h2><?php esc_html_e( '🌙 Dark Theme', 'larris-dark-mode' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Background', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_bg" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_bg' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Text', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_text" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_text' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Link Color', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_link" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_link' ) ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Link Hover', 'larris-dark-mode' ); ?></th>
					<td><input type="color" name="larris_dark_mode_dark_hover" value="<?php echo esc_attr( get_option( 'larris_dark_mode_dark_hover' ) ); ?>" /></td>
				</tr>
			</table>

			<?php submit_button( __( 'Save Colors', 'larris-dark-mode' ) ); ?>
		</form>

		<h2><?php esc_html_e( 'Live Preview', 'larris-dark-mode' ); ?></h2>
		<div id="larris-dark-preview" style="padding:20px; border:1px solid #ccc; border-radius:8px;">
			<p><?php esc_html_e( 'This is how your theme will look.', 'larris-dark-mode' ); ?></p>
			<p><a href="#" target="_blank"><?php esc_html_e( 'Sample link', 'larris-dark-mode' ); ?></a></p>
		</div>

		<script>
			(function() {
				const form = document.getElementById('larris-dark-mode-form');
				const preview = document.getElementById('larris-dark-preview');
				const inputs = form.querySelectorAll('input[type="color"]');

				function updatePreview() {
					preview.style.background = form.larris_dark_mode_light_bg.value;
					preview.style.color = form.larris_dark_mode_light_text.value;
					preview.querySelector('a').style.color = form.larris_dark_mode_light_link.value;

					preview.querySelector('a').addEventListener('mouseover', function() {
						this.style.color = form.larris_dark_mode_light_hover.value;
					});
					preview.querySelector('a').addEventListener('mouseout', function() {
						this.style.color = form.larris_dark_mode_light_link.value;
					});
				}
				inputs.forEach(input => input.addEventListener('input', updatePreview));
				updatePreview();
			})();
		</script>
	</div>
	<?php
}

