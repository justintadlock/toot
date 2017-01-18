<?php
/**
 * Admin-related functions and filters.
 *
 * @package    Toot
 * @subpackage Admin
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register scripts and styles.
add_action( 'admin_enqueue_scripts', 'toot_admin_register_scripts', 0 );

# Registers testimonial details box sections, controls, and settings.
add_action( 'butterbean_register', 'toot_testimonial_details_register', 5, 2 );

/**
 * Registers admin scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_admin_register_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'toot-edit-testimonial', toot_plugin()->js_uri . "edit-testimonial{$min}.js", array( 'jquery', 'wp-util' ), '', true );

	// Localize our script with some text we want to pass in.
	$i18n = array(
		'label_sticky'     => esc_html__( 'Sticky',     'toot' ),
		'label_not_sticky' => esc_html__( 'Not Sticky', 'toot' ),
	);

	wp_localize_script( 'toot-edit-testimonial', 'toot_i18n', $i18n );
}

/**
 * Registers the default cap groups.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_testimonial_details_register( $butterbean, $post_type ) {

	if ( $post_type !== toot_get_testimonial_post_type() )
		return;

	$butterbean->register_manager( 'toot-testimonial',
		array(
			'post_type' => $post_type,
			'context'   => 'normal',
			'priority'  => 'high',
			'label'     => esc_html__( 'Testimonial Details', 'toot' )
		)
	);

	$manager = $butterbean->get_manager( 'toot-testimonial' );

	/* === Register Sections === */

	// General section.
	$manager->register_section( 'general',
		array(
			'label' => esc_html__( 'General', 'toot' ),
			'icon'  => 'dashicons-admin-generic'
		)
	);

	/* === Register Fields === */

	$url_args = array(
		'type'        => 'url',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => 'http://themehybrid.com' ),
		'label'       => esc_html__( 'URL', 'toot' ),
		'description' => esc_html__( 'Enter the URL of the testimonial Web page.', 'toot' )
	);

	$email_args = array(
		'type'        => 'email',
		'section'     => 'general',
		'attr'        => array( 'class' => 'widefat', 'placeholder' => __( 'example@example.com', 'toot' ) ),
		'label'       => esc_html__( 'Email', 'toot' ),
		'description' => esc_html__( 'Enter the email address of the testimonial author to use their avatar.', 'toot' )
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
function toot_get_settings_page_slug() {

	return sprintf( '%s_page_toot-settings', toot_get_testimonial_post_type() );
}

/**
 * Help sidebar for all of the help tabs.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function toot_get_help_sidebar_text() {

	// Get docs and help links.
	$docs_link = sprintf( '<li><a href="http://themehybrid.com/docs">%s</a></li>', esc_html__( 'Documentation', 'toot' ) );
	$help_link = sprintf( '<li><a href="http://themehybrid.com/board/topics">%s</a></li>', esc_html__( 'Support Forums', 'toot' ) );

	// Return the text.
	return sprintf(
		'<p><strong>%s</strong></p><ul>%s%s</ul>',
		esc_html__( 'For more information:', 'toot' ),
		$docs_link,
		$help_link
	);
}
