<?php
/*
 * Plugin Name: Private content
 * Description:  Display private post content only to users of a specific role
 * Plugin URI: http://dev.aldolat.it/projects/private-content/
 * Author: Aldo Latino
 * Author URI: http://www.aldolat.it/
 * Version: 2.2
 * License: GPLv3 or later
 * Text Domain: private
 * Domain Path: /languages/
 */

/*
 * Copyright (C) 2009, 2013  Aldo Latino  (email : aldolat@gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package PrivateContent
 * @version 2.1
 * @author Aldo Latino <aldolat@gmail.com>, Jeff Starr
 * @copyright Copyright (c) 2009-2012, Aldo Latino
 * @link http://www.aldolat.it/wordpress/wordpress-plugins/private-content/
 * @license http://www.gnu.org/licenses/gpl.html
 *
 * Thanks to:
 * Jean Baptiste Jung ( http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts )
 * for the idea and
 * Jeff Starr ( http://digwp.com/2010/05/private-content-posts-shortcode )
 * for the starting code.
*/

/**
 * Shortcode to display private post content only to users of a specific role.
 *
 * @example
 * [private role="administrator"]Text for administrators[/private]
 * [private role="editor" align="center"]Text for editors[/private]
 * [private role="author"]Text for authors[/private]
 * [private role="author-only"]Text for authors only[/private]
 * [private role="contributor" align="right"]Text for contributors[/private]
 * [private role="subscriber" align="justify"]Text for subscribers[/private]
 * [private role="subscriber-only" align="justify"]Text for subscribers only[/private]
 * [private role="visitor-only"]Text for visitors only[/private]
 *
 * Please, note that an administrator can read an editor private content or a subscriber private content, and so on.
 * Same thing for editor, author, contributor, and subscriber: a higher role can read a lower role content.
 *
 * If you want to show a note only to a certain role, you have to use a <role>-only option.
 * For example:
 * [private role="author-only"]Text for authors only[/private]
 * In this way, Administrators and Editors (roles higher than Editors) can't read this note.
 *
 * If you want to show an alternate text in case the user can't read, you can use `alt` option:
 * [private role="author" alt="You have not rights to read this."]Text for authors only[/private]
 *
 * WordPress Roles in descending order:
 * Administrator,
 * Editor,
 * Author,
 * Contributor,
 * Subscriber.
 */


/**
 * Add the new capabilities to WordPress standard roles.
 * Note that the Administrator role doesn't need any custom capabilities.
 */
function ubn_private_add_cap() {

	global $wp_roles;

	$wp_roles->add_cap( 'editor',      'read_ubn_editor_notes'      );
	$wp_roles->add_cap( 'author',      'read_ubn_author_notes'      );
	$wp_roles->add_cap( 'contributor', 'read_ubn_contributor_notes' );
	$wp_roles->add_cap( 'subscriber',  'read_ubn_subscriber_notes'  );

}
register_activation_hook( __FILE__, 'ubn_private_add_cap' );


/*
 * Check if Editor role has 'read_ubn_editor_notes' capabilities.
 * This check is useful only when upgrading this plugin from version below 2.0.
 * This function will be removed in future.
 */
function ubn_private_check_capability_exists() {

	$editor_role = get_role( 'editor' );

	if ( ! isset( $editor_role->capabilities['read_ubn_editor_notes'] ) ) {
		ubn_private_add_cap();
	}

}
add_action( 'init', 'ubn_private_check_capability_exists' );


/*
 * Create the shortcode 'private'.
 *
 * @usage [private role="role" align="align"]Text to show[/private]
 */
function ubn_private_content( $atts, $content = null ) {

	$defaults = array(
		'role'  => 'administrator', // The default role if none has been provided
		'align' => '',
		'alt'   => '',
	);

	extract( shortcode_atts( $defaults, $atts ) );

	// The 'align' option
	if ( $align != '' ) {
		switch ( $align ) {
		case 'left' :
			$align_style = ' style="text-align: left;"';
			break;

		case 'center' :
			$align_style = ' style="text-align: center;"';
			break;

		case 'right' :
			$align_style = ' style="text-align: right;"';
			break;

		case 'justify' :
			$align_style = ' style="text-align: justify;"';
			break;

		default :
			$align_style = '';
		}
	} else {
		$align_style = '';
	}

	// The 'role' option
	switch ( $role ) {

	case 'administrator' :
		if ( current_user_can( 'create_users' ) ) {
			$text = '<p class="private administrator-content"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private administrator-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'editor' :
		if ( current_user_can( 'edit_others_posts' ) ) {
			$text = '<p class="private editor-content"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private editor-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'editor-only' :
		if ( current_user_can( 'read_ubn_editor_notes' ) ) {
			$text = '<p class="private editor-content editor-only"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private editor-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'author' :
		if ( current_user_can( 'publish_posts' ) ) {
			$text = '<p class="private author-content"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private author-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'author-only' :
		if ( current_user_can( 'read_ubn_author_notes' ) ) {
			$text = '<p class="private author-content author-only"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private author-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'contributor' :
		if ( current_user_can( 'edit_posts' ) ) {
			$text = '<p class="private contributor-content"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private contributor-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'contributor-only' :
		if ( current_user_can( 'read_ubn_contributor_notes' ) ) {
			$text = '<p class="private contributor-content contributor-only"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private contributor-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'subscriber' :
		if ( current_user_can( 'read' ) ) {
			$text = '<p class="private subscriber-content"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private subscriber-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'subscriber-only' :
		if ( current_user_can( 'read_ubn_subscriber_notes' ) ) {
			$text = '<p class="private subscriber-content subscriber-only"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private subscriber-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	case 'visitor-only' :
		if ( ! is_user_logged_in() ) {
			$text = '<p class="private visitor-content visitor-only"' . $align_style . '>' . $content . '</p>';
		} else {
			if ( $alt ) {
				$text = '<p class="private visitor-content alt-text">' . $alt . '</p>';
			}
		}
		break;

	default :
		$text = '<p class="private administrator-content"' . $align_style . '>' . $content . '</p>';
	}

	if ( isset( $text ) )
		// The do_shortcode function is necessary to let WordPress execute another nested shortcode.
		return do_shortcode( $text );
}
add_shortcode( 'private', 'ubn_private_content' );


/***********************************************************************
 *                            CODE IS POETRY
 **********************************************************************/
