<?php
/**
 * General template tags for theme authors to use in their themes.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to check if viewing any portfolio page.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function jtest_is_testimonial_page() {

	return apply_filters( 'jtest_is_portfolio', jtest_is_archive() || jtest_is_single_testimonial() );
}

/**
 * Conditional tag to check if viewing any type of portfolio archive page.
 *
 * @since  2.0.0
 * @access public
 * @return bool
 */
function jtest_is_archive() {

	$is_archive = jtest_is_testimonial_archive() || jtest_is_category();

	return apply_filters( 'jtest_is_archive', $is_archive );
}

/**
 * Conditional tag to check if viewing a portfolio category archive.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function jtest_is_category( $term = '' ) {

	return apply_filters( 'jtest_is_category', is_tax( jtest_get_category_taxonomy(), $term ) );
}
