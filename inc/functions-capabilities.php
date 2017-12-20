<?php
/**
 * Hooks into the Members plugin and registers capabilities.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register caps.
add_action( 'members_register_caps', 'toot_register_caps' );

/**
 * Registers caps with the Members plugin.  This gives pretty labels for each
 * of the capabilities.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_register_caps() {

	$caps  = array();
	$group = sprintf( 'type-%s', toot_get_testimonial_post_type() );

	// Testimonial caps.
	$caps['create_testimonials']           = __( 'Create Testimonials',           'toot' );
	$caps['edit_testimonials']             = __( 'Edit Testimonials',             'toot' );
	$caps['edit_others_testimonials']      = __( "Edit Others' Testimonials",     'toot' );
	$caps['read_private_testimonials']     = __( 'Read Private Testimonials',     'toot' );
	$caps['delete_testimonials']           = __( 'Delete Testimonials',           'toot' );
	$caps['delete_private_testimonials']   = __( 'Delete Private Testimonials',   'toot' );
	$caps['delete_published_testimonials'] = __( 'Delete Published Testimonials', 'toot' );
	$caps['delete_others_testimonials']    = __( "Delete Others' Testimonials",   'toot' );
	$caps['edit_private_testimonials']     = __( 'Edit Private Testimonials',     'toot' );
	$caps['edit_published_testimonials']   = __( 'Edit Published Testimonials',   'toot' );
	$caps['publish_testimonials']          = __( 'Publish Testimonials',          'toot' );

	// Category caps.
	$caps['assign_testimonial_categories'] = __( 'Assign Testimonial Categories', 'toot' );
	$caps['delete_testimonial_categories'] = __( 'Delete Testimonial Categories', 'toot' );
	$caps['edit_testimonial_categories']   = __( 'Edit Testimonial Categories',   'toot' );
	$caps['manage_testimonial_categories'] = __( 'Manage Testimonial Categories', 'toot' );

	// Register each of the capabilities.
	foreach ( $caps as $name => $label )
		members_register_cap( $name, array( 'label' => $label, 'group' => $group ) );
}
