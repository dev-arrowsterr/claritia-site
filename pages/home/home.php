<?php
/**
 * Homepage. A port of src/app/page.tsx and src/components/marketing/HeroMock.tsx in the app.
 * Styles: pages/home/home.css. Pricing cards come from CL_PLANS (inc/plans.php).
 */

$integrations = ['GitHub', 'GitLab', 'Vercel', 'Netlify', 'Slack', 'Playwright', 'Claude Code', 'Cursor'];

$steps = [
	['01', 'Describe', 'Write the flow the way you\'d explain it to a new teammate. Or paste your product spec.'],
	['02', 'Run', 'Claritia drives a real browser, step by step, and saves the video, screenshots and logs.'],
	['03', 'Heal', 'When your UI changes, Claritia finds the new button and asks you to approve the fix.'],
	['04', 'Gate', 'Tests run on every pull request. A failure blocks the merge and posts the video.'],
];

$stats = [
	['5 min', 'to your first passing test'],
	['100%', 'of runs saved with video'],
	['0', 'lines of selector code'],
	['None', 'lock-in'],
];

// The hero picture: a test run.
$mock_steps = [
	['Go to the pricing page', 'cached', 'Cached', '0.4s'],
	['Click “Start trial”', 'healed', 'Healed', '1.1s'],
	['Sign up with a test inbox', 'passed', 'Passed', '3.2s'],
	['Enter the code from the email', 'passed', 'Passed', '4.8s'],
	['Check the plan says “Pro trial”', 'passed', 'Passed', '0.9s'],
];

$run_steps = [
	['1', 'Add the blue hoodie to the cart', 'passed', 'Passed'],
	['2', 'Apply the coupon SAVE10', 'passed', 'Passed'],
	['3', 'Check the total drops 10%', 'passed', 'Passed'],
	['4', 'Pay with the test card', 'failed', 'Failed'],
];

$files = [
	['checkout.yaml', 'failed', 'Failed'],
	['signup.yaml', 'passed', 'Passed'],
	['billing.yaml', 'healed', 'Healed'],
];

$agent_points = [
	'Crawls a URL and suggests the tests you\'re missing',
	'Writes tests from your PRD or product spec',
	'Fixes broken selectors and shows you the change',
	'Sorts every failure into bug, flake or setup',
];

$agent_runs = [
	['Explore', 'acme.com · 12 tests suggested', 'Needs review', 'flaky'],
	['Heal', 'checkout.yaml · selector updated', 'Needs approval', 'flaky'],
	['Sort', 'Run #482 · app bug', 'Done', 'passed'],
	['Nightly', '48 tests on production', 'Scheduled 2:00', 'brand'],
];

$dev_facts = [
	['Repo files', 'Tests are reviewed in pull requests like code'],
	['CI gate', 'A GitHub Action blocks merges on failure'],
	['MCP server', 'Claude Code and Cursor write and run tests'],
	['Playwright export', 'Take your tests with you any time'],
];

$security = [
	['Encrypted secrets', 'Passwords and API keys are encrypted and never shown in logs or videos.'],
	['Isolated runs', 'Every run gets a fresh browser in its own container, wiped when it ends.'],
	['Never used for training', 'Your app, tests and videos are never used to train AI models.'],
	['Delete any time', 'Remove a project and its runs, videos and secrets are gone.'],
];

$cards = cl_plan_cards();

/** A "// label" caption above a section heading. */
$eyebrow = fn(string $text, bool $dark = false) => '<p class="fig' . ($dark ? ' fig--dark' : '') . '">// ' . esc_html($text) . '</p>';

// Code colors in the YAML window: keys, strings, dashes.
$k = fn($t) => '<span class="c-key">' . esc_html($t) . '</span>';
$s = fn($t) => '<span class="c-str">' . esc_html($t) . '</span>';
$d = fn($t) => '<span class="c-dim">' . esc_html($t) . '</span>';

get_header();
?>

