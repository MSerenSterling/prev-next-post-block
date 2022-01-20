<?php
/**
 * Plugin Name:       Prev Next
 * Description:       Example block written with ESNext standard and JSX support – build step required.
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       prev-next
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/writing-your-first-block-type/
 */

function prev_next_block_dynamic_render_callback( $block_attributes, $content) {
	$prev_id = get_previous_post()->ID;
	$next_id = get_next_post()->ID;
	
	//TODO: Add prev/next post text to front end editor
	//TODO: Add image toggle and size select to front end editor
	$prev_html = $prev_id ? prev_next_html_block_content($prev_id, 'Prev Post') : '';

	$next_html = $next_id ? prev_next_html_block_content($next_id, 'Next Post') : '';


	return <<<HTML
		<div class="wp-block-create-block-prev-next">
			$prev_html
			$next_html
		</div>
	HTML;
} 

function prev_next_html_block_content($id, $text) {
	ob_start();
	?>
		<a href="<?= get_permalink($id);?>" class="<?= strtolower(str_replace( array(" "), "-", $text ) );?>">
			<?php if (has_post_thumbnail( $id )) { ?>
				<div class="prev-next-thumbnail">
					<?= get_the_post_thumbnail( $id, 'medium'); ?>
				</div>
			<?php } ?>
			<div class="prev-next-content">
				<?php if ($text) { ?>
					<p class="prev-next-text"><?= $text; ?></p>
				<?php } ?>
				<p class="prev-next-title"><?=get_the_title( $id );?></p>
			</div>
		</a>
	<?php

	return ob_get_clean();
}


function create_block_prev_next_block_init() {
	register_block_type( __DIR__, [
		'render_callback' => 'prev_next_block_dynamic_render_callback'
	] );
}
add_action( 'init', 'create_block_prev_next_block_init' );
