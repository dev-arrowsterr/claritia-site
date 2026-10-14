</main>
<?php
$cols = [
	'Product' => [
		'Run viewer' => home_url('/#product'),
		'Agent' => home_url('/#agent'),
		'Pricing' => home_url('/#pricing'),
	],
	'Developers' => [
		'Repo files' => home_url('/#developers'),
		'GitHub Action' => home_url('/#developers'),
		'MCP server' => home_url('/#developers'),
		'Security' => home_url('/#security'),
	],
	'Company' => [
		'Contact' => 'mailto:' . CL_EMAIL,
	],
];
?>
<footer class="site-footer">
	<div class="wrap site-footer__in">
		<div class="site-footer__brand">
			<?php echo cl_logo(); ?>
			<p>Tests that write and fix themselves. Built for teams who would rather ship than babysit a test suite.</p>
			<p class="site-status"><span class="dot dot--green mk-pulse"></span>All systems running</p>
		</div>
		<?php foreach ($cols as $title => $links) : ?>
			<nav class="site-footer__col" aria-label="<?php echo esc_attr($title); ?>">
				<p class="label-mono"><?php echo esc_html($title); ?></p>
				<ul>
					<?php foreach ($links as $label => $url) : ?>
						<li><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endforeach; ?>
	</div>
	<div class="site-footer__base">
		<div class="wrap">
			<p>© <?php echo esc_html(date('Y')); ?> <?php echo esc_html(CL_COMPANY); ?>. Claritia is a <?php echo esc_html(CL_COMPANY); ?> product.</p>
			<a href="mailto:<?php echo esc_attr(CL_EMAIL); ?>"><?php echo esc_html(CL_EMAIL); ?></a>
		</div>
	</div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