<!-- Hero -->
<section class="hero">
	<div class="dot-grid" aria-hidden="true"></div>
	<div class="wrap hero__in">
		<div class="mk-fade hero__copy">
			<a class="hero__badge" href="#agent"><span class="tag tag--brand">New</span>Tests from plain English<span class="hero__badge-arrow" aria-hidden="true">→</span></a>
			<h1 class="hero__title">Tests that write<br><span class="hero__accent">and fix themselves.</span></h1>
			<p class="hero__lead">Describe a user flow in plain English. Claritia turns it into a Playwright test, runs it on every push, and fixes it when your UI changes. Every run comes with a video.</p>
			<div class="hero__ctas">
				<a class="btn btn--lg btn--ink" href="<?php echo esc_url(cl_app()); ?>">Start free</a>
				<a class="btn btn--lg btn--line" href="#product">Watch a test run</a>
			</div>
			<p class="hero__small">Free tier · No card needed · Export to Playwright any time</p>
		</div>

		<div class="mk-fade hero__mock" style="animation-delay:120ms">
			<div class="mock">
				<div class="frame mock__win">
					<div class="mock__bar">
						<span class="fig">// fig. 01 — run #482</span>
						<span class="mock__url">app.tryclaritia.com/runs/482</span>
					</div>
					<div class="mock__head">
						<p class="mock__title">Sign up for a Pro trial</p>
						<?php echo cl_tag('passed', 'Passed'); ?>
						<p class="mock__meta">staging · 10.4s · 2m ago</p>
					</div>
					<div class="mock__body">
						<ol class="mock__steps">
							<?php foreach ($mock_steps as $i => [$text, $tone, $tag, $ms]) : ?>
								<li<?php echo $i === 2 ? ' class="is-on"' : ''; ?>>
									<span class="mock__n"><?php echo $i + 1; ?></span>
									<p class="mock__step"><?php echo esc_html($text); ?></p>
									<?php echo cl_tag($tone, $tag); ?>
									<span class="mock__ms"><?php echo esc_html($ms); ?></span>
								</li>
							<?php endforeach; ?>
						</ol>
						<div class="mock__video">
							<div class="shot">
								<div class="shot__bar">
									<span class="shot__dot"></span><span class="shot__dot"></span><span class="shot__dot"></span>
									<span class="shot__url">staging.acme.com/signup</span>
								</div>
								<div class="shot__body">
									<p class="shot__title">Create your account</p>
									<p class="shot__sub">14-day Pro trial. No card needed.</p>
									<div class="shot__fields">
										<div class="shot__field">qa+482@inbox.tryclaritia.com</div>
										<div class="shot__field shot__field--on">••••••••••<span class="shot__fill">fill</span></div>
										<div class="shot__button">Create account</div>
									</div>
								</div>
							</div>
							<div class="scrub">
								<span class="scrub__play"><?php echo cl_icon('play', 10); ?></span>
								<div class="scrub__track">
									<div class="scrub__done"></div>
									<?php foreach ([0, 4, 15, 46, 91] as $p) : ?>
										<span class="scrub__tick" style="left:<?php echo $p; ?>%"></span>
									<?php endforeach; ?>
								</div>
								<span class="scrub__time">0:04 / 0:10</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Healing suggestion, floating -->
				<div class="float float--heal">
					<p class="label-mono float__label"><span class="dot dot--violet mk-pulse"></span> Healing suggestion</p>
					<p class="float__title">Step 2 · Click “Start trial”</p>
					<p class="float__diff"><span class="float__old">text=Start trial</span> → <span class="float__new">text=Try free</span></p>
					<p class="float__why">The button text changed in the last deploy. Same place, same page.</p>
					<div class="float__btns">
						<span class="float__ok">Approve</span>
						<span class="float__skip">Skip</span>
					</div>
				</div>

				<!-- The test, floating -->
				<div class="float float--test">
					<p class="float__cap">// test</p>
					<p class="float__sentence">Sign up, confirm the email, and land on the Pro trial.</p>
					<p class="float__foot">5 steps · written from one sentence</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Integrations -->
<section class="works">
	<div class="wrap works__in">
		<p class="label-mono works__label">Works with</p>
		<ul class="works__list">
			<?php foreach ($integrations as $name) : ?>
				<li><?php echo esc_html($name); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- How it works -->
<section id="how" class="sec">
	<div class="wrap sec__in">
		<div class="sec__head">
			<?php echo $eyebrow('How it works'); ?>
			<h2 class="sec__title">From a sentence to a green check.</h2>
			<p class="sec__lead">No selectors to write and no scripts to fix. Tell Claritia what a user does, and it handles the rest.</p>
		</div>
		<ol class="frame steps">
			<?php foreach ($steps as [$n, $title, $body]) : ?>
				<li>
					<p class="fig">// step <?php echo esc_html($n); ?></p>
					<h3><?php echo esc_html($title); ?></h3>
					<p><?php echo esc_html($body); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<!-- Product bento -->
