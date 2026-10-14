<?php get_header(); ?>
<section class="blank">
	<div class="dot-grid" aria-hidden="true"></div>
	<div class="wrap blank__in">
		<p class="fig">// 404</p>
		<h1 class="blank__title">This page moved or never existed.</h1>
		<div class="blank__ctas">
			<a class="btn btn--lg btn--ink" href="<?php echo esc_url(home_url('/')); ?>">Go home</a>
			<a class="btn btn--lg btn--line" href="<?php echo esc_url(cl_app()); ?>">Open the app</a>
		</div>
	</div>
</section>
<?php get_footer();
