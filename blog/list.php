<?php
$title = is_search() ? sprintf('Results for “%s”', get_search_query()) : (is_archive() ? get_the_archive_title() : 'Blog');
?>
<section class="blog-head">
	<div class="wrap">
		<p class="fig">// <?php echo is_search() ? 'Search' : 'Blog'; ?></p>
		<h1 class="blog-head__title"><?php echo esc_html(wp_strip_all_tags($title)); ?></h1>
	</div>
</section>
<section class="blog-list">
	<div class="wrap">
		<?php if (have_posts()) : ?>
			<div class="post-grid">
				<?php while (have_posts()) : the_post(); ?>
					<a class="post-card" href="<?php the_permalink(); ?>">
						<?php if (has_post_thumbnail()) : ?>
							<div class="post-card__img"><?php the_post_thumbnail('large', ['loading' => 'lazy']); ?></div>
						<?php endif; ?>
						<div class="post-card__body">
							<span class="post-card__date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
							<h2 class="post-card__title"><?php the_title(); ?></h2>
							<p class="post-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
			<nav class="pager"><?php the_posts_pagination(['mid_size' => 1, 'prev_text' => 'Newer', 'next_text' => 'Older']); ?></nav>
		<?php else : ?>
			<p class="blog-empty">Nothing here yet.</p>
		<?php endif; ?>
	</div>
</section>
