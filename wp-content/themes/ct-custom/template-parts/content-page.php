<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package CT_Custom
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<?php ct_custom_post_thumbnail(); ?>
	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ct-custom' ),
			'after'  => '</div>',
		) );
		?>
	</div>
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php edit_post_link( esc_html__( 'Edit', 'ct-custom' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
	<?php endif; ?>
</article>