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
 * Version: 6.5.0
 * License: GPLv3 or later
 * Text Domain: private-content
 * Domain Path: /languages/
 */

/*
 * Copyright (C) 2009, 2022  Aldo Latino  (email : aldolat@gmail.com)
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
 * Launch Private Content.
 *
 * @since 1.0
 */
add_action( 'plugins_loaded', 'private_content_setup' );

/**
 * Setup the plugin and fire the necessary files.
 *
 *  @since 6.4
 */
function private_content_setup() {
	/**
	 * Load the translation.
	 *
	 * @since 6.4
	 */
	load_plugin_textdomain( 'private-content', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	/**
	 * Include the class.
	 *
	 * @since 5.1
	 */
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ubn-private.php';

	/**
	 * Add links to plugins list line.
	 *
	 * @since 6.4
	 */
	add_filter( 'plugin_row_meta', 'private_content_add_links', 10, 2 );

	/**
	 * Run the plugin.
	 *
	 * @since 6.4 Moved from root to the setup function.
	 */
	ubn_private_run();
}

/**
 * Instantiate the object and run the plugin.
 *
 * @since 5.1
 */
function ubn_private_run() {
	$ubn_private = new UBN_Private();
	$ubn_private->run();
}

/**
 * Add links to plugins list line.
 *
 * @param array  $links The array containing links.
 * @param string $file The path to the current file.
 * @since 6.4
 */
function private_content_add_links( $links, $file ) {
	if ( plugin_basename( __FILE__ ) === $file ) {
		// Changelog.
		$changelog_url = 'https://github.com/aldolat/private-content/blob/master/CHANGELOG.md';
		$links[]       = '<a target="_blank" href="' . $changelog_url . '">' . esc_html__( 'Changelog', 'private-content' ) . '</a>';

		// Documentation.
		$doc_url = 'https://github.com/aldolat/private-content/wiki';
		$links[] = '<a target="_blank" href="' . $doc_url . '">' . esc_html__( 'Documentation', 'private-content' ) . '</a>';

		// PDF Documentation.
		$doc_url = 'https://github.com/aldolat/private-content.latex/raw/master/private-content.pdf';
		$links[] = '<a target="_blank" href="' . $doc_url . '">' . esc_html__( 'PDF Documentation', 'private-content' ) . '</a>';

		// Reviews.
		$rate_url = 'https://wordpress.org/support/plugin/' . basename( dirname( __FILE__ ) ) . '/reviews/#new-post';
		$links[]  = '<a target="_blank" href="' . $rate_url . '">' . esc_html__( 'Rate this plugin', 'private-content' ) . '</a>';
	}
	return $links;
}

/*
 * CODE IS POETRY
 */
