<?php

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
