<?php
/**
 * Various functions used by the plugin.
 *
 * @package    Toot
 * @subpackage Includes
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2017, Justin Tadlock
 * @link       http://themehybrid.com/plugins/toot
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Wrapper function for `wp_verify_nonce()` with a posted value.
 *
 * @since  1.0.0
 * @access public
 * @param  string  $action
 * @param  string  $arg
 * @return bool
 */
function toot_verify_nonce_post( $action = '', $arg = '_wpnonce' ) {

	return isset( $_POST[ $arg ] ) ? wp_verify_nonce( wp_unslash( $_POST[ $arg ] ), $action ) : false;
}
