<?php
/**
 * Plugin settings screen.
 *
 * @package    Testimonails
 * @subpackage Admin
 * @author     Justin Tadlock <justintadlock@gmail.com>
 * @copyright  Copyright (c) 2013-2016, Justin Tadlock
 * @link       http://themehybrid.com/plugins/testimonials
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Sets up and handles the plugin settings screen.
 *
 * @since  1.0.0
 * @access public
 */
final class JTEST_Settings_Page {

	/**
	 * Settings page name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu() {

		// Create the settings page.
		$this->settings_page = add_submenu_page(
			'edit.php?post_type=' . jtest_get_testimonial_post_type(),
			esc_html__( 'Portfolio Settings', 'testimonials' ),
			esc_html__( 'Settings',           'testimonials' ),
			apply_filters( 'jtest_settings_capability', 'manage_options' ),
			'jtest-settings',
			array( $this, 'settings_page' )
		);

		if ( $this->settings_page ) {

			// Register settings.
			add_action( 'admin_init', array( $this, 'register_settings' ) );

			// Add help tabs.
			add_action( "load-{$this->settings_page}", array( $this, 'add_help_tabs' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function register_settings() {

		// Register the setting.
		register_setting( 'jtest_settings', 'jtest_settings', array( $this, 'validate_settings' ) );

		/* === Settings Sections === */

		add_settings_section( 'general',    esc_html__( 'General Settings', 'testimonials' ), array( $this, 'section_general'    ), $this->settings_page );
		add_settings_section( 'permalinks', esc_html__( 'Permalinks',       'testimonials' ), array( $this, 'section_permalinks' ), $this->settings_page );

		/* === Settings Fields === */

		// General section fields
		add_settings_field( 'archive_title',       esc_html__( 'Title',       'testimonials' ), array( $this, 'field_archive_title'       ), $this->settings_page, 'general' );
		add_settings_field( 'archive_description', esc_html__( 'Description', 'testimonials' ), array( $this, 'field_archive_description' ), $this->settings_page, 'general' );

