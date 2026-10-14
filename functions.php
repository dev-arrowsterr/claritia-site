<?php
/**
 * Claritia theme.
 *
 * The front page always uses pages/home (home.php and home.css), whatever is set in Settings → Reading.
 * Everything else (blog, plain pages, 404) uses blog/blog.css.
 * /llms.txt and /pricing.md come from inc/text.php. Old app links on this domain go to the app (inc/text.php).
 */

if (!defined('ABSPATH')) exit;

const CL_APP = 'https://app.tryclaritia.com';
const CL_EMAIL = 'hello@tryclaritia.com';
const CL_COMPANY = 'Perceptric';
const CL_DESCRIPTION = 'Tests that write and fix themselves. Describe a user flow in plain English and Claritia turns it into a Playwright test.';

require_once __DIR__ . '/inc/plans.php';
require_once __DIR__ . '/inc/parts.php';
require_once __DIR__ . '/inc/text.php';
require_once __DIR__ . '/inc/deploy.php';

add_action('after_setup_theme', function () {
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('responsive-embeds');
});

/** A link into the app. */
function cl_app(string $path = ''): string {
	return CL_APP . $path;
}

/** Cache-busting version: the file's last change time. */
function cl_ver(string $rel): string {
	$file = get_theme_file_path($rel);
	return is_file($file) ? (string) filemtime($file) : '1';
}

// The front page is always the hand-built homepage.
add_filter('template_include', fn($template) => is_front_page() ? get_theme_file_path('pages/home/home.php') : $template, 99);

// The homepage title is just "Claritia". Other pages read "<title> · Claritia".
add_filter('pre_get_document_title', function ($title) {
	if (is_front_page()) return 'Claritia';
	return $title;
});
add_filter('document_title_separator', fn() => '·');
add_filter('document_title_parts', function ($parts) {
	$parts['site'] = 'Claritia';
	unset($parts['tagline']);
	return $parts;
});

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_style('cl-fonts', 'https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Geist+Mono:wght@400;500&display=swap', [], null);
	wp_enqueue_style('cl-base', get_theme_file_uri('assets/base.css'), ['cl-fonts'], cl_ver('assets/base.css'));
	if (is_front_page()) {
		wp_enqueue_style('cl-home', get_theme_file_uri('pages/home/home.css'), ['cl-base'], cl_ver('pages/home/home.css'));
		// The homepage never uses block content, so skip the block styles.
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('global-styles');
		wp_dequeue_style('classic-theme-styles');
	} else {
		wp_enqueue_style('cl-blog', get_theme_file_uri('blog/blog.css'), ['cl-base'], cl_ver('blog/blog.css'));
	}
}, 20);

// Fewer extras in <head>.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');

/** True when an SEO plugin prints its own description, canonical and share tags. */
function cl_has_seo_plugin(): bool {
	return defined('WPSEO_VERSION') || class_exists('RankMath') || defined('AIOSEO_VERSION') || defined('SEOPRESS_VERSION');
}

// We print the homepage canonical ourselves (see cl_head), so WordPress doesn't print a second one.
add_action('wp', function () {
	if (is_front_page() && !cl_has_seo_plugin()) remove_action('wp_head', 'rel_canonical');
});

/**
 * Description, canonical, share tags and icons.
 * WordPress's own Site Icon wins if one is set, and an SEO plugin's tags win over ours.
 */
function cl_head(): void {
	$b = fn($f) => esc_url(get_theme_file_uri("assets/brand/$f"));
	if (!has_site_icon()) {
		echo '<link rel="icon" href="' . $b('favicon.ico') . '" sizes="48x48">' . "\n";
		echo '<link rel="icon" href="' . $b('claritia-mark.svg') . '" type="image/svg+xml">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . $b('apple-touch-icon.png') . '">' . "\n";
	}
	echo '<meta name="theme-color" content="#ffffff">' . "\n";
	if (cl_has_seo_plugin()) return;

	$front = is_front_page();
	$title = $front ? 'Claritia' : wp_get_document_title();
	$desc = $front ? CL_DESCRIPTION : (is_singular() ? wp_strip_all_tags(get_the_excerpt()) : CL_DESCRIPTION);
	$url = $front ? home_url('/') : (is_singular() ? (string) get_permalink() : '');
	$own = !$front && is_singular() && has_post_thumbnail();
	$img = $own ? get_the_post_thumbnail_url(null, 'full') : get_theme_file_uri('assets/brand/og-image.png');

	if ($desc) printf('<meta name="description" content="%s">' . "\n", esc_attr($desc));
	if ($front) printf('<link rel="canonical" href="%s">' . "\n", esc_url($url));
	echo '<meta property="og:site_name" content="Claritia">' . "\n";
	printf('<meta property="og:type" content="%s">' . "\n", is_singular('post') ? 'article' : 'website');
	printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
	if ($desc) printf('<meta property="og:description" content="%s">' . "\n", esc_attr($desc));
	if ($url) printf('<meta property="og:url" content="%s">' . "\n", esc_url($url));
	printf('<meta property="og:image" content="%s">' . "\n", esc_url($img));
	if (!$own) echo '<meta property="og:image:width" content="1200">' . "\n" . '<meta property="og:image:height" content="630">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
