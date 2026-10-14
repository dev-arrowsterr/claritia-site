<?php
/**
 * The plans. This list matches src/lib/plans.ts in the app. Change both together.
 * The homepage pricing cards and /pricing.md are both built from it.
 * null means no limit (or a custom price).
 */

if (!defined('ABSPATH')) exit;

const CL_PLANS = [
	['id' => 'free', 'name' => 'Free', 'price' => 0, 'projects' => 1, 'minutes' => 300, 'credits' => 200, 'features' => ['Video, trace and network log for every run', 'Test inboxes']],
	['id' => 'starter', 'name' => 'Starter', 'price' => 49, 'projects' => 3, 'minutes' => 2000, 'credits' => 2000, 'features' => ['GitHub App', 'Schedules']],
	['id' => 'team', 'name' => 'Team', 'price' => 199, 'projects' => null, 'minutes' => 10000, 'credits' => 10000, 'features' => ['MCP server', 'PR-aware runs', 'Slack alerts']],
	['id' => 'business', 'name' => 'Business', 'price' => null, 'projects' => null, 'minutes' => null, 'credits' => null, 'features' => ['SSO', 'Private runners', 'Data region', 'Managed test writing']],
];

/** "2,000" or "Unlimited". */
function cl_amount(?int $n): string {
	return $n === null ? 'Unlimited' : number_format($n);
}

/** The homepage pricing cards, built the same way as CARDS in the app's src/app/page.tsx. */
function cl_plan_cards(): array {
	return array_map(function ($p) {
		$business = $p['id'] === 'business';
		$items = $business
			? ['Higher limits']
			: [
				($p['projects'] === null ? 'Unlimited' : $p['projects']) . ' ' . ($p['projects'] === 1 ? 'project' : 'projects'),
				cl_amount($p['minutes']) . ' cloud minutes a month',
				cl_amount($p['credits']) . ' AI credits a month',
			];
		return [
			'name' => $p['name'],
			'price' => $p['price'] === null ? 'Custom' : '$' . $p['price'],
			'note' => $p['id'] === 'free' ? 'for side projects' : ($p['price'] === null ? 'billed yearly' : 'per month'),
			'items' => array_merge($items, $p['features']),
			'cta' => $business ? 'Talk to us' : 'Start free',
			'href' => $business ? 'mailto:' . CL_EMAIL : CL_APP,
			'featured' => $p['id'] === 'team',
		];
	}, CL_PLANS);
}
