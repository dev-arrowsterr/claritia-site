<?php
/**
 * Small pieces used on many pages: the logo, status tags and icons.
 * They match src/components/Logo.tsx, src/components/marketing/Tag.tsx and the inline icons in the app.
 */

if (!defined('ABSPATH')) exit;

/** The Claritia mark (a check inside a viewfinder, in a rounded square) and the word. */
function cl_logo(): string {
	return '<span class="logo">'
		. '<svg width="26" height="26" viewBox="0 0 32 32" aria-hidden="true">'
		. '<rect width="32" height="32" rx="8" fill="var(--brand)"/>'
		. '<path d="M7 12V7h5M20 7h5v5M25 20v5h-5M12 25H7v-5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>'
		. '<path d="M11.5 16.5l3 3 6-7" fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>'
		. '</svg><span class="logo__word">Claritia</span></span>';
}

/**
 * A square status tag. Tones: passed, failed, healed, cached, running, flaky, brand.
 */
function cl_tag(string $tone, string $text): string {
	return '<span class="tag tag--' . esc_attr($tone) . '">' . esc_html($text) . '</span>';
}

/** Line icons in one style. */
function cl_icon(string $name, int $size = 16, string $class = ''): string {
	$paths = [
		// A small check for lists (16px box).
		'check' => '<path d="M3.5 8.5l3 3 6-7" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>',
		'folder' => '<path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
		'shield' => '<path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/>',
		'play' => '<path d="M2.5 1.5v7l6-3.5z" fill="currentColor"/>',
	];
	$box = ['check' => 16, 'play' => 10][$name] ?? 24;
	$stroke = in_array($name, ['folder', 'shield'], true) ? ' fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"' : '';
	$cls = $class !== '' ? ' class="' . esc_attr($class) . '"' : '';
	return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 ' . $box . ' ' . $box . '"' . $stroke . $cls . ' aria-hidden="true">' . $paths[$name] . '</svg>';
}
