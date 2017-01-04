<?php
/**
 * File for registering custom taxonomies.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Register taxonomies on the 'init' hook.
add_action( 'init', 'jtest_register_taxonomies', 9 );

# Filter the term updated messages.
add_filter( 'term_updated_messages', 'jtest_term_updated_messages', 5 );

/**
 * Returns the name of the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function jtest_get_category_taxonomy() {

	return apply_filters( 'jtest_get_category_taxonomy', 'testimonial_category' );
}

/**
 * Returns the capabilities for the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function jtest_get_category_capabilities() {

	$caps = array(
		'manage_terms' => 'manage_testimonial_categories',
		'edit_terms'   => 'manage_testimonial_categories',
		'delete_terms' => 'manage_testimonial_categories',
		'assign_terms' => 'edit_testimonials'
	);

	return apply_filters( 'jtest_get_category_capabilities', $caps );
}

/**
 * Returns the labels for the portfolio category taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @return array
 */
function jtest_get_category_labels() {

	$labels = array(
		'name'                       => __( 'Categories',                           'testimonials' ),
		'singular_name'              => __( 'Category',                             'testimonials' ),
		'menu_name'                  => __( 'Categories',                           'testimonials' ),
		'name_admin_bar'             => __( 'Category',                             'testimonials' ),
		'search_items'               => __( 'Search Categories',                    'testimonials' ),
		'popular_items'              => __( 'Popular Categories',                   'testimonials' ),
		'all_items'                  => __( 'All Categories',                       'testimonials' ),
		'edit_item'                  => __( 'Edit Category',                        'testimonials' ),
		'view_item'                  => __( 'View Category',                        'testimonials' ),
		'update_item'                => __( 'Update Category',                      'testimonials' ),
		'add_new_item'               => __( 'Add New Category',                     'testimonials' ),
		'new_item_name'              => __( 'New Category Name',                    'testimonials' ),
		'not_found'                  => __( 'No categories found.',                 'testimonials' ),
		'no_terms'                   => __( 'No categories',                        'testimonials' ),
		'items_list_navigation'      => __( 'Categories list navigation',           'testimonials' ),
		'items_list'                 => __( 'Categories list',                      'testimonials' ),

		// Hierarchical only.
		'select_name'                => __( 'Select Category',                      'testimonials' ),
		'parent_item'                => __( 'Parent Category',                      'testimonials' ),
		'parent_item_colon'          => __( 'Parent Category:',                     'testimonials' ),
	);

	return apply_filters( 'jtest_get_category_labels', $labels );
}

/**
 * Register taxonomies for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void.
 */
function jtest_register_taxonomies() {

	// Set up the arguments for the portfolio category taxonomy.
	$cat_args = array(
		'public'            => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'query_var'         => jtest_get_category_taxonomy(),
		'capabilities'      => jtest_get_category_capabilities(),
		'labels'            => jtest_get_category_labels(),

		// The rewrite handles the URL structure.
		'rewrite' => array(
			'slug'         => jtest_get_category_rewrite_slug(),
			'with_front'   => false,
			'hierarchical' => false,
			'ep_mask'      => EP_NONE
		),
	);

	// Register the taxonomies.
	register_taxonomy( jtest_get_category_taxonomy(), jtest_get_testimonial_post_type(), apply_filters( 'jtest_category_taxonomy_args', $cat_args ) );
}

/**
 * Filters the term updated messages in the admin.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $messages
 * @return array
 */
function jtest_term_updated_messages( $messages ) {

	$cat_taxonomy = jtest_get_category_taxonomy();

	// Add the portfolio category messages.
	$messages[ $cat_taxonomy ] = array(
		0 => '',
		1 => __( 'Category added.',       'testimonials' ),
		2 => __( 'Category deleted.',     'testimonials' ),
		3 => __( 'Category updated.',     'testimonials' ),
		4 => __( 'Category not added.',   'testimonials' ),
		5 => __( 'Category not updated.', 'testimonials' ),
		6 => __( 'Categories deleted.',   'testimonials' ),
	);

	return $messages;
}
