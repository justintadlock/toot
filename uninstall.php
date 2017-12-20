<?php
/**
 * Plugin uninstall file.
 *
 * @package    Toot
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Make sure we're actually uninstalling the plugin.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	wp_die( sprintf( __( '%s should only be called when uninstalling the plugin.', 'toot' ), '<code>' . __FILE__ . '</code>' ) );

/* === Delete plugin options. === */

// Remove 1.0.0+ options.
delete_option( 'toot_settings'            );
delete_option( 'toot_sticky_testimonials' );

/* === Remove capabilities added by the plugin. === */

// Get the administrator role.
$role = get_role( 'administrator' );

// If the administrator role exists, remove added capabilities for the plugin.
if ( ! is_null( $role ) ) {

	// Taxonomy caps.
	$role->remove_cap( 'assign_testimonial_categories' );
	$role->remove_cap( 'delete_testimonial_categories' );
	$role->remove_cap( 'edit_testimonial_categories'   );
	$role->remove_cap( 'manage_testimonial_categories' );

	// Post type caps.
	$role->remove_cap( 'create_testimonials'           );
	$role->remove_cap( 'edit_testimonials'             );
	$role->remove_cap( 'edit_others_testimonials'      );
	$role->remove_cap( 'publish_testimonials'          );
	$role->remove_cap( 'read_private_testimonials'     );
	$role->remove_cap( 'delete_testimonials'           );
	$role->remove_cap( 'delete_private_testimonials'   );
	$role->remove_cap( 'delete_published_testimonials' );
	$role->remove_cap( 'delete_others_testimonials'    );
	$role->remove_cap( 'edit_private_testimonials'     );
	$role->remove_cap( 'edit_published_testimonials'   );
}
