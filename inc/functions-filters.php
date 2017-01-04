<?php
/**
 * Various functions, filters, and actions used by the plugin.
 *
 * @package    Testimonails
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

# Check theme support.
add_action( 'wp_loaded', 'jtest_check_theme_support', 0 );

# Template hierarchy.
add_filter( 'template_include', 'jtest_template_include', 5 );

# Add sticky posts to the front of the line.
add_filter( 'the_posts', 'jtest_posts_sticky_filter', 10, 2 );

# Filter the post type archive title.
add_filter( 'post_type_archive_title', 'jtest_post_type_archive_title', 5, 2 );

# Filter the archive title and description.
add_filter( 'get_the_archive_title',       'jtest_get_the_archive_title',       5 );
add_filter( 'get_the_archive_description', 'jtest_get_the_archive_description', 5 );

# Filter the post type permalink.
add_filter( 'post_type_link', 'jtest_post_type_link', 10, 2 );

# Force taxonomy term selection.
add_action( 'save_post', 'jtest_force_term_selection' );

# Filter the Breadcrumb Trail plugin args.
add_filter( 'breadcrumb_trail_args', 'jtest_breadcrumb_trail_args', 15 );

/**
 * Checks if the theme supports `testimonials`.  If not, it runs specific filters
 * to make themes without support work a little better.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function jtest_check_theme_support() {

	if ( ! current_theme_supports( 'testimonials' ) )
		add_filter( 'the_content', 'jtest_the_content_filter', 25 );
}

/**
 * Basic top-level template hierarchy. I generally prefer to leave this functionality up to
 * themes.  This is just a foundation to build upon if needed.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $template
 * @return string
 */
function jtest_template_include( $template ) {

	// Bail if not a portfolio page.
	if ( ! jtest_is_testimonial_page() )
		return $template;

	$templates = array();

	// Author archive.
	if ( jtest_is_category() ) {
		$templates[] = 'testimonial-category.php';
		$templates[] = 'testimonial-archive.php';

	// Testimonial archive.
	} else if ( jtest_is_testimonial_archive() ) {
		$templates[] = 'testimonial-archive.php';

	// Single testimonial.
	} else if ( jtest_is_single_testimonial() ) {
		$templates[] = 'single-testimonial.php';
	}

	// Fallback template.
	$templates[] = 'testimonials.php';

	// Check if we have a template.
	$has_template = locate_template( apply_filters( 'jtest_template_hierarchy', $templates ) );

	// Return the template.
	return $has_template ? $has_template : $template;
}

/**
 * Filter on `the_content` for themes that don't support the plugin.  This filter outputs the basic
 * testimonial metadata only.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $content
 * @return string
 */
function jtest_the_content_filter( $content ) {

	if ( in_the_loop() && jtest_is_single_testimonial() && jtest_is_testimonial() && ! post_password_required() ) {

		$testimonial_meta = '';

		if ( $testimonial_meta )
			$content .= sprintf( '<p class="testimonial-meta">%s</p>', $testimonial_meta );
	}

	return $content;
}

/**
 * Filter on `the_posts` for the testimonial archive. Moves sticky posts to the top of
 * the testimonial archive list.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts
 * @param  object $query
 * @return array
 */
function jtest_posts_sticky_filter( $posts, $query ) {

	// Allow devs to filter when to show sticky testimonials.
	$show_stickies = apply_filters( 'jtest_show_stickies', $query->is_main_query() && ! is_admin() && jtest_is_testimonial_archive() && ! is_paged() );

	// If we should show stickies, let's get them.
	if ( $show_stickies ) {

		remove_filter( 'the_posts', 'jtest_posts_sticky_filter' );

		$posts = jtest_add_stickies( $posts, jtest_get_sticky_testimonials() );
	}

	return $posts;
}

/**
 * Adds sticky posts to the front of the line with any given set of posts and stickies.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $posts         Array of post objects.
 * @param  array  $sticky_posts  Array of post IDs.
 * @return array
 */
function jtest_add_stickies( $posts, $sticky_posts ) {

	// Only do this if on the first page and we indeed have stickies.
	if ( ! empty( $sticky_posts ) ) {

		$num_posts     = count( $posts );
		$sticky_offset = 0;

		// Loop over posts and relocate stickies to the front.
		for ( $i = 0; $i < $num_posts; $i++ ) {

			if ( in_array( $posts[ $i ]->ID, $sticky_posts ) ) {

				$sticky_post = $posts[ $i ];

				// Remove sticky from current position.
				array_splice( $posts, $i, 1);

				// Move to front, after other stickies.
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );

				// Increment the sticky offset. The next sticky will be placed at this offset.
				$sticky_offset++;

				// Remove post from sticky posts array.
				$offset = array_search( $sticky_post->ID, $sticky_posts );

				unset( $sticky_posts[ $offset ] );
			}
		}

		// Fetch sticky posts that weren't in the query results.
		if ( ! empty( $sticky_posts ) ) {

			$args = array(
					'post__in'    => $sticky_posts,
					'post_type'   => jtest_get_testimonial_post_type(),
					'post_status' => 'publish',
					'nopaging'    => true
			);

			$stickies = get_posts( $args );

			foreach ( $stickies as $sticky_post ) {
				array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
				$sticky_offset++;
			}
		}
	}

	return $posts;
}

