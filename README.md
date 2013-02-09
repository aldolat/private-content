# Private Content #
**Contributors:** aldolat, specialk  
**Donate link:** http://www.aldolat.it/wordpress/wordpress-plugins/private-content/  
**Tags:** content, private  
**Requires at least:** 3.0  
**Tested up to:** 3.5.1  
**Stable tag:** 2.0  
**License:** GPLv3 or later  
**License URI:** http://www.gnu.org/licenses/gpl-3.0.html  

Display private post content only to users of a specific role

## Description ##

This plugin provides a shortcode to display a portion of a post's content only to users of a specific role.

Usage:

Display this text only to Administrators:<br />
`[private role="administrator"]Text for administrators[/private]`

Display this text only to Administrators and Editors:<br />
`[private role="editor"]Text for editors[/private]`

Display this text only to Administrators, Editors, and Authors:<br />
`[private role="author"]Text for authors[/private]`

Display this text only to Administrators, Editors, Authors, and Contributors:<br />
`[private role="contributor"]Text for contributor[/private]`

Display this text only to Administrators, Editors, Authors, Contributors, and Subscribers:<br />
`[private role="subscriber"]Text for subscribers[/private]`

Please, note that an administrator can read an editor private content or a subscriber private content, and so on. Same thing for editor, author, contributor, and subscriber: a higher role can read a lower role content.

If you want to show a note only to a certain role, you have to use a `<role>-only` option.
For example:
`[private role="author-only"]Text for authors only[/private]`
In this way, Administrators and Editors (roles higher than Editors) can't read a note only for Authors.

WordPress roles in descending order:

 * Administrator

 * Editor

 * Author

 * Contributor

 * Subscriber

## Installation ##

This section describes how to install the plugin and get it working.

1. Upload  the `private-content` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the Plugins menu in WordPress
1. Now the shortcode is available and ready to use.

## Frequently Asked Questions ##

### The hidden text is similar to the public text. Is it possible to stylize it in a different look? ###

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a &lt;p&gt; HTML tag with two classes:

* "private" to stylize all private contents

* "[role]-content" to stylize the content for that specific [role].

A third class is added, in case you make a note only for a specific role, for example "contributor-only".

## Screenshots ##

### 1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles. ###
![1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.](http://s-plugins.wordpress.org/private-content/assets/screenshot-1.png)

### 2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers). ###
![2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).](http://s-plugins.wordpress.org/private-content/assets/screenshot-2.png)


## Changelog ##

### 2.0 ###

* NEW: now you can show a note only to user of a specific role, hiding that note to higher roles.
* Added uninstall.php to delete the new custom capabilities.

### 1.2 ###

* Now the inline style appears only if necessary.

### 1.1 ###

* Upon request, added the possibility to align the text left, right, centered and justified.

### 1.0 ###

* First release of the plugin.

## Upgrade Notice ##

### 2.0 ###

Upgrade in order to use the new role-only feature.

### 1.0 ###

No upgrade notice.

## Credits ##

Many thanks to:

* [Jean Baptiste Jung](http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts) for the idea behind this plugin;

* [Jeff Starr](http://digwp.com/2010/05/private-content-posts-shortcode) for the initial code.