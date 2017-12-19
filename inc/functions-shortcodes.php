<?php
/**
 * Plugin shortcode functions.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register shortcodes.
add_action( 'init', 'toot_register_shortcodes' );

/**
 * Registers the plugin's shortcodes.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_register_shortcodes() {

	add_shortcode( 'toot_testimonial',  'toot_testimonial_shortcode'  );
	add_shortcode( 'toot_testimonials', 'toot_testimonials_shortcode' );
}

/**
 * `[toot_testimonial]` shortcode for outputting a single testimonial.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $attr
 * @return string
 */
function toot_testimonial_shortcode( $attr = array() ) {

	// All plugin/theme devs to short-ciruit the default output and roll their own.
	$out = apply_filters( 'toot_testimonial_shortcode', '', $attr );

	if ( $out )
		return $out;

	$defaults = array(
		'order'    => 'DESC',
		'orderby'  => 'date',
		'category' => '',
		'class'    => ''
	);

	$attr = shortcode_atts( $defaults, $attr, 'toot_testimonial' );

	$query_args = array(
		'posts_per_page' => 1,
		'order'          => $attr['order'],
		'orderby'        => $attr['orderby'],
	);

	return _toot_get_shortcode_loop( $query_args, $attr );
}

/**
 * `[toot_testimonials]` shortcode for outputting multiple testimonials.
 *
 * @since  1.0.0
 * @access public
 * @param  array   $attr
 * @return string
 */
function toot_testimonials_shortcode( $attr = array() ) {

	// All plugin/theme devs to short-ciruit the default output and roll their own.
	$out = apply_filters( 'toot_testimonials_shortcode', '', $attr );

	if ( $out )
		return $out;

	$defaults = array(
		'order'    => 'DESC',
		'orderby'  => 'date',
		'category' => '',
		'class'    => '',
		'limit'    => 10
	);

	$attr = shortcode_atts( $defaults, $attr, 'toot_testimonial' );

	$query_args = array(
		'posts_per_page' => absint( $attr['limit'] ),
		'order'          => $attr['order'],
		'orderby'        => $attr['orderby'],
	);

	return _toot_get_shortcode_loop( $query_args, $attr );
}

/**
 * Helper function for use with the plugin only.  Third-party devs should not use
 * this function.
 *
 * @since  1.0.0
 * @access private
 * @param  array   $query_args
 * @param  array   $attr
 * @return string
 */
function _toot_get_shortcode_loop( $query_args, $attr ) {

	$query_args['post_type'] = toot_get_testimonial_post_type();

	if ( $attr['category'] ) {

		$query_args['tax_query'] = array(
			array(
				'taxonomy' => toot_get_category_taxonomy(),
				'field'    => 'slug',
				'terms'    => array( $attr['category'] )
			)
		);
	}

	$loop = new WP_Query( $query_args );

	$html = '';

	while ( $loop->have_posts() ) :

		$loop->the_post();

		$content = toot_get_testimonial_content();
		$image   = toot_get_testimonial_image();
		$author  = toot_get_testimonial_cite();

		$html .= sprintf( toot_get_testimonial_template(), esc_attr( $attr['class'] ), $content, $image, $author );

	endwhile;

	wp_reset_postdata();

	return $html;
}
