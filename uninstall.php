<?php
/**
 * Uninstall script for Disable Gutenberg for WP
 *
 * @package DisableGutenbergForWP
 */

// Exit if accessed directly or not called by WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin options.
delete_option( 'dgwp_disabled_post_types' );

// For multisite installations, delete options from all sites.
if ( is_multisite() ) {
	global $wpdb;

	$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );

	foreach ( $blog_ids as $blog_id ) {
		switch_to_blog( $blog_id );
		delete_option( 'dgwp_disabled_post_types' );
		restore_current_blog();
	}
}