<section id="product" class="sec sec--canvas">
	<div class="wrap sec__in">
		<div class="sec__head">
			<?php echo $eyebrow('The product'); ?>
			<h2 class="sec__title">Every failure, explained.</h2>
			<p class="sec__lead">Real bugs get flagged. Flaky ones get sorted out. You only look at what matters.</p>
		</div>

		<div class="bento">
			<!-- Run viewer -->
			<article class="frame card bento__4">
				<h3 class="card__title">See exactly what broke</h3>
				<p class="card__text card__text--narrow">Video, trace, console and network in one screen. Click a step to jump to that moment.</p>
				<div class="runlist">
					<?php foreach ($run_steps as [$n, $text, $tone, $tag]) : ?>
						<div class="runlist__row<?php echo $tone === 'failed' ? ' is-failed' : ''; ?>">
							<div class="runlist__in">
								<span class="runlist__n"><?php echo esc_html($n); ?></span>
								<span class="runlist__text"><?php echo esc_html($text); ?></span>
								<?php echo cl_tag($tone, $tag); ?>
							</div>
							<?php if ($tone === 'failed') : ?>
								<p class="runlist__err">POST /api/checkout → 500 · &quot;card_token is undefined&quot;</p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</article>

			<!-- Failure sorting -->
			<article class="card bento__2">
				<h3 class="card__title">Bug, flake or setup?</h3>
				<p class="card__text">Each failure gets a label and the reason behind it.</p>
				<div class="frame verdict">
					<p class="label-mono">Verdict · set by AI</p>
					<p class="verdict__tag"><?php echo cl_tag('failed', 'App bug'); ?></p>
					<p class="verdict__title">Checkout returns a 500</p>
					<p class="verdict__why">“card_token is undefined” in the console, same error on retry.</p>
					<p class="verdict__where">Run #482 · step 4 · 0:14</p>
				</div>
			</article>

			<!-- Plain-English checks -->
			<article class="card bento__3">
				<h3 class="card__title">Check what a person would check</h3>
				<p class="card__text">Write checks in plain words. Claritia shows how it decided.</p>
				<div class="chat">
					<p class="chat__ask">Check the total drops 10% after the coupon</p>
					<div class="chat__reply">
						<span class="chat__ok">Passed.</span> The total went from $120.00 to $108.00.
						<p class="chat__chips">
							<?php foreach (['Step 6', 'Screenshot', 'DOM'] as $chip) : ?>
								<span><?php echo esc_html($chip); ?></span>
							<?php endforeach; ?>
						</p>
					</div>
				</div>
			</article>

			<!-- Tests in your repo -->
			<article class="card bento__3">
				<h3 class="card__title">Your tests live with your code</h3>
				<p class="card__text">Plain YAML files, reviewed in pull requests like everything else.</p>
				<div class="tree">
					<p class="tree__dir"><?php echo cl_icon('folder', 14); ?>.claritia/</p>
					<div class="tree__files">
						<?php foreach ($files as [$file, $tone, $tag]) : ?>
							<div class="tree__file">
								<span class="tree__name"><?php echo esc_html($file); ?></span>
								<?php echo cl_tag($tone, $tag); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</article>
		</div>
	</div>
</section>

<!-- Agent -->
<section id="agent" class="sec">
	<div class="wrap sec__in agent">
		<div>
			<?php echo $eyebrow('Agent'); ?>
			<h2 class="sec__title">A QA engineer that never sleeps.</h2>
			<p class="sec__lead">The agent explores your app, writes tests and keeps them green. Anything that changes a test waits for your yes.</p>
			<ul class="checks">
				<?php foreach ($agent_points as $t) : ?>
					<li><?php echo cl_icon('check', 16, 'checks__icon'); ?><?php echo esc_html($t); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="frame runs">
			<div class="runs__head">
				<p class="label-mono runs__label"><span class="dot"></span>Agent runs</p>
				<p class="runs__live"><span class="dot dot--green mk-pulse"></span>Live</p>
			</div>
			<ul class="runs__list">
				<?php foreach ($agent_runs as [$name, $what, $status, $tone]) : ?>
					<li>
						<span class="runs__icon"><?php echo esc_html(strtoupper(substr($name, 0, 2))); ?></span>
						<div class="runs__body">
							<p class="runs__name"><?php echo esc_html($name); ?></p>
							<p class="runs__what"><?php echo esc_html($what); ?></p>
						</div>
						<?php echo cl_tag($tone, $status); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</section>

