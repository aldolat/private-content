<?php
/*
 * Plugin Name: Private content
 * Description:  Display a portion of a post content only to users of a specific role or to a single or multiple users.
 * Plugin URI: http://dev.aldolat.it/projects/private-content/
 * Author: Aldo Latino
 * Author URI: http://www.aldolat.it/
 * Version: 4.3
 * License: GPLv3 or later
 * Text Domain: private-content
 * Domain Path: /languages/
 */

/*
 * Copyright (C) 2009, 2017  Aldo Latino  (email : aldolat@gmail.com)
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
 */

/*
 * Thanks to:
 * Jean Baptiste Jung ( http://www.wprecipes.com/add-private-notes-to-your-wordpress-blog-posts )
 * for the idea and
 * Jeff Starr ( http://digwp.com/2010/05/private-content-posts-shortcode )
 * for the starting code.
 */

/*
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
 * Please, take note that the alternate text, if defined, is always publicly displayed.
 *
 * WordPress Roles in descending order:
 * Administrator,
 * Editor,
 * Author,
 * Contributor,
 * Subscriber.
 */

 /**
  * Prevent direct access to this file.
  *
  * @since 4.2
  */
 if ( ! defined( 'WPINC' ) ) {
 	exit( 'No script kiddies please!' );
 }


 /**
  * Launch Private Content.
  *
  * @since 4.2
  */
 add_action( 'plugins_loaded', 'ubn_private_setup' );


 /**
  * Setup Private Content.
  *
  * @since 4.2
  */
 function ubn_private_setup() {
 	/*
 	 * Make plugin available for i18n.
 	 * Translations must be archived in the /languages/ directory.
 	 * The name of each translation file must be, for example:
 	 *
 	 * ITALIAN:
 	 * private-content-it_IT.po
 	 * private-content-it_IT.mo
 	 *
 	 * GERMAN:
 	 * private-content-de_DE.po
 	 * private-content-de_DE.po
 	 *
 	 * and so on.
 	 */
 	load_plugin_textdomain( 'private-content', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}


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


/**
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


/**
 * Create the shortcode 'private'.
 *
 * @example [private role="editor" align="center" alt="Please, login to view this note." container="div"]All Editors - Meeting on Slack every day at 9am![/private]
 */
function ubn_private_content( $atts, $content = null ) {
    /**
     * The default parameters.
     *
     * @param string $role The intended role to view the note.
     * It can be:
     *      "administrator",
     *      "editor",
     *      "editor-only",
     *      "author",
     *      "author-only",
     *      "contributor",
     *      "contributor-only",
     *      "subscriber",
     *      "subscriber-only",
     *      "visitor-only",
     *      "none". When using "none", you must specify a recipients list in $recipient.
     * @param string $recipient The target role to view the note.
     * It is used when $role = "none".
     *
     * @param string $align The alignment of text.
     * It can be:
     *      "left"
     *      "center"
     *      "right"
     *      "justify"
     * @param string $alt The alternate text to be displayed when the viewer is not the target user.
     * @param string $container The container for the note.
     * It can be:
     *      "p"
     *      "div"
     *      "span"
     */
	$defaults = array(
		'role'      => 'administrator', // The default role if none has been provided
		'recipient' => '',
		'align'     => '',
		'alt'       => '',
		'container' => 'p',
	);
	extract( shortcode_atts( $defaults, $atts ) );

    /*
     * Input sanitization.
     * @since 4.3
     */
    $role      = wp_strip_all_tags( $role );
    $recipient = wp_strip_all_tags( $recipient );
    $align     = wp_strip_all_tags( $align );
    // $alt is processed below.
    $container = wp_strip_all_tags( $container );

	/*
	 * Allow the usage of some HTML tags in the shortcode "alt" parameter.
	 *
	 * By itself, WordPress allows the usage of some basic HTML tags,
	 * such as <b>, <em>, <strong>, but not <a>.
	 * @see https://codex.wordpress.org/Shortcode_API#HTML
	 *
	 * @since 4.1
	 */
	// Decode any HTML entity into its applicable character, so that `wp_kses` can operate.
	// The encoding is performed by the WordPress visual editor.
	$alt = html_entity_decode( $alt );
	// Define the allowed HTML tags for `wp_kses`.
	$allowed_html = array(
		'em'     => array(),
		'i'      => array(),
		'strong' => array(),
		'b'      => array(),
		'a'      => array(
			'href'  => array(),
			'title' => array(),
		),
	);
	// Remove all HTML tags, except `em`, `i`, `strong, `b`, `a`.
	$alt = wp_kses( $alt, $allowed_html );

	// The 'align' option
	if ( ! empty( $align ) ) {
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

	// The 'container' option
	switch ( $container ) {
		case 'p' :
			$container_open  = '<p';
			$container_close = '</p>';
			break;

		case 'div' :
			$container_open  = '<div';
			$container_close = '</div>';
			break;

		case 'span' :
			$container_open  = '<span';
			$container_close = '</span>';
			break;

		default :
			$container_open  = '<p';
			$container_close = '</p>';
			break;
	}

	// The 'role' option
	switch ( $role ) {

		case 'administrator' :
			if ( current_user_can( 'create_users' ) ) {
				$text = $container_open . ' class="private administrator-content"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'editor' :
			if ( current_user_can( 'edit_others_posts' ) ) {
				$text = $container_open . ' class="private editor-content"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'editor-only' :
			if ( current_user_can( 'read_ubn_editor_notes' ) ) {
				$text = $container_open . ' class="private editor-content editor-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'author' :
			if ( current_user_can( 'publish_posts' ) ) {
				$text = $container_open . ' class="private author-content"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'author-only' :
			if ( current_user_can( 'read_ubn_author_notes' ) ) {
				$text = $container_open . ' class="private author-content author-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'contributor' :
			if ( current_user_can( 'edit_posts' ) ) {
				$text = $container_open . ' class="private contributor-content"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'contributor-only' :
			if ( current_user_can( 'read_ubn_contributor_notes' ) ) {
				$text = $container_open . ' class="private contributor-content contributor-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'subscriber' :
			if ( current_user_can( 'read' ) ) {
				$text = $container_open . ' class="private subscriber-content"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'subscriber-only' :
			if ( current_user_can( 'read_ubn_subscriber_notes' ) ) {
				$text = $container_open . ' class="private subscriber-content subscriber-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'visitor-only' :
			if ( ! is_user_logged_in() ) {
				$text = $container_open . ' class="private visitor-content visitor-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		case 'none' :
			$all_recipients = array_map( 'trim', explode( ',', $recipient ) );
			$current_user = wp_get_current_user();
			if ( in_array( $current_user->user_login, $all_recipients ) ) {
				$text = $container_open . ' class="private user-content user-only ' . esc_attr( $current_user->user_login ) . '-only"' . $align_style . '>' . $content . $container_close;
			} else {
				$text = '';
				if ( $alt ) {
					$text = $container_open . ' class="private alt-text"' . $align_style . '>' . $alt . $container_close;
				}
			}
			break;

		default :
			$text = '';
	}

	if ( isset( $text ) && ! empty( $text ) && ! is_feed() ) {
		// The do_shortcode function is necessary to let WordPress execute another nested shortcode.
		return do_shortcode( $text );
	}
}
if ( ! shortcode_exists( 'private' ) ) {
	add_shortcode( 'private', 'ubn_private_content' );
}
if ( ! shortcode_exists( 'ubn_private' ) ) {
	add_shortcode( 'ubn_private', 'ubn_private_content' );
}


/***********************************************************************
 *                            CODE IS POETRY
 **********************************************************************/
