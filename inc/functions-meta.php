<?php
/**
 * Registers metadata and related functions for the plugin.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register meta on the 'init' hook.
add_action( 'init', 'toot_register_meta' );

/**
 * Registers custom metadata for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_register_meta() {

	register_meta(
		'post',
		'url',
		array(
			'sanitize_callback' => 'esc_url_raw',
			'auth_callback'     => '__return_false',
			'single'            => true,
			'show_in_rest'      => true
		)
	);

	register_meta(
		'post',
		'email',
		array(
			'sanitize_callback' => 'sanitize_email',
			'auth_callback'     => '__return_false',
			'single'            => true,
			'show_in_rest'      => true
		)
	);
}

/**
 * Returns testimonial metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function toot_get_testimonial_meta( $post_id, $meta_key ) {

	return get_post_meta( $post_id, $meta_key, true );
}

/**
 * Adds/updates testimonial metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @param  mixed   $meta_value
 * @return bool
 */
function toot_set_testimonial_meta( $post_id, $meta_key, $meta_value ) {

	return update_post_meta( $post_id, $meta_key, $meta_value );
}

/**
 * Deletes testimonial metadata.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $meta_key
 * @return mixed
 */
function toot_delete_testimonial_meta( $post_id, $meta_key ) {

	return delete_post_meta( $post_id, $meta_key );
}