<!-- Developers, dark -->
<section id="developers" class="sec sec--dark">
	<div class="mk-dots" aria-hidden="true"></div>
	<div class="wrap sec__in">
		<div class="devs">
			<div>
				<?php echo $eyebrow('Built for developers', true); ?>
				<h2 class="sec__title">Plain files. Real Playwright. No lock-in.</h2>
				<p class="sec__lead">Every test is a YAML file in your repo. Run it from your laptop, in CI, or from Claude Code. Export to plain Playwright code whenever you want.</p>
				<dl class="facts">
					<?php foreach ($dev_facts as [$t, $desc]) : ?>
						<div>
							<dt><?php echo esc_html($t); ?></dt>
							<dd><?php echo esc_html($desc); ?></dd>
						</div>
					<?php endforeach; ?>
				</dl>
			</div>
			<div class="code">
				<div class="code__bar">
					<span class="code__dot"></span><span class="code__dot"></span><span class="code__dot"></span>
					<span class="code__name">.claritia/checkout.yaml</span>
				</div>
<pre class="code__pre"><code><?php
echo $k('name') . ': ' . $s('Checkout with a coupon') . "\n";
echo $k('url') . ': ' . $s('https://staging.acme.com') . "\n";
echo $k('steps') . ":\n";
$lines = ['Add the blue hoodie to the cart', 'Apply the coupon SAVE10', 'Check the total drops 10%', 'Pay with the test card', 'Check the page says "Order confirmed"'];
echo implode("\n", array_map(fn($l) => '  ' . $d('-') . ' ' . $s($l), $lines));
?></code></pre>
				<div class="code__foot">
					<p><span class="c-key">$</span> claritia run <?php echo $s('checkout.yaml'); ?></p>
					<p><span class="c-str">✓</span> 5 steps passed · 3 from cache · 8.2s</p>
				</div>
			</div>
		</div>

		<div class="stats">
			<?php foreach ($stats as [$value, $label]) : ?>
				<div>
					<p class="stats__label">// <?php echo esc_html($label); ?></p>
					<p class="stats__value"><?php echo esc_html($value); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Security -->
<section id="security" class="sec">
	<div class="wrap sec__in">
		<div class="sec__head sec__head--center">
			<?php echo $eyebrow('Security'); ?>
			<h2 class="sec__title">Your staging site and secrets stay safe.</h2>
		</div>
		<div class="safe">
			<?php foreach ($security as [$t, $desc]) : ?>
				<div class="safe__card">
					<span class="safe__icon"><?php echo cl_icon('shield', 18); ?></span>
					<h3><?php echo esc_html($t); ?></h3>
					<p><?php echo esc_html($desc); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Pricing -->
<section id="pricing" class="sec sec--canvas">
	<div class="wrap sec__in">
		<div class="sec__head sec__head--center">
			<?php echo $eyebrow('Pricing'); ?>
			<h2 class="sec__title">Start free. Pay for what runs.</h2>
			<p class="sec__lead">Unlimited users on every plan. The AI writes each step once. Replays from saved code use no AI credits.</p>
		</div>
		<div class="plans">
			<?php foreach ($cards as $p) : ?>
				<div class="plan<?php echo $p['featured'] ? ' plan--featured frame' : ''; ?>">
					<div class="plan__top">
						<p class="plan__name"><?php echo esc_html($p['name']); ?></p>
						<?php if ($p['featured']) echo cl_tag('brand', 'Most popular'); ?>
					</div>
					<p class="plan__price"><?php echo esc_html($p['price']); ?></p>
					<p class="plan__note"><?php echo esc_html($p['note']); ?></p>
					<ul class="plan__items">
						<?php foreach ($p['items'] as $item) : ?>
							<li><?php echo cl_icon('check', 16, 'plan__check'); ?><?php echo esc_html($item); ?></li>
						<?php endforeach; ?>
					</ul>
					<a class="btn btn--md plan__cta <?php echo $p['featured'] ? 'btn--white' : 'btn--ink'; ?>" href="<?php echo esc_url($p['href']); ?>"><?php echo esc_html($p['cta']); ?></a>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="plans__note">A cloud minute is a minute of browser time. An AI credit is one call to write a step. Managed service: we write and keep your top flows green.</p>
	</div>
</section>

<!-- Final call -->
<section class="final">
	<div class="mk-dots" aria-hidden="true"></div>
	<div class="final__in">
		<h2 class="final__title">Stop fixing tests. Start shipping.</h2>
		<p class="final__lead">Write your first test in plain English and watch it run in the next five minutes.</p>
		<div class="final__ctas">
			<a class="btn btn--lg btn--white" href="<?php echo esc_url(cl_app()); ?>">Start free</a>
			<a class="btn btn--lg btn--ghost" href="mailto:<?php echo esc_attr(CL_EMAIL); ?>">Talk to us</a>
		</div>
	</div>
</section>

<?php get_footer();
