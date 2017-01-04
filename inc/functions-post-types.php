<?php
/**
 * File for registering custom post types.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register custom post types on the 'init' hook.
add_action( 'init', 'jtest_register_post_types' );

# Filter the "enter title here" text.
add_filter( 'enter_title_here', 'jtest_enter_title_here', 10, 2 );

# Filter the bulk and post updated messages.
add_filter( 'bulk_post_updated_messages', 'jtest_bulk_post_updated_messages', 5, 2 );
add_filter( 'post_updated_messages',      'jtest_post_updated_messages',      5    );

/**
 * Returns the name of the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_testimonial_post_type() {

	return apply_filters( 'jtest_get_testimonial_post_type', 'testimonial' );
}

/**
 * Returns the capabilities for the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function jtest_get_testimonial_capabilities() {

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

	return apply_filters( 'jtest_get_testimonial_capabilities', $caps );
}

/**
 * Returns the labels for the testimonial post type.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function jtest_get_testimonial_labels() {

	$labels = array(
		'name'                  => __( 'Testimonials',                   'testimonials' ),
		'singular_name'         => __( 'Testimonial',                    'testimonials' ),
		'menu_name'             => __( 'Testimonials',                   'testimonials' ),
		'name_admin_bar'        => __( 'Testimonial',                    'testimonials' ),
		'add_new'               => __( 'New Testimonial',                'testimonials' ),
		'add_new_item'          => __( 'Add New Testimonial',            'testimonials' ),
		'edit_item'             => __( 'Edit Testimonial',               'testimonials' ),
		'new_item'              => __( 'New Testimonial',                'testimonials' ),
		'view_item'             => __( 'View Testimonial',               'testimonials' ),
		'view_items'            => __( 'View Testimonials',              'testimonials' ),
		'search_items'          => __( 'Search Testimonials',            'testimonials' ),
		'not_found'             => __( 'No testimonials found',          'testimonials' ),
		'not_found_in_trash'    => __( 'No testimonials found in trash', 'testimonials' ),
		'all_items'             => __( 'Testimonials',                   'testimonials' ),
		'featured_image'        => __( 'Author Image',                   'testimonials' ),
		'set_featured_image'    => __( 'Set author image',               'testimonials' ),
		'remove_featured_image' => __( 'Remove author image',            'testimonials' ),
		'use_featured_image'    => __( 'Use as author image',            'testimonials' ),
		'insert_into_item'      => __( 'Insert into testimonial',        'testimonials' ),
		'uploaded_to_this_item' => __( 'Uploaded to this testimonial',   'testimonials' ),
		'filter_items_list'     => __( 'Filter testimonials list',       'testimonials' ),
		'items_list_navigation' => __( 'Testimonials list navigation',   'testimonials' ),
		'items_list'            => __( 'Testimonials list',              'testimonials' ),

		// Custom labels b/c WordPress doesn't have anything to handle this.
		'archive_title'         => jtest_get_archive_title(),
	);

	return apply_filters( 'jtest_get_testimonial_labels', $labels );
}

/**
 * Registers post types needed by the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function jtest_register_post_types() {

	// Set up the arguments for the portfolio testimonial post type.
	$testimonial_args = array(
		'description'         => jtest_get_archive_description(),
		'public'              => true,
		'publicly_queryable'  => true,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => true,
		'exclude_from_search' => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => null,
		'menu_icon'           => 'dashicons-format-quote',
		'can_export'          => true,
		'delete_with_user'    => false,
		'hierarchical'        => false,
		'has_archive'         => jtest_get_rewrite_base(),
		'query_var'           => jtest_get_testimonial_post_type(),
		'capability_type'     => 'testimonial',
		'map_meta_cap'        => true,
		'capabilities'        => jtest_get_testimonial_capabilities(),
		'labels'              => jtest_get_testimonial_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'       => jtest_get_testimonial_rewrite_slug(),
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
	register_post_type( jtest_get_testimonial_post_type(), apply_filters( 'jtest_testimonial_post_type_args', $testimonial_args ) );
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
function jtest_enter_title_here( $title, $post ) {

	return jtest_get_testimonial_post_type() === $post->post_type ? esc_html__( 'Enter testimonial author', 'testimonials' ) : $title;
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
function jtest_post_updated_messages( $messages ) {
	global $post, $post_ID;

	$testimonial_type = jtest_get_testimonial_post_type();

	if ( $testimonial_type !== $post->post_type )
		return $messages;

	// Get permalink and preview URLs.
	$permalink   = get_permalink( $post_ID );
	$preview_url = get_preview_post_link( $post );

	// Translators: Scheduled testimonial date format. See http://php.net/date
	$scheduled_date = date_i18n( __( 'M j, Y @ H:i', 'testimonials' ), strtotime( $post->post_date ) );

	// Set up view links.
	$preview_link   = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $preview_url ), esc_html__( 'Preview testimonial', 'testimonials' ) );
	$scheduled_link = sprintf( ' <a target="_blank" href="%1$s">%2$s</a>', esc_url( $permalink ),   esc_html__( 'Preview testimonial', 'testimonials' ) );
	$view_link      = sprintf( ' <a href="%1$s">%2$s</a>',                 esc_url( $permalink ),   esc_html__( 'View testimonial',    'testimonials' ) );

	// Post updated messages.
	$messages[ $testimonial_type ] = array(
		 1 => esc_html__( 'Testimonial updated.', 'testimonials' ) . $view_link,
		 4 => esc_html__( 'Testimonial updated.', 'testimonials' ),
		 // Translators: %s is the date and time of the revision.
		 5 => isset( $_GET['revision'] ) ? sprintf( esc_html__( 'Testimonial restored to revision from %s.', 'testimonials' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		 6 => esc_html__( 'Testimonial published.', 'testimonials' ) . $view_link,
		 7 => esc_html__( 'Testimonial saved.', 'testimonials' ),
		 8 => esc_html__( 'Testimonial submitted.', 'testimonials' ) . $preview_link,
		 9 => sprintf( esc_html__( 'Testimonial scheduled for: %s.', 'testimonials' ), "<strong>{$scheduled_date}</strong>" ) . $scheduled_link,
		10 => esc_html__( 'Testimonial draft updated.', 'testimonials' ) . $preview_link,
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
function jtest_bulk_post_updated_messages( $messages, $counts ) {

	$type = jtest_get_testimonial_post_type();

	$messages[ $type ]['updated']   = _n( '%s testimonial updated.',                             '%s testimonials updated.',                               $counts['updated'],   'testimonials' );
	$messages[ $type ]['locked']    = _n( '%s testimonial not updated, somebody is editing it.', '%s testimonials not updated, somebody is editing them.', $counts['locked'],    'testimonials' );
	$messages[ $type ]['deleted']   = _n( '%s testimonial permanently deleted.',                 '%s testimonials permanently deleted.',                   $counts['deleted'],   'testimonials' );
	$messages[ $type ]['trashed']   = _n( '%s testimonial moved to the Trash.',                  '%s testimonials moved to the trash.',                    $counts['trashed'],   'testimonials' );
	$messages[ $type ]['untrashed'] = _n( '%s testimonial restored from the Trash.',             '%s testimonials restored from the trash.',               $counts['untrashed'], 'testimonials' );

	return $messages;
}
