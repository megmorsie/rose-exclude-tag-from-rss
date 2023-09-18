<?php
/**
 * Plugin Name: Exclude Tag from RSS Feed
 * Plugin URI: https://github.com/megmorsie/rose-exclude-tag-from-rss
 * Description: In order to protect our authors from potential exposure beyond our chapter (ie via the public RSS feed, which National also uses), this plugin will exclude all posts with a specific tag from the feed.
 * Version: 0.1
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

$exclude_tag_id = 15;

/**
 * Exclude tag with matching ID from RSS feed.
 */

function rose_exclude_tag_from_rss($query) {
	global $exclude_tag_id;
	if ( ($query->is_feed) && (!is_admin()) ) {
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
		// The number on the next line should be the ID of the "no-rss" tag.
		if ($tag->term_id == $exclude_tag_id) { 
			unset($terms[$t]);
		}
	}

	return $terms;
} 
add_filter('get_the_tags', 'rose_exclude_tag_from_tags_list');
