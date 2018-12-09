=== Private Content ===
Contributors: aldolat, specialk, thewanderingbrit
Donate link: https://dev.aldolat.it/projects/private-content/
Tags: content, private
Requires at least: 3.0
Tested up to: 5.0
Stable tag: 5.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display a portion of a post content only to users of a specific role or to a single or multiple users.

== Description ==

This plugin provides a shortcode to display a portion of a post content only to users of a specific role. For example, you can show the hidden text to Editors or to Authors or to any other WordPress role.

Please, note that an Administrator can read an Editor private content or a Subscriber private content, and so on. Same thing for Editor, Author, Contributor, and Subscriber: a higher role can read a lower role content.

Also you can show the hidden text **only** to a certain role. For example, you can mark a text as visible only to Contributors and hide it to higher roles, such as Administrators or Editors and so on.

As of version 3.0 you can mark a text as visible only to a certain user, using his login name.

As of version 4.0 you can mark a text as visible to multiple users, using their login names comma separated.

As of version 4.3 you can use either the usual `private` shortcode or the extra `ubn_private`, in case the first is already in use.

As of version 5.0 you can use the new option `reverse` to change the logic of the `recipient` option. If `reverse` is activated, it will not allow users in recipient read the private note.

= Usage =

Display this text to Administrators:

`[private role="administrator"]Text for Administrators[/private]`

Display this text to Administrators and Editors:

`[private role="editor"]Text for Editors[/private]`

Display this text to Administrators, Editors, and Authors:

`[private role="author"]Text for Authors[/private]`

Display this text to Administrators, Editors, Authors, and Contributors:

`[private role="contributor"]Text for Contributor[/private]`

Display this text to Administrators, Editors, Authors, Contributors, and Subscribers:

`[private role="subscriber"]Text for Subscribers[/private]`

= Text only for specific roles =

If you want to show a note only to a certain role, you have to use a `<role>-only` option.
In this way, for example, an Administrator or an Editor (roles higher than Author) cannot read a note for Authors only.

These are all the cases:

Display this text to Editors only:

`[private role="editor-only"]Text for Editors only[/private]`

Display this text to Authors only:

`[private role="author-only"]Text for Authors only[/private]`

Display this text to Contributors only:

`[private role="contributor-only"]Text for Contributors only[/private]`

Display this text to Subscribers only:

`[private role="subscriber-only"]Text for Subscribers only[/private]`

Display this text to Visitors only:

`[private role="visitor-only"]Text for Visitors only[/private]`

= Text only for a specific user or multiple users =

In the case you want to show a text only to a specific user, assign `none` to `role` and a login name to `recipient`:

`[private role="none" recipient="login-name"]Text for a specific user only[/private]`

Change `login-name` with the correct login name of the target user.

You can use a comma separated list of usernames to target certain users:

`[private role="none" recipient="login-name1, login-name2, login-name3"]Text for specific users only[/private]`

Change `login-name1`, `login-name2`, and `login-name3` with the correct login names of the target users.

= Text NOT for some users =

If you want to show a text to all users but not to some, activate the option `reverse`, so that users added in the `recipient` option will not read the note.
For example.

`[private role="none" recipient="alice,bob,charlie" reverse=1]We all read this message while Alice, Bob, and Charlie can't read it![/private]`

= Alternate text for non-targeted users =

If you want to show an alternate text in case the reader can't read, you can use:

`[private role="author" alt="You have not rights to read this."]Text for authors only[/private]`

Please, take note that the alternate text, if defined, is always publicly displayed.

The alternate text can contain some HTML tags. The list is:

* `b` or `strong` for bold text;
* `em` or `i` for italic text;
* `a` for links, with `href` and `title` included. For `href` and `title` do not use double quote, but single quote.

= Container for the text =

Starting from version 2.4, the user can choose the container element for the text:

* `p` is the default value;
* `div` is another option. This element allows you use HTML elements like lists, headings, and more.
* `span` is the final option. This element allows you to add private content inline.

Usage:

Wrap the note inside a DIV:

`[private container="div"]This is the text[/private]`

Wrap the note inside a SPAN:

`I met with a friend[private container="span"] (Jenny, from ninth grade)[/private] for lunch.`

= Standard WordPress user roles =

WordPress roles in descending order:

* Administrator
* Editor
* Author
* Contributor
* Subscriber

= Capabilities created by Private Content plugin =

These are the capabilities created by this plugin:

* `read_ubn_editor_notes`
* `read_ubn_author_notes`
* `read_ubn_contributor_notes`
* `read_ubn_subscriber_notes`

= Privacy Policy =

This plugin does not collect any user data.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload  the `private-content` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the Plugins menu in WordPress
1. Now the shortcode is available and ready to use.

== Frequently Asked Questions ==

= Is there a way to display an alternate text to readers that haven't the rights to read the hidden text? =

This plugin is not intended to be used in such way, but only in order to display a portion of a post to certain readers. Also, the hidden text must remain hidden, without the presence of an alternate text that could reveal the presence of the hidden text. Anyway, as of version 2.2, the plugin can display an alternate text, if it's necessary: you can use the `alt` option to do that.

Also, this plugin was created only to show a small piece of text (i.e. a couple of lines) as a note to the post for particular readers.

If you need to show the entire post only to certain readers (i.e. readers who pay to read a post), you can use a plugin like [Members](https://wordpress.org/plugins/members/).

= The hidden text is similar to the public text. Is it possible to stylize it in a different look? =

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a `<p>` HTML tag with at most three classes in this order:

* `private` to stylize all private contents
* `[role]-content` to stylize the content for that specific [role].
* `[role]-content-only` to stylize the content for that specific [role] only.

= Does this plugin work with custom roles? =

Yes, with a little extra work. In short, you have to map one of the capabilities created by Private Content to your custom role, using a plugin like [User Role Editor](https://wordpress.org/plugins/user-role-editor/) or [Members](https://wordpress.org/plugins/members/) or [Capability Manager Enhanced](https://wordpress.org/plugins/capability-manager-enhanced).

In detail, the plugin works **only** with the standard WordPress roles:

* Administrator
* Editor
* Author
* Contributor
* Subscriber

So you cannot use your custom role directly in the shortcode. But you can assign one of the capabilities, created by this plugin, to your custom role. The capabilities created by this plugin are the following:

* `read_ubn_editor_notes`
* `read_ubn_author_notes`
* `read_ubn_contributor_notes`
* `read_ubn_subscriber_notes`

In order to do this, use one of the plugins mentioned before.

For example, if you have the Wholesale Customer role, you can make that Wholesale Customer can read the notes dedicated to other standard WordPress roles, such as Contributor for example. In other words, Wholesale Customer can read notes that have been written for Contributor. They will share the same notes.

After having made that, use a shortcode like this:

`[private role="contributor-only"]Text for Contributors only[/private]`

Once a "Wholesale Customer" has been logged in, he will read the notes dedicated to `contributors-only`. Please note that we are using `role="contributor-only"`, not simply `role="contributor"`.

== Screenshots ==

1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.
2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).

== Upgrade Notice ==

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
