<?php while (have_posts()) : the_post(); ?>
<article class="post">
	<header class="post__head wrap">
		<p class="fig">// <?php echo esc_html(get_the_date('F j, Y')); ?> · <?php echo esc_html(max(1, (int) round(str_word_count(wp_strip_all_tags(get_the_content())) / 230))); ?> min read</p>
		<h1 class="post__title"><?php the_title(); ?></h1>
	</header>
	<?php if (has_post_thumbnail()) : ?>
		<figure class="post__cover wrap"><?php the_post_thumbnail('full'); ?></figure>
	<?php endif; ?>
	<div class="prose wrap"><?php the_content(); ?></div>
	<aside class="post-cta wrap">
		<div class="post-cta__in">
			<div>
				<h2 class="post-cta__title">Stop fixing tests. Start shipping.</h2>
				<p>Write your first test in plain English and watch it run in the next five minutes.</p>
			</div>
			<a class="btn btn--lg btn--white" href="<?php echo esc_url(cl_app()); ?>">Start free</a>
		</div>
	</aside>
</article>
<?php endwhile;
