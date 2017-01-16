<?php
/**
 * Template tags related to portfolio testimonials for theme authors to use in their theme templates.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Makes sure the post ID is an absolute integer if passed in.  Else, returns the result
 * of `get_the_ID()`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return int
 */
function toot_get_testimonial_id( $post_id = '' ) {

	return $post_id ? absint( $post_id ) : get_the_ID();
}

/**
 * Checks if viewing a single testimonial.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $post
 * @return bool
 */
function toot_is_single_testimonial( $post = '' ) {

	$is_single = is_singular( toot_get_testimonial_post_type() );

	if ( $is_single && $post )
		$is_single = is_single( $post );

	return apply_filters( 'toot_is_single_testimonial', $is_single, $post );
}

/**
 * Checks if viewing the testimonial archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function toot_is_testimonial_archive() {

	return apply_filters( 'toot_is_testimonial_archive', is_post_type_archive( toot_get_testimonial_post_type() ) && ! toot_is_author() );
}

/**
 * Checks if the current post is a testimonial.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return bool
 */
function toot_is_testimonial( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	return apply_filters( 'toot_is_testimonial', toot_get_testimonial_post_type() === get_post_type( $post_id ), $post_id );
}

/**
 * Conditional check to see if a testimonial has the "sticky" type.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $testimonial_id
 * @return bool
 */
function toot_is_testimonial_sticky( $testimonial_id = 0 ) {
	$testimonial_id = toot_get_testimonial_id( $testimonial_id );

	return apply_filters( 'toot_is_testimonial_sticky', in_array( $testimonial_id, toot_get_sticky_testimonials() ), $testimonial_id );
}

/**
 * Outputs the testimonial URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function toot_testimonial_url( $post_id = '' ) {

	$url = toot_get_testimonial_url( $post_id );

	echo $url ? esc_url( $url ) : '';
}

/**
 * Returns the testimonial URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @return string
 */
function toot_get_testimonial_url( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	return apply_filters( 'toot_get_testimonial_url', toot_get_testimonial_meta( $post_id, 'url' ), $post_id );
}

/**
 * Displays the testimonial link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_link( $args = array() ) {
	echo toot_get_testimonial_link( $args );
}

/**
 * Returns the testimonial link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_link( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$url = toot_get_testimonial_meta( $args['post_id'], 'url' );

	if ( $url ) {

		$text = sprintf( $args['text'], $url );
		$attr = sprintf( 'class="testimonial-link" href="%s"', esc_url( $url ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'toot_get_testimonial_link', $html, $args['post_id'] );
}

/**
 * Prints the testimonial email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_email( $args = array() ) {
	echo toot_get_testimonial_email( $args );
}

/**
 * Returns the testimonial email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_email( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$email = toot_get_testimonial_meta( $args['post_id'], 'email' );

	if ( $email ) {

		$text = sprintf( $args['text'], sprintf( '<span class="testimonial-data">%s</span>', $email ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="testimonial-email"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'toot_get_testimonial_email', $html, $args['post_id'] );
}
