<?php while (have_posts()) : the_post(); ?>
<article class="post">
	<header class="post__head wrap">
		<h1 class="post__title"><?php the_title(); ?></h1>
	</header>
	<div class="prose wrap"><?php the_content(); ?></div>
</article>
<?php endwhile;
