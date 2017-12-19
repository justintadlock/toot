<?php
/**
 * Template tags related to testimonials for theme authors to use in their theme templates.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Makes sure the post ID is an absolute integer if passed in.  Else, returns the result
 * of `get_the_ID()`.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return int
 */
function toot_get_testimonial_id( $post_id = '' ) {

	return $post_id ? absint( $post_id ) : get_the_ID();
}

/**
 * Checks if viewing a single testimonial.
 *
 * @since  1.0.0
 * @access public
 * @param  mixed  $post
 * @return bool
 */
function toot_is_single_testimonial( $post = '' ) {

	$is_single = is_singular( toot_get_testimonial_post_type() );

	if ( $is_single && $post )
		$is_single = is_single( $post );

	return apply_filters( 'toot_is_single_testimonial', $is_single, $post );
}

/**
 * Checks if viewing the testimonial archive.
 *
 * @since  1.0.0
 * @access public
 * @return bool
 */
function toot_is_testimonial_archive() {

	return apply_filters( 'toot_is_testimonial_archive', is_post_type_archive( toot_get_testimonial_post_type() ) );
}

/**
 * Checks if the current post is a testimonial.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return bool
 */
function toot_is_testimonial( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	return apply_filters( 'toot_is_testimonial', toot_get_testimonial_post_type() === get_post_type( $post_id ), $post_id );
}

/**
 * Conditional check to see if a testimonial has the "sticky" type.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $testimonial_id
 * @return bool
 */
function toot_is_testimonial_sticky( $testimonial_id = 0 ) {
	$testimonial_id = toot_get_testimonial_id( $testimonial_id );

	return apply_filters( 'toot_is_testimonial_sticky', in_array( $testimonial_id, toot_get_sticky_testimonials() ), $testimonial_id );
}

/**
 * Outputs the testimonial URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function toot_testimonial_url( $post_id = '' ) {

	$url = toot_get_testimonial_url( $post_id );

	echo $url ? esc_url( $url ) : '';
}

/**
 * Returns the testimonial URL.
 *
 * @since  1.0.0
 * @access public
 * @param  int    $post_id
 * @return string
 */
function toot_get_testimonial_url( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	return apply_filters( 'toot_get_testimonial_url', toot_get_testimonial_meta( $post_id, 'url' ), $post_id );
}

/**
 * Displays the testimonial link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_link( $args = array() ) {

	echo toot_get_testimonial_link( $args );
}

/**
 * Returns the testimonial link.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_link( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<a %s>%s</a>',
	);

	$args = wp_parse_args( $args, $defaults );

	$url = toot_get_testimonial_meta( $args['post_id'], 'url' );

	if ( $url ) {

		$text = sprintf( $args['text'], $url );
		$attr = sprintf( 'class="testimonial__anchor" href="%s"', esc_url( $url ) );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'toot_get_testimonial_link', $html, $args['post_id'] );
}

/**
 * Prints the testimonial email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_email( $args = array() ) {

	echo toot_get_testimonial_email( $args );
}

/**
 * Returns the testimonial email.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_email( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<span %s>%s</span>',
	);

	$args = wp_parse_args( $args, $defaults );

	$email = toot_get_testimonial_meta( $args['post_id'], 'email' );

	if ( $email ) {

		$text = sprintf( $args['text'], $email );
		$attr = 'class="testimonial__email"';

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], $attr, $text );
		$html .= $args['after'];
	}

	return apply_filters( 'toot_get_testimonial_email', $html, $args['post_id'] );
}

/**
 * Prints the testimonial cite.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_cite( $args = array() ) {

	echo toot_get_testimonial_cite( $args );
}

/**
 * Returns the testimonial cite.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_cite( $args = array() ) {

	$html = '';

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => '',
		'wrap'    => '<cite %s>%s</cite>',
	);

	$args = wp_parse_args( $args, $defaults );

	$author = get_the_title( $args['post_id'] );

	if ( $author ) {

		$text = toot_get_testimonial_link( array( 'text' => esc_html( $author ) ) );

		if ( ! $text )
			$text = esc_html( $author );

		$text = sprintf( $args['text'], $text );

		$html .= $args['before'];
		$html .= sprintf( $args['wrap'], 'class="testimonial__author"', $text );
		$html .= $args['after'];
	}

	return apply_filters( 'toot_get_testimonial_cite', $html, $args['post_id'] );
}

/**
 * Prints the testimonial content.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function toot_testimonial_content( $post_id = '' ) {

	echo toot_get_testimonial_content( $post_id );
}

/**
 * Gets the testimonial content.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return string
 */
function toot_get_testimonial_content( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	return apply_filters( 'toot_get_testimonial_content', get_post_field( 'post_content', $post_id ), $post_id );
}

/**
 * Returns the testimonial image.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return void
 */
function toot_testimonial_image( $args = array() ) {

	echo toot_get_testimonial_image( $args );
}

/**
 * Prints the testimonial image.
 *
 * @since  1.0.0
 * @access public
 * @param  array  $args
 * @return string
 */
function toot_get_testimonial_image( $args = array() ) {

	$defaults = array(
		'post_id' => toot_get_testimonial_id(),
		'text'    => '%s',
		'before'  => '',
		'after'   => ''
	);

	$args = wp_parse_args( $args, $defaults );

	$image = '';

	$post_id = toot_get_testimonial_id( $args['post_id'] );

	$email = toot_get_testimonial_meta( $post_id, 'email' );

	$size = apply_filters( 'toot_testimonial_image_size', 150, $post_id );

	if ( $email ) {

		$image = get_avatar(
			$email,
			apply_filters( 'toot_testimonial_avatar_size', $size, $post_id ),
			'',
			'',
			array( 'class' => 'testimonial__image' )
		);
	}

	if ( ! $image ) {

		$image = get_the_post_thumbnail(
			$post_id,
			apply_filters( 'toot_testimonial_thumbnail_size', array( $size, $size ), $post_id ),
			array( 'class' => 'testimonial__image' )
		);
	}

	return apply_filters( 'toot_get_testimonial_image', $image, $post_id );
}

/**
 * Returns the template used to mark up a testimonial.  Theme authors should filter this
 * to roll their own markup.
 *
 * %1$s - Replaced with class.
 * %2$s - Replaced with testimonial content.
 * %3$s - Replaced with testimonial image.
 * %4$s - Replaced with testimonial author cite.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function toot_get_testimonial_template() {

	$template = '
		<blockquote class="testimonial %1$s">
			%2$s
			<footer class="testimonial__meta">
				%3$s
				%4$s
			</footer>
		</blockquote>';

	return apply_filters( 'toot_testimonial_template', $template );
}

/**
 * Prints the full testimonial output.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return void
 */
function toot_testimonial_output( $post_id = '' ) {

	echo toot_get_testimonial_output( $post_id );
}

/**
 * Returns the full testimonial output.
 *
 * @since  1.0.0
 * @access public
 * @param  int     $post_id
 * @return string
 */
function toot_get_testimonial_output( $post_id = '' ) {

	$post_id = toot_get_testimonial_id( $post_id );

	$content = toot_get_testimonial_content( $post_id );
	$image   = toot_get_testimonial_image(   array( 'post_id' => $post_id ) );
	$author  = toot_get_testimonial_cite(    array( 'post_id' => $post_id ) );

	$html = sprintf( toot_get_testimonial_template(), '', $content, $image, $author );

	return apply_filters( 'toot_get_testimonial_output', $html, $post_id );
}
