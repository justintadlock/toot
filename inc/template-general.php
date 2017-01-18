<?php
/**
 * General template tags for theme authors to use in their themes.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Conditional tag to check if viewing any plugin page.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function toot_is_testimonial_page() {

	return apply_filters( 'toot_is_testimonial_page', toot_is_archive() || toot_is_single_testimonial() );
}

/**
 * Conditional tag to check if viewing any type of Toot archive page.
 *
 * @since  2.0.0
 * @access public
 * @return bool
 */
function toot_is_archive() {

	$is_archive = toot_is_testimonial_archive() || toot_is_category();

	return apply_filters( 'toot_is_archive', $is_archive );
}

/**
 * Conditional tag to check if viewing a testimonial category archive.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $term
 * @return bool
 */
function toot_is_category( $term = '' ) {

	return apply_filters( 'toot_is_category', is_tax( toot_get_category_taxonomy(), $term ) );
}
