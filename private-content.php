<?php
/*
 * Plugin Name: Private content
 * Description:  Display private post content only to users of a specific role
 * Plugin URI: http://www.aldolat.it/wordpress/wordpress-plugins/private-content/
 * Author: Aldo Latino
 * Author URI: http://www.aldolat.it/
 * Version: 1.1
 * License: GPLv3 or later
 * Text Domain: private
 * Domain Path: /languages/
 *
 * Copyright (C) 2009, 2012  Aldo Latino  (email : aldolat@gmail.com)
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
 * @version 1.1
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
 * ubn_private_content( $atts, $content = null )
 *
 * Shortcode to display private post content only to users of a specific role.
 *
 * @example
 * [private role="administrator"]Text for administrators[/private]
 * [private role="editor"]Text for editors[/private]
 * [private role="author"]Text for authors[/private]
 * [private role="contributor"]Text for contributor[/private]
 * [private role="subscriber"]Text for subscribers[/private]
 *
 * Please, note that an administrator can read an editor private content or a subscriber private content, and so on.
 * Same thing for editor, author, contributor, and subscriber: a higher role can read a lower role content.
 *
 * WordPress Roles in descending order:
 * Administrator,
 * Editor,
 * Author,
 * Contributor,
 * Subscriber.
 */

function ubn_private_content( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'role'  => 'administrator', // The default role if none has been provided
		'align' => ''
	), $atts ) );

	if( $align != '' ) {
		switch( $align ) {
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
		}
	}

	switch( $role ) {

		case 'administrator' :
			if( current_user_can( 'create_users' ) )
				$text = '<p class="private administrator-content"' . $align_style . '>' . $content . '</p>';
		break;

		case 'editor' :
			if( current_user_can( 'edit_others_posts' ) )
				$text = '<p class="private editor-content"' . $align_style . '>' . $content . '</p>';
		break;

		case 'author' :
			if( current_user_can( 'publish_posts' ) )
				$text = '<p class="private author-content"' . $align_style . '>' . $content . '</p>';
		break;

		case 'contributor' :
			if( current_user_can( 'edit_posts' ) )
				$text = '<p class="private contributor-content"' . $align_style . '>' . $content . '</p>';
		break;

		case 'subscriber' :
			if( current_user_can( 'read' ) )
				$text = '<p class="private subscriber-content"' . $align_style . '>' . $content . '</p>';
		break;

	}

	if( isset( $text ) )
		// The "do_shortcode" function is necessary to let WordPress execute another nested shortcode.
		return do_shortcode( $text );

}
add_shortcode( 'private', 'ubn_private_content' );

/***********************************************************************
 *                            CODE IS POETRY
 **********************************************************************/