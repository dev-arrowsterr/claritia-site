<?php
/**
 * Fresh pages after every deploy.
 * Hostinger deploys by updating theme files, but LiteSpeed and the Hostinger CDN can keep serving
 * cached HTML for days. When any theme file changes, the next page that runs PHP purges the
 * whole cache. HTML also tells shared caches to keep pages for 10 minutes at most.
 * Same as inc/deploy.php in the Arrowsterr theme.
 */

if (!defined('ABSPATH')) exit;

/** The theme's build stamp: the newest file change in the theme, checked once a minute. */
function cl_build(): array {
	$cached = get_transient('cl_build');
	if (is_array($cached)) return $cached;
	$newest = 0;
	$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(get_theme_file_path(), FilesystemIterator::SKIP_DOTS));
	foreach ($it as $f) if ($f->isFile() && !str_contains($f->getPathname(), '/.git/')) $newest = max($newest, $f->getMTime());
	$build = ['at' => $newest, 'id' => substr(md5((string) $newest), 0, 7)];
	set_transient('cl_build', $build, MINUTE_IN_SECONDS);
	return $build;
}

add_action('send_headers', function () {
	if (is_admin()) return;
	$build = cl_build();
	if ((string) get_option('cl_build_id') !== $build['id']) {
		update_option('cl_build_id', $build['id'], false);
		do_action('litespeed_purge_all'); // LiteSpeed Cache plugin, if installed
		header('X-LiteSpeed-Purge: *');   // LiteSpeed server cache, with or without the plugin
	}
	if (!is_user_logged_in()) header('Cache-Control: public, max-age=0, s-maxage=600');
});

/** A missing page is never cached, so a post published a minute later doesn't stay "not found". */
add_action('template_redirect', function () {
	if (!is_404()) return;
	header('Cache-Control: no-store');
	header('X-LiteSpeed-Cache-Control: no-cache');
}, 99);