		// Permalinks section fields.
		add_settings_field( 'rewrite_base',             esc_html__( 'Rewrite Base',     'testimonials' ), array( $this, 'field_rewrite_base'             ), $this->settings_page, 'permalinks' );
		add_settings_field( 'testimonial_rewrite_base', esc_html__( 'Testimonial Slug', 'testimonials' ), array( $this, 'field_testimonial_rewrite_base' ), $this->settings_page, 'permalinks' );
		add_settings_field( 'category_rewrite_base',    esc_html__( 'Category Slug',    'testimonials' ), array( $this, 'field_category_rewrite_base'    ), $this->settings_page, 'permalinks' );
	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validate_settings( $settings ) {

		// Text boxes.
		$settings['rewrite_base']             = $settings['rewrite_base']             ? trim( strip_tags( $settings['rewrite_base'] ), '/' )             : 'testimonials';
		$settings['testimonial_rewrite_base'] = $settings['testimonial_rewrite_base'] ? trim( strip_tags( $settings['testimonial_rewrite_base'] ), '/' ) : '';
		$settings['category_rewrite_base']    = $settings['category_rewrite_base']    ? trim( strip_tags( $settings['category_rewrite_base']  ), '/' )   : '';
		$settings['archive_title']            = $settings['archive_title']            ? strip_tags( $settings['archive_title'] )                         : esc_html__( 'Testimonials', 'testimonials' );

		// Kill evil scripts.
		$settings['archive_description'] = stripslashes( wp_filter_post_kses( addslashes( $settings['archive_description'] ) ) );

		/* === Handle Permalink Conflicts ===*/

		// No testimonial or category base, testimonials win.
		if ( ! $settings['testimonial_rewrite_base'] && ! $settings['category_rewrite_base'] )
			$settings['category_rewrite_base'] = 'categories';

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * General section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_general() { ?>

		<p class="description">
			<?php esc_html_e( 'General testimonial settings for your site.', 'testimonials' ); ?>
		</p>
	<?php }

	/**
	 * Portfolio title field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_archive_title() { ?>

		<label>
			<input type="text" class="regular-text" name="jtest_settings[archive_title]" value="<?php echo esc_attr( jtest_get_archive_title() ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'The name of your testimonials. May be used for the testimonials archive title and other places, depending on your theme.', 'testimonials' ); ?></span>
		</label>
	<?php }

	/**
	 * Portfolio description field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_archive_description() {

		wp_editor(
			jtest_get_archive_description(),
			'jtest_archive_description',
			array(
				'textarea_name'    => 'jtest_settings[archive_description]',
				'drag_drop_upload' => true,
				'editor_height'    => 150
			)
		); ?>

		<p>
			<span class="description"><?php esc_html_e( 'Your testimonials description. This may be shown by your theme on the testimonials archive page.', 'testimonials' ); ?></span>
		</p>
	<?php }

	/**
	 * Permalinks section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_permalinks() { ?>

		<p class="description">
			<?php esc_html_e( 'Set up custom permalinks for the testimonials section on your site.', 'testimonials' ); ?>
		</p>
	<?php }

	/**
	 * Portfolio rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="jtest_settings[rewrite_base]" value="<?php echo esc_attr( jtest_get_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Portfolio rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_testimonial_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( jtest_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="jtest_settings[testimonial_rewrite_base]" value="<?php echo esc_attr( jtest_get_testimonial_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Portfolio rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_category_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( jtest_get_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="jtest_settings[category_rewrite_base]" value="<?php echo esc_attr( jtest_get_category_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings_page() {

		// Flush the rewrite rules if the settings were updated.
		if ( isset( $_GET['settings-updated'] ) )
			flush_rewrite_rules(); ?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Settings', 'testimonials' ); ?></h1>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'jtest_settings' ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>
				<?php submit_button( esc_attr__( 'Update Settings', 'testimonials' ), 'primary' ); ?>
			</form>

		</div><!-- wrap -->
	<?php }

	/**
	 * Adds help tabs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_help_tabs() {

		// Get the current screen.
		$screen = get_current_screen();

		// General settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'general',
				'title'    => esc_html__( 'General Settings', 'testimonials' ),
				'callback' => array( $this, 'help_tab_general' )
			)
		);

		// Permalinks settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'permalinks',
				'title'    => esc_html__( 'Permalinks', 'testimonials' ),
				'callback' => array( $this, 'help_tab_permalinks' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( jtest_get_help_sidebar_text() );
	}

	/**
	 * Displays the general settings help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_general() { ?>

		<ul>
			<li><?php _e( '<strong>Title:</strong> Allows you to set the title for the portfolio section on your site. This is general shown on the portfolio testimonials archive, but themes and other plugins may use it in other ways.', 'testimonials' ); ?></li>
			<li><?php _e( '<strong>Description:</strong> This is the description for your portfolio. Some themes may display this on the portfolio testimonials archive.', 'testimonials' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the permalinks help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_permalinks() { ?>

		<ul>
			<li><?php _e( '<strong>Rewrite Base:</strong> The primary URL for the testimonials section on your site. It lists your testimonials.', 'testimonials' ); ?></li>
			<li>
				<?php _e( '<strong>Testimonial Slug:</strong> The slug for single testimonials. You can use something custom, leave this field empty, or use one of the following tags:', 'testimonials' ); ?>
				<ul>
					<li><?php printf( esc_html__( '%s - The testimonial category.', 'testimonials' ), '<code>%' . jtest_get_category_taxonomy() . '%</code>' ); ?></li>
				</ul>
			</li>
			<li><?php _e( '<strong>Category Slug:</strong> The base slug used for category archives.', 'testimonials' ); ?></li>
		</ul>
	<?php }

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}

JTEST_Settings_Page::get_instance();
