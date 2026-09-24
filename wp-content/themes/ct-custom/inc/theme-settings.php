<?php

function ct_custom_get_theme_settings() {
	$settings = get_option( 'ct_custom_settings', array() );

	return wp_parse_args( is_array( $settings ) ? $settings : array(), array(
		'logo_id'   => 0,
		'phone'     => '',
		'address'   => '',
		'fax'       => '',
		'facebook'  => '',
		'twitter'   => '',
		'linkedin'  => '',
		'pinterest' => '',
	) );
}

function ct_custom_theme_settings_menu() {
	add_theme_page(
		__( 'Theme Settings', 'ct-custom' ),
		__( 'Theme Settings', 'ct-custom' ),
		'manage_options',
		'ct-custom-settings',
		'ct_custom_theme_settings_page'
	);
}
add_action( 'admin_menu', 'ct_custom_theme_settings_menu' );

function ct_custom_register_theme_settings() {
	register_setting( 'ct_custom_settings_group', 'ct_custom_settings', array(
		'type'              => 'array',
		'sanitize_callback' => 'ct_custom_sanitize_theme_settings',
		'default'           => array(),
	) );

	add_settings_section( 'ct_custom_contact', __( 'Logo and Contact Information', 'ct-custom' ), '__return_false', 'ct-custom-settings' );

	$fields = array(
		'logo_id'   => __( 'Logo', 'ct-custom' ),
		'phone'     => __( 'Phone Number', 'ct-custom' ),
		'address'   => __( 'Address Information', 'ct-custom' ),
		'fax'       => __( 'Fax Number', 'ct-custom' ),
		'facebook'  => __( 'Facebook URL', 'ct-custom' ),
		'twitter'   => __( 'Twitter URL', 'ct-custom' ),
		'linkedin'  => __( 'LinkedIn URL', 'ct-custom' ),
		'pinterest' => __( 'Pinterest URL', 'ct-custom' ),
	);

	foreach ( $fields as $key => $label ) {
		add_settings_field( 'ct_custom_' . $key, $label, 'ct_custom_theme_settings_field', 'ct-custom-settings', 'ct_custom_contact', array(
			'key'       => $key,
			'label_for' => 'logo_id' === $key ? 'ct-custom-logo-select' : 'ct-custom-' . $key,
		) );
	}
}
add_action( 'admin_init', 'ct_custom_register_theme_settings' );

function ct_custom_sanitize_theme_settings( $input ) {
	$previous = ct_custom_get_theme_settings();

	if ( ! is_array( $input ) ) {
		add_settings_error( 'ct_custom_settings', 'invalid_settings', __( 'Settings could not be saved. Please submit the settings form again.', 'ct-custom' ) );
		return $previous;
	}

	$settings = array();
	$logo_id  = isset( $input['logo_id'] ) ? $input['logo_id'] : 0;

	$valid_logo = ( is_int( $logo_id ) || is_string( $logo_id ) )
		&& ctype_digit( (string) $logo_id )
		&& ( 0 === (int) $logo_id || ( 'attachment' === get_post_type( (int) $logo_id ) && wp_attachment_is_image( (int) $logo_id ) ) );

	if ( $valid_logo ) {
		$settings['logo_id'] = (int) $logo_id;
	} else {
		$settings['logo_id'] = $previous['logo_id'];
		add_settings_error( 'ct_custom_settings', 'invalid_logo', __( 'Choose a valid image from the Media Library. The previous logo selection was kept.', 'ct-custom' ) );
	}

	foreach ( array( 'phone', 'fax', 'address' ) as $key ) {
		$value = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? $input[ $key ] : '';
		$settings[ $key ] = 'address' === $key ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
	}

	foreach ( array( 'facebook', 'twitter', 'linkedin', 'pinterest' ) as $key ) {
		$value = isset( $input[ $key ] ) && is_string( $input[ $key ] ) ? trim( $input[ $key ] ) : '';
		$url   = esc_url_raw( $value, array( 'http', 'https' ) );
		$parts = wp_parse_url( $value );

		$valid_url = $url && filter_var( $value, FILTER_VALIDATE_URL )
			&& isset( $parts['scheme'], $parts['host'] )
			&& in_array( strtolower( $parts['scheme'] ), array( 'http', 'https' ), true )
			&& ! isset( $parts['user'] ) && ! isset( $parts['pass'] );

		if ( '' === $value || $valid_url ) {
			$settings[ $key ] = $url;
		} else {
			$settings[ $key ] = $previous[ $key ];
			add_settings_error( 'ct_custom_settings', 'invalid_' . $key, sprintf(
				/* translators: %s: Social platform name. */
				__( '%s must be a full HTTP or HTTPS URL without login credentials. The previous value was kept.', 'ct-custom' ),
				ucfirst( $key )
			) );
		}
	}

	return $settings;
}

function ct_custom_theme_settings_field( $args ) {
	$settings = ct_custom_get_theme_settings();
	$key      = $args['key'];
	$value    = $settings[ $key ];
	$name     = 'ct_custom_settings[' . $key . ']';
	$id       = 'ct-custom-' . $key;

	if ( 'logo_id' === $key ) {
		?>
		<input type="hidden" id="ct-custom-logo-id" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<div id="ct-custom-logo-preview" aria-live="polite">
			<?php
			if ( $value && wp_attachment_is_image( $value ) ) {
				echo wp_get_attachment_image( $value, 'thumbnail', false, array( 'alt' => __( 'Selected logo', 'ct-custom' ) ) );
			}
			?>
		</div>
		<p>
			<button type="button" class="button" id="ct-custom-logo-select" aria-describedby="ct-custom-logo-description"><?php esc_html_e( 'Select or Upload Logo', 'ct-custom' ); ?></button>
			<button type="button" class="button" id="ct-custom-logo-remove" <?php disabled( ! $value ); ?>><?php esc_html_e( 'Remove Logo', 'ct-custom' ); ?></button>
		</p>
		<p class="description" id="ct-custom-logo-description"><?php esc_html_e( 'Choose the logo displayed in the site header, then save your changes.', 'ct-custom' ); ?></p>
		<?php
	} elseif ( 'address' === $key ) {
		?>
		<textarea class="large-text" rows="4" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
		<?php
	} else {
		$type = in_array( $key, array( 'phone', 'fax' ), true ) ? 'text' : 'url';
		?>
		<input class="regular-text" type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<?php
	}
}

function ct_custom_theme_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Theme Settings', 'ct-custom' ); ?></h1>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'ct_custom_settings_group' );
			do_settings_sections( 'ct-custom-settings' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

function ct_custom_theme_settings_scripts( $hook ) {
	if ( 'appearance_page_ct-custom-settings' !== $hook || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_script( 'ct-custom-theme-settings', get_template_directory_uri() . '/js/theme-settings.js', array( 'media-views', 'wp-a11y' ), filemtime( get_template_directory() . '/js/theme-settings.js' ), true );
	wp_localize_script( 'ct-custom-theme-settings', 'ctCustomSettings', array(
		'title'    => __( 'Select Logo', 'ct-custom' ),
		'button'   => __( 'Use This Logo', 'ct-custom' ),
		'alt'      => __( 'Selected logo', 'ct-custom' ),
		'selected' => __( 'Logo selected. Save Changes to keep this selection.', 'ct-custom' ),
		'removed'  => __( 'Logo removed. Save Changes to keep this change.', 'ct-custom' ),
	) );
}
add_action( 'admin_enqueue_scripts', 'ct_custom_theme_settings_scripts' );