/**
 * Filter on 'post_type_archive_title' to allow for the use of the 'archive_title' label that isn't supported
 * by WordPress.  That's okay since we can roll our own labels.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @param  string  $post_type
 * @return string
 */
function jtest_post_type_archive_title( $title, $post_type ) {

	$testimonial_type = jtest_get_testimonial_post_type();

	return $testimonial_type === $post_type ? get_post_type_object( jtest_get_testimonial_post_type() )->labels->archive_title : $title;
}

/**
 * Filters the archive title. Note that we need this additional filter because core WP does
 * things like add "Archives:" in front of the archive title.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $title
 * @return string
 */
function jtest_get_the_archive_title( $title ) {

	if ( jtest_is_testimonial_archive() )
		$title = post_type_archive_title( '', false );

	return $title;
}

/**
 * Filters the archive description.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $desc
 * @return string
 */
function jtest_get_the_archive_description( $desc ) {

	if ( jtest_is_testimonial_archive() && ! $desc )
		$desc = jtest_get_portfolio_description();

	return $desc;
}

/**
 * Filter on `post_type_link` to make sure that single portfolio testimonials have the correct
 * permalink.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $post_link
 * @param  object  $post
 * @return string
 */
function jtest_post_type_link( $post_link, $post ) {

	// Bail if this isn't a portfolio testimonial.
	if ( jtest_get_testimonial_post_type() !== $post->post_type )
		return $post_link;

	$cat_taxonomy = jtest_get_category_taxonomy();
	$category     = '';

	// Check for the category.
	if ( false !== strpos( $post_link, "%{$cat_taxonomy}%" ) ) {

		// Get the terms.
		$terms = get_the_terms( $post, $cat_taxonomy );

		// Check that terms were returned.
		if ( $terms ) {

			usort( $terms, '_usort_terms_by_ID' );

			$category = $terms[0]->slug;
		}
	}

	$rewrite_tags = array( '%testimonial_category%' );

	$map_tags = array( $category );

	return str_replace( $rewrite_tags, $map_tags, $post_link );
}

/**
 * If a testimonial has `%testimonial_category%` in its permalink structure,
 * it must have a term set for the taxonomy.  This function is a callback on `save_post`
 * that checks if a term is set.  If not, it forces the first term of the taxonomy to be
 * the selected term.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @return void
 */
function jtest_force_term_selection( $post_id ) {

	if ( jtest_is_testimonial( $post_id ) ) {

		$testimonial_base = jtest_get_testimonial_rewrite_base();
		$cat_tax          = jtest_get_category_taxonomy();

		if ( false !== strpos( $testimonial_base, "%{$cat_tax}%" ) )
			jtest_set_term_if_none( $post_id, $cat_tax, jtest_get_default_category() );
	}
}

/**
 * Checks if a post has a term of the given taxonomy.  If not, set it with the first
 * term available from the taxonomy.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @param  string  $taxonomy
 * @param  int     $default
 * @return void
 */
function jtest_set_term_if_none( $post_id, $taxonomy, $default = 0 ) {

	// Get the current post terms.
	$terms = wp_get_post_terms( $post_id, $taxonomy );

	// If no terms are set, let's roll.
	if ( ! $terms ) {

		$new_term = false;

		// Get the default term if set.
		if ( $default )
			$new_term = get_term( $default, $taxonomy );

		// If no default term or if there's an error, get the first term.
		if ( ! $new_term || is_wp_error( $new_term ) ) {
			$available = get_terms( $taxonomy, array( 'number' => 1 ) );

			// Get the first term.
			$new_term = $available ? array_shift( $available ) : false;
		}

		// Only run if there are taxonomy terms.
		if ( $new_term ) {
			$tax_object = get_taxonomy( $taxonomy );

			// Use the ID for hierarchical taxonomies. Use the slug for non-hierarchical.
			$slug_or_id = $tax_object->hierarchical ? $new_term->term_id : $new_term->slug;

			// Set the new post term.
			wp_set_post_terms( $post_id, $slug_or_id, $taxonomy, true );
		}
	}
}

/**
 * Filters the Breadcrumb Trail plugin arguments.  We're basically just telling it to show the
 * `testimonial_category` taxonomy when viewing single portfolio testimonials.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return array
 */
function jtest_breadcrumb_trail_args( $args ) {

	$testimonial_type = jtest_get_testimonial_post_type();
	$testimonial_base = jtest_get_testimonial_rewrite_base();

	if ( false === strpos( $testimonial_base, '%' ) && ! isset( $args['post_taxonomy'][ $testimonial_type ] ) )
		$args['post_taxonomy'][ $testimonial_type ] = jtest_get_category_taxonomy();

	return $args;
}
