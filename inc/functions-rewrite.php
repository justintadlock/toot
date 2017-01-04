<?php
/**
 * Plugin rewrite functions.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the testimonial rewrite slug used for single testimonials.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_testimonial_rewrite_slug() {
	$rewrite_base     = jtest_get_rewrite_base();
	$testimonial_base = jtest_get_testimonial_rewrite_base();

	$slug = $testimonial_base ? trailingslashit( $rewrite_base ) . $testimonial_base : $rewrite_base;

	return apply_filters( 'jtest_get_testimonial_rewrite_slug', $slug );
}

/**
 * Returns the category rewrite slug used for category archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_category_rewrite_slug() {
	$rewrite_base  = jtest_get_rewrite_base();
	$category_base = jtest_get_category_rewrite_base();

	$slug = $category_base ? trailingslashit( $rewrite_base ) . $category_base : $rewrite_base;

	return apply_filters( 'jtest_get_category_rewrite_slug', $slug );
}
