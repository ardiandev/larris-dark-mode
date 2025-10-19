<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @package Larris_Dark_Mode
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<div class="theme-switcher">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="12" cy="12" r="4"></circle>
			<path d="M12 2v2"></path>
			<path d="M12 20v2"></path>
			<path d="m4.93 4.93 1.41 1.41"></path>
			<path d="m17.66 17.66 1.41 1.41"></path>
			<path d="M2 12h2"></path>
			<path d="M20 12h2"></path>
			<path d="m6.34 17.66-1.41 1.41"></path>
			<path d="m19.07 4.93-1.41 1.41"></path>
		</svg>

		<label class="switch" for="theme-toggle">
			<input type="checkbox" id="theme-toggle">
			<span class="slider"></span>
		</label>

		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
		</svg>
	</div>
</div>

