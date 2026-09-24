	</div>

	<?php if ( ! is_page_template( 'homepage.php' ) ) : ?>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'ct-custom' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'ct-custom' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'ct-custom' ), 'ct-custom', '<a href="https://coalitiontechnologies.com/">Coalition Technologies</a>' );
				?>
		</div>
	</footer>
	<?php endif; ?>
</div>

<?php wp_footer(); ?>

</body>
</html>