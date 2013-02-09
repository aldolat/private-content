<?php
/**
 * Private content uninstallation
 *
 * @since 2.0
 */


// Check for the 'WP_UNINSTALL_PLUGIN' constant, before executing

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

// Delete custom capabilities from the database

global $wp_roles;
$wp_roles->remove_cap( 'editor',      'read_ubn_editor_notes'      );
$wp_roles->remove_cap( 'author',      'read_ubn_author_notes'      );
$wp_roles->remove_cap( 'contributor', 'read_ubn_contributor_notes' );
$wp_roles->remove_cap( 'subscriber',  'read_ubn_subscriber_notes'  );
