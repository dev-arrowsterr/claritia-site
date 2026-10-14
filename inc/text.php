<?php
/**
 * /llms.txt and /pricing.md, with no WordPress page needed.
 * The text matches src/app/llms.txt/route.ts and src/app/pricing.md/route.ts in the app.
 * Pricing comes from CL_PLANS (inc/plans.php), the same list as the homepage cards.
 *
 * Also: old app links on this domain (like tryclaritia.com/tests) go to the same path on the app.
 * The Next.js site did this for every path. Here it only happens when WordPress has no page there,
 * so blog posts and pages still work.
 */

if (!defined('ABSPATH')) exit;

/** The request path without the leading and trailing slash, relative to the site's home. */
function cl_request_path(): string {
	$path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
	$base = rtrim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');
	if ($base !== '' && str_starts_with($path, $base)) $path = substr($path, strlen($base));
	return trim(rawurldecode($path), '/');
}

function cl_llms_txt(): string {
	$app = CL_APP;
	$email = CL_EMAIL;
	return <<<TXT
# Claritia

> Claritia is AI end-to-end testing. You describe a user flow in plain English, Claritia writes it as a Playwright test, runs it in a real browser in the cloud, and saves the video, trace, network log and screenshots.

## How it works

- A test is a list of plain-English steps. Each step is "do" (an action) or "check" (something that must be true).
- On the first run, Claude writes the Playwright code for each step while the browser runs it. Every line is checked against a fixed list of allowed actions before it runs.
- Passing code is saved to the test. Later runs replay it with no AI calls. A step is written again only when its words change.
- Test inboxes: a test can sign up with a fresh email address, then read the code or link from the email it gets.
- Secrets (passwords, API keys) are sealed before they're saved and hidden in errors, logs and traces.
- Runs can't reach private network addresses.

## Pages

- [Home](https://tryclaritia.com/): what Claritia does
- [Pricing](https://tryclaritia.com/pricing.md): plans, cloud minutes and AI credits, in Markdown
- [App]($app): sign in and start testing

## Contact

$email

TXT;
}

function cl_pricing_md(): string {
	$rows = implode("\n", array_map(fn($p) => sprintf(
		'| %s | %s | %s | %s | %s | %s |',
		$p['name'],
		$p['price'] === null ? 'Custom' : '$' . $p['price'] . '/month',
		$p['projects'] === null ? 'Unlimited' : $p['projects'],
		cl_amount($p['minutes']),
		cl_amount($p['credits']),
		implode(', ', $p['features'])
	), CL_PLANS));
	$app = CL_APP;
	$email = CL_EMAIL;
	return <<<MD
# Claritia pricing

Claritia turns plain-English user flows into Playwright tests, runs them in the cloud, and saves video, traces, network logs and screenshots for every run.

| Plan | Price | Projects | Cloud minutes a month | AI credits a month | Also includes |
|---|---|---|---|---|---|
$rows

- Unlimited users on every plan.
- A cloud minute is one minute of browser time in a cloud run.
- An AI credit is one call to Claude to write a step. Claude writes each step once, then every run replays the saved Playwright code and uses no credits.
- Plans renew monthly. Cancel any time from Settings.
- Business is billed yearly. Write to $email.

Start free: $app

MD;
}

/** Path => [content type, function that returns the text]. */
const CL_TEXT_FILES = [
	'llms.txt' => ['text/plain; charset=utf-8', 'cl_llms_txt'],
	'pricing.md' => ['text/markdown; charset=utf-8', 'cl_pricing_md'],
];

add_action('init', function () {
	if (is_admin() || !in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['GET', 'HEAD'], true)) return;
	$file = CL_TEXT_FILES[cl_request_path()] ?? null;
	if (!$file) return;
	status_header(200);
	header('Content-Type: ' . $file[0]);
	header('Cache-Control: public, max-age=0, s-maxage=600');
	header('X-Content-Type-Options: nosniff');
	echo call_user_func($file[1]);
	exit;
});

/** First parts of app paths. A visit to tryclaritia.com/<one of these>/... goes to app.tryclaritia.com/<same path>. */
const CL_APP_PATHS = ['tests', 'blocks', 'runs', 'environments', 'schedules', 'approvals', 'insights', 'settings', 'start'];

// Runs before WordPress guesses a similar post for the 404 (redirect_canonical runs at priority 10).
add_action('template_redirect', function () {
	if (!is_404()) return;
	$path = cl_request_path();
	if (!in_array(explode('/', $path)[0], CL_APP_PATHS, true)) return;
	$query = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
	wp_redirect(CL_APP . '/' . $path . ($query !== '' ? "?$query" : ''), 308);
	exit;
}, 1);
