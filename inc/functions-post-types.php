<?php
/**
 * File for registering custom post types.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register custom post types on the 'init' hook.
add_action( 'init', 'toot_register_post_types' );

# Filter the "enter title here" text.
add_filter( 'enter_title_here', 'toot_enter_title_here', 10, 2 );

# Filter the bulk and post updated messages.
add_filter( 'bulk_post_updated_messages', 'toot_bulk_post_updated_messages', 5, 2 );
add_filter( 'post_updated_messages',      'toot_post_updated_messages',      5    );

/**
 * Returns the name of the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function toot_get_testimonial_post_type() {

	return apply_filters( 'toot_get_testimonial_post_type', 'testimonial' );
}

/**
 * Returns the capabilities for the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function toot_get_testimonial_capabilities() {

	$caps = array(

		// meta caps (don't assign these to roles)
		'edit_post'              => 'edit_testimonial',
		'read_post'              => 'read_testimonial',
		'delete_post'            => 'delete_testimonial',

		// primitive/meta caps
		'create_posts'           => 'create_testimonials',

		// primitive caps used outside of map_meta_cap()
		'edit_posts'             => 'edit_testimonials',
		'edit_others_posts'      => 'edit_others_testimonials',
		'publish_posts'          => 'publish_testimonials',
		'read_private_posts'     => 'read_private_testimonials',

		// primitive caps used inside of map_meta_cap()
		'read'                   => 'read',
		'delete_posts'           => 'delete_testimonials',
		'delete_private_posts'   => 'delete_private_testimonials',
		'delete_published_posts' => 'delete_published_testimonials',
		'delete_others_posts'    => 'delete_others_testimonials',
		'edit_private_posts'     => 'edit_private_testimonials',
		'edit_published_posts'   => 'edit_published_testimonials'
	);

	return apply_filters( 'toot_get_testimonial_capabilities', $caps );
}

/**
 * Returns the labels for the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function toot_get_testimonial_labels() {

	$labels = array(
		'name'                  => __( 'Testimonials',                   'toot' ),
		'singular_name'         => __( 'Testimonial',                    'toot' ),
		'menu_name'             => __( 'Testimonials',                   'toot' ),
		'name_admin_bar'        => __( 'Testimonial',                    'toot' ),
		'add_new'               => __( 'New Testimonial',                'toot' ),
		'add_new_item'          => __( 'Add New Testimonial',            'toot' ),
		'edit_item'             => __( 'Edit Testimonial',               'toot' ),
		'new_item'              => __( 'New Testimonial',                'toot' ),
		'view_item'             => __( 'View Testimonial',               'toot' ),
		'view_items'            => __( 'View Testimonials',              'toot' ),
		'search_items'          => __( 'Search Testimonials',            'toot' ),
		'not_found'             => __( 'No testimonials found',          'toot' ),
		'not_found_in_trash'    => __( 'No testimonials found in trash', 'toot' ),
		'all_items'             => __( 'Testimonials',                   'toot' ),
		'featured_image'        => __( 'Author Image',                   'toot' ),
		'set_featured_image'    => __( 'Set author image',               'toot' ),
		'remove_featured_image' => __( 'Remove author image',            'toot' ),
		'use_featured_image'    => __( 'Use as author image',            'toot' ),
		'insert_into_item'      => __( 'Insert into testimonial',        'toot' ),
		'uploaded_to_this_item' => __( 'Uploaded to this testimonial',   'toot' ),
		'filter_items_list'     => __( 'Filter testimonials list',       'toot' ),
		'items_list_navigation' => __( 'Testimonials list navigation',   'toot' ),
		'items_list'            => __( 'Testimonials list',              'toot' ),

		// Custom labels b/c WordPress doesn't have anything to handle this.
		'archive_title'         => toot_get_archive_title(),
	);

	return apply_filters( 'toot_get_testimonial_labels', $labels );
}

/**
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function toot_register_post_types() {

	// Set up the arguments for the portfolio testimonial post type.
	$testimonial_args = array(
		'description'         => toot_get_archive_description(),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-testimonial',
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => toot_get_rewrite_base(),
		'query_var'           => toot_get_testimonial_post_type(),
		'capability_type'     => 'testimonial',
		'map_meta_cap'        => true,
		'capabilities'        => toot_get_testimonial_capabilities(),
		'labels'              => toot_get_testimonial_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'       => toot_get_testimonial_rewrite_slug(),
			'with_front' => false,
			'pages'      => true,
			'feeds'      => true,
			'ep_mask'    => EP_PERMALINK,
		),

		// What features the post type supports.
		'supports' => array(
			'title',
			'editor',
			'thumbnail',

			// Theme/Plugin feature support.
			'custom-background', // Custom Background Extended
			'custom-header',     // Custom Header Extended
		)
	);

	// Register the post types.
	register_post_type( toot_get_testimonial_post_type(), apply_filters( 'toot_testimonial_post_type_args', $testimonial_args ) );
}

/**
 * Custom "enter title here" text.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  object  $post
 * @return string
 */
