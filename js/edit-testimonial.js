jQuery( document ).ready( function() {

	/* === Edit sticky status in the "Publish" meta box. === */

	var sticky_checkbox = jQuery( 'input[name=toot_testimonial_sticky]' );
	var is_sticky       = jQuery( sticky_checkbox ).prop( 'checked' );

	// When user clicks the "Edit" sticky link.
	jQuery( 'a.toot-edit-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Grab the original status again in case user clicks "OK" or "Cancel" more than once.
			is_sticky = jQuery( sticky_checkbox ).prop( 'checked' );

			// Hide this link.
			jQuery( this ).hide();

			// Open the sticky edit.
			jQuery( '#toot-sticky-edit' ).slideToggle( 'fast' );
		}
	);

	/* When the user clicks the "OK" post status button. */
	jQuery( 'a.toot-save-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#toot-sticky-edit' ).slideToggle( 'fast' );

			// Show the hidden "Edit" link.
			jQuery( 'a.toot-edit-sticky' ).show();
		}
	);

	// When the user clicks the "Cancel" edit sticky link.
	jQuery( 'a.toot-cancel-sticky' ).click(
		function( j ) {
			j.preventDefault();

			// Close the sticky edit.
			jQuery( '#toot-sticky-edit' ).slideToggle( 'fast' );

			// Show the hidden "Edit" link.
			jQuery( 'a.toot-edit-sticky' ).show();

			// Set the original checked/not-checked since we're canceling.
			jQuery( sticky_checkbox ).prop( 'checked', is_sticky ).trigger( 'change' );
		}
	);

	// When the sticky status changes.
	jQuery( sticky_checkbox ).change(
		function() {
			jQuery( 'strong.toot-sticky-status' ).text(
				jQuery( sticky_checkbox ).prop( 'checked' ) ? toot_i18n.label_sticky : toot_i18n.label_not_sticky
			);
		}
	);

} ); // ready()
