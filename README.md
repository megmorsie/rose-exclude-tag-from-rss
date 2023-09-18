# Exclude Tag from RSS Feed

## Installation & Setup

1. **Set up a "no-rss" tag**. - This can be named anything, as it will only be visible on the admin side of the site. I'm referring to the tag that way within the source code for clarity and consistency.
2. Identify the **corresponding tag ID**. - The quickest way is to go from the [admin to > Posts > Tags](https://dsacleveland.org/wp-admin/edit-tags.php?taxonomy=post_tag) and either hover on or click Edit on the tag you set up and find this in the URL: `tag_ID=36`. The number following the `=` is the tag ID.
3. Open the **`rose-exclude-tag-from-rss.php` file in a text editor** (Notepad, TextEdit, Sublime Text, PHPStorm, etc - NOT a word processor).
4. Ensure the number on this line: `$exclude_tag_id = 36;` matches **your tag ID** from step 2. If they do not match, change this number, being mindful to only replace the number itself, not removing any other characters from that line as it will cause a 500 error (AKA "whitescreen") on the website when activated if there are any missing characters. 🙂
5. Always **test locally** or on a staging environment before "pushing" to the production server. If you aren't a coder, please have someone who is double-check your work!
6. After testing, you can **install the plugin like any other plugin**! - Zip the folder and upload it via the WordPress admin interface (`/wp-admin`) and activate it. Alternatively, you can upload the plugin directory via SFTP to the `/plugins` directory and then activate it via the WordPress admin but this is not preferred. (Be *extremely* careful if you are using a GUI to interact via SFTP as it is easy to accidentally move folders with the cursor.)

## Maintenance & Troubleshooting

This plugin has been tested with WordPress version **6.1.3** on a server running PHP **8.0.8**. It's dependent on the WordPress core filter `pre_get_posts` and the `WP_Query` class, which are central to how WordPress works. It would be extremely unlikely that these features would be deprecated.

The only thing that would need updated in the future would be **if the corresponding tag is deleted and recreated**. If this happens, someone should replace the tag ID in the main plugin file referenced above. (Ideal process would be to remove the plugin from the WordPress admin interface, make the edits and test locally, then reupload the zip of the directory via the WordPress admin and activate the plugin again.)
