<?php
function ct_custom_phone_link( $phone ) {
	$number = preg_replace( '/[^0-9+]/', '', $phone );
	if ( ! preg_match( '/^\+?[0-9]+$/', $number ) ) {
		return esc_html( $phone );
	}
	return '<a href="' . esc_url( 'tel:' . $number ) . '">' . esc_html( $phone ) . '</a>';
}

function ct_custom_contact_details() {
	$settings = ct_custom_get_theme_settings();
	$platforms = array( 'facebook' => 'Facebook', 'twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'pinterest' => 'Pinterest' );
	ob_start();
	?>
	<div class="contact-details">
		<?php if ( $settings['address'] ) : ?><address><?php echo nl2br( esc_html( $settings['address'] ) ); ?></address><?php endif; ?>
		<?php if ( $settings['phone'] || $settings['fax'] ) : ?>
			<p class="contact-numbers">
				<?php if ( $settings['phone'] ) : ?><span><?php esc_html_e( 'Phone:', 'ct-custom' ); ?> <?php echo ct_custom_phone_link( $settings['phone'] ); ?></span><?php endif; ?>
				<?php if ( $settings['fax'] ) : ?><span><?php esc_html_e( 'Fax:', 'ct-custom' ); ?> <?php echo esc_html( $settings['fax'] ); ?></span><?php endif; ?>
			</p>
		<?php endif; ?>
		<?php if ( array_filter( array_intersect_key( $settings, $platforms ) ) ) : ?>
			<ul class="social-links" aria-label="<?php esc_attr_e( 'Social media', 'ct-custom' ); ?>">
				<?php foreach ( $platforms as $key => $label ) : if ( $settings[ $key ] ) : ?>
					<li><a href="<?php echo esc_url( $settings[ $key ], array( 'http', 'https' ) ); ?>" aria-label="<?php echo esc_attr( $label ); ?>"><svg width="20" height="20" aria-hidden="true" focusable="false"><use href="<?php echo esc_url( get_template_directory_uri() . '/images/social.svg#' . $key ); ?>"></use></svg></a></li>
				<?php endif; endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ct_contact_details', 'ct_custom_contact_details' );

function ct_custom_contact_form( $attributes ) {
	$attributes = shortcode_atts( array( 'id' => '' ), $attributes, 'ct_contact_form' );
	$form_id = sanitize_text_field( $attributes['id'] );
	if ( $form_id && shortcode_exists( 'contact-form-7' ) && preg_match( '/^[a-zA-Z0-9_-]+$/', $form_id ) ) {
		return '<div class="contact-form">' . do_shortcode( '[contact-form-7 id="' . $form_id . '"]' ) . '</div>';
	}
	return '<div class="contact-form" role="group" aria-label="' . esc_attr__( 'Contact form preview', 'ct-custom' ) . '"><fieldset disabled><input type="text" placeholder="' . esc_attr__( 'Name *', 'ct-custom' ) . '"><input type="tel" placeholder="' . esc_attr__( 'Phone *', 'ct-custom' ) . '"><input type="email" placeholder="' . esc_attr__( 'Email *', 'ct-custom' ) . '"><textarea placeholder="' . esc_attr__( 'Message *', 'ct-custom' ) . '"></textarea><button type="button" disabled>' . esc_html__( 'Submit', 'ct-custom' ) . '</button></fieldset><p class="form-status">' . esc_html__( 'This form is currently unavailable. Please use the contact details provided.', 'ct-custom' ) . '</p></div>';
}
add_shortcode( 'ct_contact_form', 'ct_custom_contact_form' );

function ct_custom_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf( $time_string, esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ), esc_attr( get_the_modified_date( DATE_W3C ) ), esc_html( get_the_modified_date() ) );
	echo '<span class="posted-on">' . sprintf( esc_html_x( 'Posted on %s', 'post date', 'ct-custom' ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' ) . '</span>';
}
function ct_custom_posted_by() {
	echo '<span class="byline">' . sprintf( esc_html_x( 'by %s', 'post author', 'ct-custom' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>' ) . '</span>';
}
function ct_custom_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$categories_list = get_the_category_list( esc_html__( ', ', 'ct-custom' ) );
		if ( $categories_list ) printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ct-custom' ) . '</span>', $categories_list );
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'ct-custom' ) );
		if ( $tags_list ) printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ct-custom' ) . '</span>', $tags_list );
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a Comment', 'ct-custom' ) );
		echo '</span>';
	}
	edit_post_link( esc_html__( 'Edit', 'ct-custom' ), '<span class="edit-link">', '</span>' );
}
function ct_custom_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) return;
	if ( is_singular() ) : ?>
		<div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
	<?php else : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?></a>
	<?php endif;
}