function toot_enter_title_here( $title, $post ) {

	return toot_get_testimonial_post_type() === $post->post_type ? esc_html__( 'Enter testimonial author', 'toot' ) : $title;
}

/**
 * Adds custom post updated messages on the edit post screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @global object $post
 * @global int    $post_ID
 * @return array
 */
function toot_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$testimonial_type = toot_get_testimonial_post_type();

	if ( $testimonial_type !== $post->post_type )
		return $messages;

	// Get permalink and preview URLs.
	$permalink   = get_permalink( $post_ID );
	$preview_url = get_preview_post_link( $post );

	// Translators: Scheduled testimonial date format. See http://php.net/date
	$scheduled_date = date_i18n( __( 'M j, Y @ H:i', 'toot' ), strtotime( $post->post_date ) );

	// Set up view links.
	$preview_link   = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $preview_url ), esc_html__( 'Preview testimonial', 'toot' ) );
	$scheduled_link = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $permalink ),   esc_html__( 'Preview testimonial', 'toot' ) );
	$view_link      = sprintf( ' <a href="%1$s">%2$s</a>',                 esc_url( $permalink ),   esc_html__( 'View testimonial',    'toot' ) );

	// Post updated messages.
	$messages[ $testimonial_type ] = array(
		 1 => esc_html__( 'Testimonial updated.', 'toot' ) . $view_link,
		 4 => esc_html__( 'Testimonial updated.', 'toot' ),
		 // Translators: %s is the date and time of the revision.
		 5 => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Testimonial restored to revision from %s.', 'toot' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => esc_html__( 'Testimonial published.', 'toot' ) . $view_link,
		 7 => esc_html__( 'Testimonial saved.', 'toot' ),
		 8 => esc_html__( 'Testimonial submitted.', 'toot' ) . $preview_link,
		 9 => sprintf( esc_html__( 'Testimonial scheduled for: %s.', 'toot' ), "<strong>{$scheduled_date}</strong>" ) . $scheduled_link,
		10 => esc_html__( 'Testimonial draft updated.', 'toot' ) . $preview_link,
	);

	return $messages;
}

/**
 * Adds custom bulk post updated messages on the manage testimonials screen.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @param  array  $counts
 * @return array
 */
function toot_bulk_post_updated_messages( $messages, $counts ) {

	$type = toot_get_testimonial_post_type();

	$messages[ $type ]['updated']   = _n( '%s testimonial updated.',                             '%s testimonials updated.',                               $counts['updated'],   'toot' );
	$messages[ $type ]['locked']    = _n( '%s testimonial not updated, somebody is editing it.', '%s testimonials not updated, somebody is editing them.', $counts['locked'],    'toot' );
	$messages[ $type ]['deleted']   = _n( '%s testimonial permanently deleted.',                 '%s testimonials permanently deleted.',                   $counts['deleted'],   'toot' );
	$messages[ $type ]['trashed']   = _n( '%s testimonial moved to the Trash.',                  '%s testimonials moved to the trash.',                    $counts['trashed'],   'toot' );
	$messages[ $type ]['untrashed'] = _n( '%s testimonial restored from the Trash.',             '%s testimonials restored from the trash.',               $counts['untrashed'], 'toot' );

	return $messages;
}
