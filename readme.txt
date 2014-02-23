=== Private Content ===
Contributors: aldolat, specialk
Donate link: http://dev.aldolat.it/projects/private-content/
Tags: content, private
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 2.4
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display a portion of a post content only to users of a specific role.

== Description ==

This plugin provides a shortcode to display a portion of a post content only to users of a specific role. For example, you can show the hidden text to Editors or to Authors or to any other WordPress role.

Please, note that an Administrator can read an Editor private content or a Subscriber private content, and so on. Same thing for Editor, Author, Contributor, and Subscriber: a higher role can read a lower role content.

Also you can show the hidden text **only** to a certain role. For example, you can mark a text as visible only to Contributors and hide it to higher roles, such as Administrators or Editors and so on.

= Usage =

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

= Text only for specific roles =

If you want to show a note only to a certain role, you have to use a `<role>-only` option.
In this way, for example, an Administrator or an Editor (roles higher than Author) cannot read a note only for Authors.

These are all the cases:

`[private role="editor-only"]Text for Editors only[/private]`

`[private role="author-only"]Text for Authors only[/private]`

`[private role="contributor-only"]Text for Contributors only[/private]`

`[private role="subscriber-only"]Text for Subscribers only[/private]`

`[private role="visitor-only"]Text for Visitors only[/private]`

= Alternate text for non-targeted users =

If you want to show an alternate text in case the reader can't read, you can use:
`[private role="author" alt="You have not rights to read this."]Text for authors only[/private]`

= Standard WordPress user roles =

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

= Is there a way to display an alternate text to readers that haven't the rights to read the hidden text? =

This plugin is not intended to be used in such way, but only in order to display a portion of a post to certain readers. Also, the hidden text must remain hidden, without the presence of an alternate text that could reveal the presence of the hidden text. Anyway, as of version 2.2, the plugin can display an alternate text, if it's necessary: you can use the `alt` option to do that.

Also, this plugin was created only to show a small piece of text (i.e. a couple of lines) as a note to the post for particular readers.

If you need to show the entire post only to certain readers (i.e. readers who pay to read a post), you can use a plugin like [Members](http://wordpress.org/extend/plugins/members/).

= The hidden text is similar to the public text. Is it possible to stylize it in a different look? =

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a `<p>` HTML tag with at most three classes in this order:

* `private` to stylize all private contents

* `[role]-content` to stylize the content for that specific [role].

* `[role]-content-only` to stylize the content for that specific [role] only.

== Screenshots ==

1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.
2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).

== Changelog ==

= 2.4 =

* NEW: now it's possible to use a `div` container instead of `p`, thanks to a pull request of Matt.

= 2.3 =

* FIX: Added styling option for the alternate text.
* Added style to role-only alternate text.

= 2.2 =

* NEW: now the plugin can show an alternate text if the reader hasn't the capability to read the text.

= 2.1 =

* NEW: added the possibility to show a note only to Visitors (thanks to Jacki for the tip).

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