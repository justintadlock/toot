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

/**
 * Registers admin scripts.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_admin_register_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_register_script( 'toot-edit-testimonial', toot_plugin()->js_uri . "edit-testimonial{$min}.js", array( 'jquery' ), '', true );

	// Localize our script with some text we want to pass in.
	$i18n = array(
		'label_sticky'     => esc_html__( 'Sticky',     'toot' ),
		'label_not_sticky' => esc_html__( 'Not Sticky', 'toot' ),
	);

	wp_localize_script( 'toot-edit-testimonial', 'toot_i18n', $i18n );
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
