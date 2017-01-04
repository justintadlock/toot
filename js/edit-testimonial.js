jQuery( document ).ready( function() {

	/* === Edit sticky status in the "Publish" meta box. === */

	var sticky_checkbox = jQuery( 'input[name=jtest_project_sticky]' );
	var is_sticky       = jQuery( sticky_checkbox ).prop( 'checked' );

	// When user clicks the "Edit" sticky link.
	jQuery( 'a.jtest-edit-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Grab the original status again in case user clicks "OK" or "Cancel" more than once.
			is_sticky = jQuery( sticky_checkbox ).prop( 'checked' );

			// Hide this link.
			jQuery( this ).hide();

			// Open the sticky edit.
			jQuery( '#jtest-sticky-edit' ).slideToggle( 'fast' );
		}
	);

	/* When the user clicks the "OK" post status button. */
	jQuery( 'a.jtest-save-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#jtest-sticky-edit' ).slideToggle( 'fast' );

			// Show the hidden "Edit" link.
			jQuery( 'a.jtest-edit-sticky' ).show();
		}
	);

	// When the user clicks the "Cancel" edit sticky link.
	jQuery( 'a.jtest-cancel-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#jtest-sticky-edit' ).slideToggle( 'fast' );

			// Show the hidden "Edit" link.
			jQuery( 'a.jtest-edit-sticky' ).show();

			// Set the original checked/not-checked since we're canceling.
			jQuery( sticky_checkbox ).prop( 'checked', is_sticky ).trigger( 'change' );
		}
	);

	// When the sticky status changes.
	jQuery( sticky_checkbox ).change(
		function() {
			jQuery( 'strong.jtest-sticky-status' ).text(
				jQuery( sticky_checkbox ).prop( 'checked' ) ? jtest_i18n.label_sticky : jtest_i18n.label_not_sticky
			);
		}
	);

} ); // ready()
