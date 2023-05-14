```

   _____          __  .__                   ________         .__         
  /  _  \  __ ___/  |_|  |__   ___________  \_____  \   ____ |  | ___.__.
 /  /_\  \|  |  \   __\  |  \ /  _ \_  __ \  /   |   \ /    \|  |<   |  |
/    |    \  |  /|  | |   Y  (  <_> )  | \/ /    |    \   |  \  |_\___  |
\____|__  /____/ |__| |___|  /\____/|__|    \_______  /___|  /____/ ____|
        \/                 \/                       \/     \/     \/     

```
This plugin limiting access to specific content such as posts and media attachments only to the author of the post or media.  It is ideal for multi author sites.

-- DETAILS --

This PHP code consists of two functions that work together to enhance the security of a WordPress site. 

The first function is `limit_posts_to_logged_in_author()`. It takes a WP_Query object as its parameter. This function checks if the current user is logged in and has an 'author' role. If the current user does not fulfil these conditions, the original query object is returned. Otherwise, the function sets the author parameter to the ID of the current user. This ensures that only posts created by the currently logged-in user are shown on the frontend.

The second function is `wpb_show_current_user_attachments()`. It takes an array of query arguments for fetching attachments as its parameter. This function fetches the current user ID using the `get_current_user_id()` function. If the user has no ID due to being unauthenticated, attribution is set to `0`. If the user is authenticated but lacks privileges like `activate_plugins` or `edit_others_posts`, `wpb_show_current_user_attachments()` will modify the query argument to include only the attachments uploaded by the current user whose ID is obtained from the `get_current_user_id()` function. It then returns the modified query arguments which would enable only the authorized user to view their media attachments.

Both of these functions use hooks to connect to WordPress core functionalities. The `limit_posts_to_logged_in_author()` function uses the `pre_get_posts` action while `wpb_show_current_user_attachments()` function uses the `ajax_query_attachments_args` filter to modify query arguments before they're executed.

