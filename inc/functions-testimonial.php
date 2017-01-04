<?php
/**
 * Plugin functions related to the testimonial post type.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Adds a testimonial to the list of sticky testimonials.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $testimonial_id
 * @return bool
 */
function jtest_add_sticky_testimonial( $testimonial_id ) {
	$testimonial_id = jtest_get_testimonial_id( $testimonial_id );

	if ( ! jtest_is_testimonial_sticky( $testimonial_id ) )
		return update_option( 'jtest_sticky_testimonials', array_unique( array_merge( jtest_get_sticky_testimonials(), array( $testimonial_id ) ) ) );

	return false;
}

/**
 * Removes a testimonial from the list of sticky testimonials.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $testimonial_id
 * @return bool
 */
function jtest_remove_sticky_testimonial( $testimonial_id ) {
	$testimonial_id = jtest_get_testimonial_id( $testimonial_id );

	if ( jtest_is_testimonial_sticky( $testimonial_id ) ) {
		$stickies = jtest_get_sticky_testimonials();
		$key      = array_search( $testimonial_id, $stickies );

		if ( isset( $stickies[ $key ] ) ) {
			unset( $stickies[ $key ] );
			return update_option( 'jtest_sticky_testimonials', array_unique( $stickies ) );
		}
	}

	return false;
}

/**
 * Returns an array of sticky testimonials.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function jtest_get_sticky_testimonials() {
	return apply_filters( 'jtest_get_sticky_testimonials', get_option( 'jtest_sticky_testimonials', array() ) );
}
