<?php
/**
 * Admin-related functions and filters.
 *
 * @package    Testimonails
 * @subpackage Admin
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register scripts and styles.
add_action( 'admin_enqueue_scripts', 'jtest_admin_register_scripts', 0 );

# Registers testimonial details box sections, controls, and settings.
add_action( 'butterbean_register', 'jtest_testimonial_details_register', 5, 2 );

/**
 * Registers admin scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function jtest_admin_register_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'jtest-edit-testimonial', jtest_plugin()->js_uri . "edit-testimonial{$min}.js", array( 'jquery', 'wp-util' ), '', true );

	// Localize our script with some text we want to pass in.
	$i18n = array(
		'label_sticky'     => esc_html__( 'Sticky',     'testimonials' ),
		'label_not_sticky' => esc_html__( 'Not Sticky', 'testimonials' ),
	);

	wp_localize_script( 'jtest-edit-testimonial', 'jtest_i18n', $i18n );
}

/**
 * Registers the default cap groups.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function jtest_testimonial_details_register( $butterbean, $post_type ) {

	if ( $post_type !== jtest_get_testimonial_post_type() )
		return;

	$butterbean->register_manager( 'jtest-testimonial',
		array(
			'post_type' => $post_type,
			'context'   => 'normal',
			'priority'  => 'high',
			'label'     => esc_html__( 'Testimonial Details', 'testimonials' )
		)
	);

	$manager = $butterbean->get_manager( 'jtest-testimonial' );

	/* === Register Sections === */

	// General section.
	$manager->register_section( 'general',
		array(
			'label' => esc_html__( 'General', 'testimonials' ),
			'icon'  => 'dashicons-admin-generic'
		)
	);

	/* === Register Fields === */

	$url_args = array(
		'type'        => 'url',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://themehybrid.com' ),
		'label'       => esc_html__( 'URL', 'testimonials' ),
		'description' => esc_html__( 'Enter the URL of the testimonial Web page.', 'testimonials' )
	);

	$email_args = array(
		'type'        => 'email',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'example@example.com', 'testimonials' ) ),
		'label'       => esc_html__( 'Email', 'testimonials' ),
		'description' => esc_html__( 'Enter the email address of the testimonial author to use their avatar.', 'testimonials' )
	);

	$manager->register_field( 'url',      $url_args,      array( 'sanitize_callback' => 'esc_url_raw'    ) );
	$manager->register_field( 'email',    $email_args,    array( 'sanitize_callback' => 'sanitize_email' ) );
}

/**
 * Helper function for getting the correct slug for the settings page.  This is useful
 * for add-on plugins that need to add custom setting sections or fields to the settings
 * screen for the plugin.
 *
 * @since  2.0.0
 * @access public
 * @return string
 */
function jtest_get_settings_page_slug() {

	return sprintf( '%s_page_jtest-settings', jtest_get_testimonial_post_type() );
}

/**
 * Help sidebar for all of the help tabs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_help_sidebar_text() {

	// Get docs and help links.
	$docs_link = sprintf( '<li><a href="http://themehybrid.com/docs">%s</a></li>', esc_html__( 'Documentation', 'custom-cotent-portfolio' ) );
	$help_link = sprintf( '<li><a href="http://themehybrid.com/board/topics">%s</a></li>', esc_html__( 'Support Forums', 'testimonials' ) );

	// Return the text.
	return sprintf(
		'<p><strong>%s</strong></p><ul>%s%s</ul>',
		esc_html__( 'For more information:', 'testimonials' ),
		$docs_link,
		$help_link
	);
}
