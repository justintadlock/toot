<?php
/**
 * Plugin options functions.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Returns the portfolio title.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_archive_title() {
	return apply_filters( 'jtest_get_archive_title', jtest_get_setting( 'archive_title' ) );
}

/**
 * Returns the portfolio description.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_archive_description() {
	return apply_filters( 'jtest_get_archive_description', jtest_get_setting( 'archive_description' ) );
}

/**
 * Returns the rewrite base. Used for the testimonial archive and as a prefix for taxonomy,
 * author, and any other slugs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_rewrite_base() {
	return apply_filters( 'jtest_get_rewrite_base', jtest_get_setting( 'rewrite_base' ) );
}

/**
 * Returns the testimonial rewrite base. Used for single testimonials.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_testimonial_rewrite_base() {
	return apply_filters( 'jtest_get_testimonial_rewrite_base', jtest_get_setting( 'testimonial_rewrite_base' ) );
}

/**
 * Returns the category rewrite base. Used for category archives.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_category_rewrite_base() {
	return apply_filters( 'jtest_get_category_rewrite_base', jtest_get_setting( 'category_rewrite_base' ) );
}

/**
 * Returns the default category term ID.
 *
 * @since  1.0.0
 * @access public
 * @return int
 */
function jtest_get_default_category() {
	return apply_filters( 'jtest_get_default_category', 0 );
}

/**
 * Returns a plugin setting.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $setting
 * @return mixed
 */
function jtest_get_setting( $setting ) {

	$defaults = jtest_get_default_settings();
	$settings = wp_parse_args( get_option( 'jtest_settings', $defaults ), $defaults );

	return isset( $settings[ $setting ] ) ? $settings[ $setting ] : false;
}

/**
 * Returns the default settings for the plugin.
 *
 * @since  0.1.0
 * @access public
 * @return array
 */
function jtest_get_default_settings() {

	$settings = array(
		'archive_title'            => __( 'Testimonials', 'testimonials' ),
		'archive_description'      => '',
		'rewrite_base'             => 'testimonials',
		'testimonial_rewrite_base' => '',
		'category_rewrite_base'    => 'categories'
	);

	return $settings;
}
