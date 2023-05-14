<?php

/**
 * MadeSimpleSites plugin for WordPress
 *
 * @package   Author Only
 * @link      https://github.com/okSausage/author-only
 * @license   GPLV2
 *
 * Plugin Name:  Author Only
 * Description:  This plugin limits access to specific content such as posts and media attachments only to the author of the post or media.  It is ideal for multi author sites.
 * Version:      1.0.0
 * Plugin URI:   https://github.com/okSausage/author-only
 * Author:       Lou Grossi
 * Author URI:   https://github.com/okSausage
 * Text Domain:  author-only
 * Domain Path:  /languages/
 * Requires PHP: 7.x, 8.x
 *
 */

/**
 * Limits the posts to the logged-in author.
 *
 * @param WP_Query $query The WordPress Query object.
 * @return WP_Query The modified query object.
 */
function limit_posts_to_logged_in_author($query) {
	if (!is_user_logged_in() || !current_user_can('author')) {
		return $query;
	}

	if ($query->is_main_query()) {
		$query->set('author', get_current_user_id());
	}

	return $query;
}
add_action('pre_get_posts', 'limit_posts_to_logged_in_author');

/**
 * Limits media library access to the current user.
 *
 * @param array $query The WordPress Query args.
 *
 * @return array The modified query args.
 */
function wpb_show_current_user_attachments($query) {
	$user_id = get_current_user_id();

	if ($user_id !== 0 && !current_user_can(array('activate_plugins', 'edit_others_posts'))) {
		$query['author'] = $user_id;
	}

	return $query;
}
add_filter('ajax_query_attachments_args', 'wpb_show_current_user_attachments');
