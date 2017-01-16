<?php
/**
 * Plugin rewrite functions.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
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
function toot_get_testimonial_rewrite_slug() {
	$rewrite_base     = toot_get_rewrite_base();
	$testimonial_base = toot_get_testimonial_rewrite_base();

	$slug = $testimonial_base ? trailingslashit( $rewrite_base ) . $testimonial_base : $rewrite_base;

	return apply_filters( 'toot_get_testimonial_rewrite_slug', $slug );
}

/**
 * Returns the category rewrite slug used for category archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function toot_get_category_rewrite_slug() {
	$rewrite_base  = toot_get_rewrite_base();
	$category_base = toot_get_category_rewrite_base();

	$slug = $category_base ? trailingslashit( $rewrite_base ) . $category_base : $rewrite_base;

	return apply_filters( 'toot_get_category_rewrite_slug', $slug );
}
