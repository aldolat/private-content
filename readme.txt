=== Private Content ===
Contributors: aldolat, specialk
Donate link: http://www.aldolat.it/wordpress/wordpress-plugins/private-content/
Tags: content, private
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 2.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display private post content only to users of a specific role

== Description ==

This plugin provides a shortcode to display a portion of a post's content only to users of a specific role.

Usage:

Display this text only to Administrators:<br />
`[private role="administrator"]Text for Administrators[/private]`

Display this text only to Administrators and Editors:<br />
`[private role="editor"]Text for Editors[/private]`

Display this text only to Administrators, Editors, and Authors:<br />
`[private role="author"]Text for Authors[/private]`

Display this text only to Administrators, Editors, Authors, and Contributors:<br />
`[private role="contributor"]Text for Contributor[/private]`

Display this text only to Administrators, Editors, Authors, Contributors, and Subscribers:<br />
`[private role="subscriber"]Text for Subscribers[/private]`

Please, note that an Administrator can read an Editor private content or a Subscriber private content, and so on. Same thing for Editor, Author, Contributor, and Subscriber: a higher role can read a lower role content.

If you want to show a note only to a certain role, you have to use a `<role>-only` option.
In this way, for example, an Administrator or an Editor (roles higher than Author) can't read a note only for Authors.

Here all the cases:

`[private role="editor-only"]Text for Editors only[/private]`

`[private role="author-only"]Text for Authors only[/private]`

`[private role="contributor-only"]Text for Contributors only[/private]`

`[private role="subscriber-only"]Text for Subscribers only[/private]`


WordPress roles in descending order:

 * Administrator

 * Editor

 * Author

 * Contributor

 * Subscriber

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload  the `private-content` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the Plugins menu in WordPress
1. Now the shortcode is available and ready to use.

== Frequently Asked Questions ==

= The hidden text is similar to the public text. Is it possible to stylize it in a different look? =

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a &lt;p&gt; HTML tag with two classes:

* "private" to stylize all private contents

* "[role]-content" to stylize the content for that specific [role].

A third class is added, in case you make a note only for a specific role, for example "contributor-only".

== Screenshots ==

1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.
2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).

== Changelog ==

= 2.0 =

* NEW: now you can show a note only to user of a specific role, hiding that note to higher roles.
* Added uninstall.php to delete the new custom capabilities.

= 1.2 =

* Now the inline style appears only if necessary.

= 1.1 =

* Upon request, added the possibility to align the text left, right, centered and justified.

= 1.0 =

* First release of the plugin.

== Upgrade Notice ==

= 2.0 =

Upgrade in order to use the new role-only feature.

= 1.0 =

No upgrade notice.

== Credits ==

Many thanks to:

* [Jean Baptiste Jung](http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts) for the idea behind this plugin;

* [Jeff Starr](http://digwp.com/2010/05/private-content-posts-shortcode) for the initial code.