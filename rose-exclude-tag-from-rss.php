<?php
/**
 * Plugin Name: Exclude Tag from RSS Feed
 * Plugin URI: https://github.com/megmorsie/rose-exclude-tag-from-rss
 * Description: In order to protect our authors from potential exposure beyond our chapter (ie via the public RSS feed, which National also uses), this plugin will exclude all posts with a specific tag from the feed.
 * Version: 1.0
 * Author: Megan Rose
 * Author URI: https://megabyterose.com/
 * Text Domain: rose-exclude-tag-from-rss
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

/**
 * SETUP/TROUBLESHOOTING
 * The number below should be the ID of the "no-rss" tag.
 */

$exclude_tag_id = 36;

/**
 * Exclude tag with matching ID from RSS feed.
 */

function rose_exclude_tag_from_rss($query) {
	global $exclude_tag_id;

	if ($query->is_feed) {
		$query->set('tag__not_in', $exclude_tag_id); 
	}
	return $query;
}
add_filter('pre_get_posts', 'rose_exclude_tag_from_rss');

/**
 * Exclude tag with matching ID's listing on front end.
 * (Only relevant if the currently active theme displays tags on the front end.)
 */

function rose_exclude_tag_from_tags_list($terms) {
	global $exclude_tag_id;

	if ($terms == null) {
		return;
	}
	
	foreach ($terms as $t => $tag) {
		if ($tag->term_id == $exclude_tag_id) { 
			unset($terms[$t]);
		}
	}

	return $terms;
} 
add_filter('get_the_tags', 'rose_exclude_tag_from_tags_list');

/**
 * Redirect tag page (ie /tag/slug).
 */

function rose_exclude_tag_parse_query($query){
	global $exclude_tag_id;

	if ( !is_tag($exclude_tag_id) ) {
		return;
	}

	$redirect_to = '';
	if ( get_option('page_for_posts') ) {
		$redirect_to = get_permalink( get_option('page_for_posts') );
	} else {
		$redirect_to = home_url('/category/blog');
	}
	wp_redirect($redirect_to);
	exit;
}
add_action('parse_query', 'rose_exclude_tag_parse_query');

/**
 * Disallow search engines from indexing our excluded tag page.
 */

function rose_noindex_tag_page($robots) {
	global $exclude_tag_id;

	if ( is_tag($exclude_tag_id) ) {
		$robots['nofollow'] = true;
	}
	return $robots;
}
add_filter('wp_robots', 'rose_noindex_tag_page');
