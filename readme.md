# Toot

Toot is a testimonials plugin for people to share testimonials of their products, services, and/or brand on their WordPress-powered site.

## Plugin Features

* **Testimonials:** Create individual testimonials.
* **Categories:** Categorize testimonials.
* **Custom Permalinks:** Customize your testimonial permalinks to your own liking.
* **Sticky Testimonials:** Stick testimonials to the archive page.
* **Shortcodes:** Built-in shortcodes for displaying testimonials.

## Professional Support

If you need professional plugin support from me, the plugin author, you can access the support forums at [Theme Hybrid](http://themehybrid.com/board/topics), which is a professional WordPress help/support site where I handle support for all my plugins and themes for a community of 70,000+ users (and growing).

## Documentation

The plugin should be fairly straightforward to use.  Testimonials work like any ol' post/page in the WordPress admin.

### Editing

You can edit testimonials via the "Testimonials" section in the WordPress admin.  Here are a few differences between editing a normal post and a testimonial:

* **Author:** The author of the testimonial is where you'd normally see the "title".
* **URL:** This is for linking to another Web page where the testimonial was originally written.
* **Email:** This is used if you have the author's email address and want to display their Avatar/Gravatar.  _Note that this overwrites the author image._
* **Author Image:** Used to set an image for the testimonial author. Only used if email is not set.

### Shortcodes

The plugin comes packaged with two shortcodes out of the box.

#### [toot_testimonial]

This shortcode is designed for outputting a single testimonial.  On the edit testimonial screen, you should see a readonly box for copying the testimonial shortcode for that specific testimonial.

```
[toot_testimonial id="1000"]
```

Here are the parameters for the shortcode:

* `id` - A specific testimonial post ID to display.  Overrules other options.
* `category` - The slug of a testimonial category to display from.
* `order` - Order in which to query the testimonial.  Valid values are `ASC` and `DESC` (default).
* `orderby` - What post field to order by.  The default is `date`.
* `class` - A custom CSS class to add to the wrapping element.

#### [toot_testimonials]

This shortcode is designed for displaying multiple testimonials.

```
[toot_testimonials limit="4" category="example"]
```

Here are the parameters for the shortcode:

* `limit` - Number of testimonials to display.  Defaults to `10`.
* `category` - The slug of a testimonial category to display from.
* `order` - Order in which to query the testimonial.  Valid values are `ASC` and `DESC` (default).
* `orderby` - What post field to order by.  The default is `date`.
* `class` - A custom CSS class to add to the wrapping element.

### Permission

By default, only administrators can edit and manage testimonials.  If you want to grant other users permission to use testimonials, you need to install a role management plugin, such as [Members](https://themehybrid.com/plugins/members).  Toot fully integrates with Members and will allow you to fully control who has what permissions.

### Theme Support

If you'd like to add theme support for the plugin, you should add this to your theme setup function hooked to `after_setup_theme`:

```
add_theme_support( 'toot' );
```

This tells the Toot plugin that you'll be handling the code output on the front end of the site via your theme templates.

### Template hierarchy

The following is the template hierarchy for the plugin:

**Category archive:**

* `archive-testimonial-category.php`
* `archive-testimonial.php`
* `toot.php`

**Testimonial archive:**

* `archive-testimonial.php`
* `toot.php`

**Single testimonial:**

* `single-testimonial.php`
* `toot.php`

### Template functions

There are too many template functions to list in this document, but you can find all template functions by opening the `inc/template-*.php` files in your code editor to view what functions are available for use in your theme templates.

### Overriding the default output

`toot_testimonial_template` is the filter hook available for overriding the default testimonial output.  Here's what the default markup looks like:

```
$template = '<blockquote class="testimonial %1$s">
	%2$s
	<footer class="testimonial__meta">
		%3$s
		%4$s
	</footer>
</blockquote>';
```

* `%1$s` is replaced with a class.
* `%2$s` is replaced with the testimonial content.
* `%3$s` is replaced with the author image.
* `%4$s` is replaced with the author name/link.

Of course, you can go completely wild with that and do whatever you want.

### Styling testimonials

Toot uses the BEM (block-element-modifier) naming convention for CSS.  Each testimonial in this system is a "block" and sub-elements are "elements".

Here's some blank CSS to start from:

```
.testimonial {}

.testimonial p {}

.testimonial__meta {}

.testimonial__image {}

.testimonial__author {}

.testimonial__anchor {}
```

Or, if you prefer SCSS:

```
.testimonial {

	p {}

	&__meta {}

	&__image {}

	&__author {}

	&__anchor {}
}
```

## Copyright and License

This project is licensed under the [GNU GPL](http://www.gnu.org/licenses/old-licenses/gpl-2.0.html), version 2 or later.

2017 &copy; [Justin Tadlock](http://justintadlock.com).
