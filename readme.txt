=== Private Content ===
Contributors: aldolat, specialk, thewanderingbrit
Donate link: https://dev.aldolat.it/projects/private-content/
Tags: content, private, shortcode
Requires at least: 3.0
Tested up to: 5.3
Stable tag: 6.2
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Display a portion of a post content only to users of a specific or multiple roles, or to a single or multiple users.

== Description ==

This plugin provides a shortcode to display a portion of a post content only to users of a specific role. For example, you can show the hidden text to Editors or to Authors or to any other WordPress role.

Please, note that an Administrator can read an Editor private content or a Subscriber private content, and so on. Same thing for Editor, Author, Contributor, and Subscriber: a higher role can read a lower role content.

Also you can show the hidden text **only** to a certain role. For example, you can mark a text as visible only to Contributors and hide it to higher roles, such as Administrators or Editors and so on.

As of version 3.0 you can mark a text as visible only to a certain user, using his login name.

As of version 4.0 you can mark a text as visible to multiple users, using their login names comma separated.

As of version 4.3 you can use either the usual `private` shortcode or the extra `ubn_private`, in case the first is already in use.

As of version 5.0 you can use the new option `reverse` to change the logic of the `recipient` option. If `reverse` is activated, it will not allow users in `recipient` read the private note.

As of version 6.0 you can use custom roles.

As of version 6.1 you can use multiple custom roles. Also Administrators can always read text for custom roles, unless a `role="custom-only"` option has been used.

As of version 6.2 you can use custom IDs and/or classes for the HTML container.

For more information, please see the [official Wiki on GitHub](https://github.com/aldolat/private-content/wiki).

= Privacy Policy =

This plugin does not collect any user data.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `private-content` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the Plugins menu in WordPress
1. Now the shortcode is available and ready to use.

== Frequently Asked Questions ==

= Is there a way to display an alternate text to readers that haven't the rights to read the hidden text? =

This plugin is not intended to be used in such way, but only in order to display a portion of a post to certain readers. Also, the hidden text must remain hidden, without the presence of an alternate text that could reveal the presence of the hidden text. Anyway, as of version 2.2, the plugin can display an alternate text, if it's necessary: you can use the `alt` option to do that. You can find more information in the [Wiki page](https://github.com/aldolat/private-content/wiki#alt-alternate-text-for-excluded-users).

Also, this plugin was created only to show a small piece of text (i.e. a couple of lines) as a note to the post for particular readers.

If you need to show the entire post only to certain readers (i.e. readers who pay to read a post), you can use a plugin like [Members](https://wordpress.org/plugins/members/).

= The hidden text is similar to the public text. Is it possible to stylize it in a different look? =

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a `<p>` HTML tag with some classes, for example:

* `private` to stylize all private contents
* `[role]-content` to stylize the content for that specific [role].
* `[role]-only` to stylize the content for that specific [role] only.

See the [official Wiki](https://github.com/aldolat/private-content/wiki#giving-a-style-to-the-text-generated-by-private-content) for more information.

= Does this plugin work with custom roles? =

Yes, custom roles are fully supported starting from version 6.0. You can find more informationin the [Wiki page](https://github.com/aldolat/private-content/wiki#custom_role-display-a-text-portion-to-a-custom-role-or-multiple-roles).

== Screenshots ==

1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.
2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).

== Upgrade Notice ==

= 6.1 =

Now Administrators can always read text for custom roles, unless a `role="custom-only"` option has been used.

= 2.0 =

Upgrade in order to use the new role-only feature.

= 2.5 =

Removed shortcode execution in feed.

= 1.0 =

No upgrade notice.

== Credits ==

Many thanks to:

* [Jean Baptiste Jung](http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts) for the idea behind this plugin;
* [Jeff Starr](http://digwp.com/2010/05/private-content-posts-shortcode) for the initial code.
