# Private Content

![banner](https://ps.w.org/private-content/assets/banner-772x250.png)

**Contributors:** aldolat, specialk, thewanderingbrit  
**Donate link:** <https://dev.aldolat.it/projects/private-content/>  
**Tags:** content, private, shortcode  
**Requires at least:** 3.0  
**Tested up to:** 5.8  
**Stable tag:** 6.4.1  
**License:** GPLv3 or later  
**License URI:** <https://www.gnu.org/licenses/gpl-3.0.html>  

Display a portion of a post content only to users of a specific or multiple roles, or to a single or multiple users.

* [Private Content](#private-content)
  * [Description](#description)
    * [Credits](#credits)
    * [Privacy Policy](#privacy-policy)
  * [Installation](#installation)
  * [Frequently Asked Questions](#frequently-asked-questions)
    * [Is there a way to display an alternate text to readers that haven't the rights to read the hidden text?](#is-there-a-way-to-display-an-alternate-text-to-readers-that-havent-the-rights-to-read-the-hidden-text)
    * [The hidden text is similar to the public text. Is it possible to stylize it in a different look?](#the-hidden-text-is-similar-to-the-public-text-is-it-possible-to-stylize-it-in-a-different-look)
    * [Does this plugin work with custom roles?](#does-this-plugin-work-with-custom-roles)
  * [Screenshots](#screenshots)
    * [1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles](#1-at-the-center-of-the-screen-the-shortcode-is-used-in-the-wordpress-editor-the-text-inside-the-shortcode-will-be-displayed-only-to-authors-and-above-roles)
    * [2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers)](#2-the-shortcode-in-action-on-the-left-the-text-revealed-to-administrators-only-on-the-right-the-page-as-seen-by-lower-roles-editors-authors-etc-or-simply-readers)
  * [Changelog](#changelog)
    * [6.4.1](#641)
  * [Upgrade Notice](#upgrade-notice)
    * [6.2](#62)
    * [6.1](#61)
    * [2.0](#20)
    * [2.5](#25)

## Description

Private Content provides a shortcode to display a small portion of a post content only to users of a specific role. For example, you can show the hidden text to Editors or to Authors or to any other WordPress role, even a custom role.

Private Content is not intended to be used as a membership plugin management, but instead it should be used to show small parts of a post only to certain users or roles.

For a comprehensive explanation, please see [the official Wiki on GitHub](https://github.com/aldolat/private-content/wiki). The text of the Wiki is also available as a PDF, that you can download [from here](https://github.com/aldolat/private-content.latex/blob/master/private-content.pdf).

### Credits

Many thanks to:

* [Jean Baptiste Jung](http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts) for the idea behind this plugin;
* [Jeff Starr](http://digwp.com/2010/05/private-content-posts-shortcode) for the initial code.

I would like to say *Thank You* to all the people who helped me in making this plugin better and translated it into their respective languages.

### Privacy Policy

This plugin does not collect any user data.

## Installation

This section describes how to install the plugin and get it working.

1. Upload the `private-content` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the Plugins menu in WordPress
3. Now the shortcode is available and ready to use.

## Frequently Asked Questions

### Is there a way to display an alternate text to readers that haven't the rights to read the hidden text?

This plugin is not intended to be used in such way, but only in order to display a portion of a post to certain readers. Also, the hidden text must remain hidden, without the presence of an alternate text that could reveal the presence of the hidden text. Anyway, as of version 2.2, the plugin can display an alternate text, if it's necessary: you can use the `alt` option to do that. You can find more information in the [Wiki page](https://github.com/aldolat/private-content/wiki#alt-alternate-text-for-excluded-users).

Also, this plugin was created only to show a small piece of text (i.e. a couple of lines) as a note to the post for particular readers.

If you need to show the entire post only to certain readers (i.e. readers who pay to read a post), you can use a plugin like [Members](https://wordpress.org/plugins/members/).

### The hidden text is similar to the public text. Is it possible to stylize it in a different look?

Yes, you have to edit the CSS file of your current theme.
The shortcode generates a `<p>` HTML tag with some classes, for example:

* `private` to stylize all private contents
* `[role]-content` to stylize the content for that specific [role].
* `[role]-only` to stylize the content for that specific [role] only.

See the [official Wiki](https://github.com/aldolat/private-content/wiki#giving-a-style-to-the-text-generated-by-private-content) for more information.

### Does this plugin work with custom roles?

Yes, custom roles are fully supported starting from version 6.0. You can find more informationin in the [Wiki page](https://github.com/aldolat/private-content/wiki#custom_role-display-a-text-portion-to-a-custom-role-or-multiple-roles).

## Screenshots

### 1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles

![1. At the center of the screen, the shortcode is used in the WordPress editor. The text inside the shortcode will be displayed only to Authors and above roles.](http://ps.w.org/private-content/assets/screenshot-1.png)

### 2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers)

![2. The shortcode in action. On the left, the text revealed to Administrators only; on the right, the page as seen by lower roles (Editors, Authors, etc., or simply readers).](http://ps.w.org/private-content/assets/screenshot-2.png)

## Changelog

### 6.4.1

* Updated links to documentation.

The full changelog is documented in the changelog file released along with the plugin package and is hosted also on [GitHub](https://github.com/aldolat/private-content/blob/master/CHANGELOG.md).

## Upgrade Notice

### 6.2

Now Administrators can always read text for Visitors.

### 6.1

Now Administrators can always read text for custom roles, unless a `role="custom-only"` option has been used.

### 2.0

Upgrade in order to use the new role-only feature.

### 2.5

Removed shortcode execution in feed.
