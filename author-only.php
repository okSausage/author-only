<?php

/**
 * Author Only plugin for WordPress
 *
 * @package   author-only
 * @link      https://github.com/okSausage/author-only
 * @license   GPLV2
 *
 * Plugin Name:  Author Only
 * Description:  * Description:  A simple plugin that modifies the posts listing in the Wordpress Admin.  With this plugin activated users logged into wp-admin will only see and be able to edit posts that they authored.
 * Version:      1.0.0
 * Plugin URI:   https://github.com/okSausage/author-only
 * Author:       Lou Grossi
 * Author URI:   https://www.github.com/okSausage
 * Text Domain:  author-only
 * Domain Path:  /languages/
 * Requires PHP: 7.x, 8.x
 *
 */

// Define the user role to limit the posts
define('POST_LIMIT_USER_ROLE', 'author');

/**
 * Limits the posts to the logged-in author
 *
 * @param object $query The WordPress query object
 * @return object The modified query object
 */
function limit_posts_to_logged_in_author($query) {
	// Check if current user is authenticated and has the specified role
	if (!is_user_logged_in() || !current_user_can(POST_LIMIT_USER_ROLE)) {
		return $query;
	}

	// Set the author in the query to the current user
	if ($query->is_main_query()) {
		$query->set('author', get_current_user_id());
	}

	return $query;
}

// Hook the function to the pre_get_posts action
add_action('pre_get_posts', 'limit_posts_to_logged_in_author');

// Limit media library access
add_filter('ajax_query_attachments_args', 'wpb_show_current_user_attachments');

function wpb_show_current_user_attachments($query) {
	$user_id = get_current_user_id();
	if ($user_id !== 0 && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts')) {
		$query['author'] = $user_id;
	}
	return $query;
}
