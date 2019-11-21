<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://dev.aldolat.it/projects/private-content/
 * @since   1.0.0
 * @package PrivateContent
 * @license GPLv3 or later
 *
 * @wordpress-plugin
 * Plugin Name: Private content
 * Description:  Display a portion of a post content only to users of a specific role or to a single or multiple users.
 * Plugin URI: https://dev.aldolat.it/projects/private-content/
 * Author: Aldo Latino
 * Author URI: https://www.aldolat.it/
 * Version: 6.0
 * License: GPLv3 or later
 * Text Domain: private-content
 * Domain Path: /languages/
 */

/*
 * Copyright (C) 2009, 2019  Aldo Latino  (email : aldolat@gmail.com)
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

/**
 * Prevent direct access to this file.
 *
 * @since 4.2
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'No script kiddies please!' );
}

/**
 * Include the class.
 *
 * @since 5.1
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ubn-private.php';

/**
 * Instantiate the object and run the plugin.
 *
 * @since 5.1
 */
function ubn_private_run() {
	$ubn_private = new UBN_Private();
	$ubn_private->run();
}

ubn_private_run();

/*
 * CODE IS POETRY
 */
