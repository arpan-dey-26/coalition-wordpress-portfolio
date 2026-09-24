<?php
get_header();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header>
	<?php ct_custom_post_thumbnail(); ?>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<footer class="entry-footer"><?php ct_custom_entry_footer(); ?></footer>
</article>
<?php get_footer();