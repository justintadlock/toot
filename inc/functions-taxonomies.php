<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register taxonomies on the 'init' hook.
add_action( 'init', 'toot_register_taxonomies', 9 );

# Filter the term updated messages.
add_filter( 'term_updated_messages', 'toot_term_updated_messages', 5 );

/**
 * Returns the name of the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function toot_get_category_taxonomy() {

	return apply_filters( 'toot_get_category_taxonomy', 'testimonial_category' );
}

/**
 * Returns the capabilities for the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function toot_get_category_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_testimonial_categories',
		'edit_terms'   => 'manage_testimonial_categories',
		'delete_terms' => 'manage_testimonial_categories',
		'assign_terms' => 'edit_testimonials'
	);

	return apply_filters( 'toot_get_category_capabilities', $caps );
}

/**
 * Returns the labels for the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function toot_get_category_labels() {

	$labels = array(
		'name'                       => __( 'Categories',                           'toot' ),
		'singular_name'              => __( 'Category',                             'toot' ),
		'menu_name'                  => __( 'Categories',                           'toot' ),
		'name_admin_bar'             => __( 'Category',                             'toot' ),
		'search_items'               => __( 'Search Categories',                    'toot' ),
		'popular_items'              => __( 'Popular Categories',                   'toot' ),
		'all_items'                  => __( 'All Categories',                       'toot' ),
		'edit_item'                  => __( 'Edit Category',                        'toot' ),
		'view_item'                  => __( 'View Category',                        'toot' ),
		'update_item'                => __( 'Update Category',                      'toot' ),
		'add_new_item'               => __( 'Add New Category',                     'toot' ),
		'new_item_name'              => __( 'New Category Name',                    'toot' ),
		'not_found'                  => __( 'No categories found.',                 'toot' ),
		'no_terms'                   => __( 'No categories',                        'toot' ),
		'items_list_navigation'      => __( 'Categories list navigation',           'toot' ),
		'items_list'                 => __( 'Categories list',                      'toot' ),

		// Hierarchical only.
		'select_name'                => __( 'Select Category',                      'toot' ),
		'parent_item'                => __( 'Parent Category',                      'toot' ),
		'parent_item_colon'          => __( 'Parent Category:',                     'toot' ),
	);

	return apply_filters( 'toot_get_category_labels', $labels );
}

/**
 * Register taxonomies for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void.
 */
function toot_register_taxonomies() {

	// Set up the arguments for the portfolio category taxonomy.
	$cat_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => toot_get_category_taxonomy(),
		'capabilities'      => toot_get_category_capabilities(),
		'labels'            => toot_get_category_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => toot_get_category_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Register the taxonomies.
	register_taxonomy( toot_get_category_taxonomy(), toot_get_testimonial_post_type(), apply_filters( 'toot_category_taxonomy_args', $cat_args ) );
}

/**
 * Filters the term updated messages in the admin.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @return array
 */
function toot_term_updated_messages( $messages ) {

	$cat_taxonomy = toot_get_category_taxonomy();

	// Add the portfolio category messages.
	$messages[ $cat_taxonomy ] = array(
		0 => '',
		1 => __( 'Category added.',       'toot' ),
		2 => __( 'Category deleted.',     'toot' ),
		3 => __( 'Category updated.',     'toot' ),
		4 => __( 'Category not added.',   'toot' ),
		5 => __( 'Category not updated.', 'toot' ),
		6 => __( 'Categories deleted.',   'toot' ),
	);

	return $messages;
}
