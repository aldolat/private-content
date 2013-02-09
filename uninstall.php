<?php
/**
 * Private content uninstallation
 *
 * @since 1.2
 */


// Check for the 'WP_UNINSTALL_PLUGIN' constant, before executing

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

// Delete custom capabilities from the database

$editor_role = get_role( 'editor' );
$editor_role->remove_cap( 'read_editor_notes' );

$author_role = get_role( 'author' );
$author_role->remove_cap( 'read_author_notes' );

$contributor_role = get_role( 'contributor' );
$contributor_role->remove_cap( 'read_contributor_notes' );

$subscriber_role = get_role( 'subscriber' );
$subscriber_role->remove_cap( 'read_subscriber_notes' );
