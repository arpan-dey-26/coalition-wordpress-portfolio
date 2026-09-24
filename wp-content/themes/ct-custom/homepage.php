<?php
/* Template Name: Homepage */

get_header();
?>

<div id="primary" class="content-area site-container contact-page">
	<main id="main" class="site-main" tabindex="-1">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'ct-custom' ); ?>">
				<?php if ( is_front_page() ) : ?>
					<span aria-current="page"><?php esc_html_e( 'Home', 'ct-custom' ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'ct-custom' ); ?></a>
					<?php foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ct_custom_parent ) : ?>
						<span aria-hidden="true">/</span>
						<a href="<?php echo esc_url( get_permalink( $ct_custom_parent ) ); ?>"><?php echo esc_html( get_the_title( $ct_custom_parent ) ); ?></a>
					<?php endforeach; ?>
					<span aria-hidden="true">/</span>
					<span aria-current="page"><?php echo esc_html( get_the_title() ); ?></span>
				<?php endif; ?>
			</nav>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'contact-content' ); ?>>
				<?php the_content(); ?>
			</article>
			<?php
		endwhile;
		?>
	</main>
</div>

<?php
get_footer();