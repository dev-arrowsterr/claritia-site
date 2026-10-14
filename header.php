<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php cl_head(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="screen-reader-text" href="#main">Skip to content</a>
<div class="page">
<?php
$nav = [
	'Product' => home_url('/#product'),
	'Agent' => home_url('/#agent'),
	'Developers' => home_url('/#developers'),
	'Security' => home_url('/#security'),
	'Pricing' => home_url('/#pricing'),
];
?>
<header class="site-header">
	<div class="wrap site-header__in">
		<a class="site-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Claritia home"><?php echo cl_logo(); ?></a>
		<nav class="site-nav" aria-label="Main">
			<?php foreach ($nav as $label => $url) : ?>
				<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
			<?php endforeach; ?>
		</nav>
		<div class="site-actions">
			<a class="site-signin" href="<?php echo esc_url(cl_app()); ?>">Sign in</a>
			<a class="btn btn--sm btn--ink" href="<?php echo esc_url(cl_app()); ?>">Start free<span class="btn__arrow" aria-hidden="true">→</span></a>
		</div>
	</div>
</header>
<main id="main">
