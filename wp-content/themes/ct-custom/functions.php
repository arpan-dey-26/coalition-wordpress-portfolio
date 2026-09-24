<?php

if ( ! function_exists( 'ct_custom_setup' ) ) :
	function ct_custom_setup() {
		load_theme_textdomain( 'ct-custom', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ct-custom' ),
			'utility' => esc_html__( 'Utility', 'ct-custom' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		add_theme_support( 'custom-background', apply_filters( 'ct_custom_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ct_custom_setup' );

function ct_custom_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ct_custom_content_width', 640 );
}
add_action( 'after_setup_theme', 'ct_custom_content_width', 0 );

function ct_custom_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ct-custom' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ct-custom' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ct_custom_widgets_init' );

function ct_custom_scripts() {
	wp_enqueue_style( 'ct-custom-style', get_stylesheet_uri(), array(), filemtime( get_template_directory() . '/style.css' ) );

	wp_enqueue_script( 'ct-custom-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime( get_template_directory() . '/js/navigation.js' ), true );
	wp_localize_script( 'ct-custom-navigation', 'ctCustomNavigation', array(
		'submenu' => __( 'Toggle submenu for', 'ct-custom' ),
	) );

	wp_enqueue_script( 'ct-custom-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_custom_scripts' );

function ct_custom_contact_pattern() {
	register_block_pattern( 'ct-custom/contact-homepage', array(
		'title'      => __( 'Contact homepage', 'ct-custom' ),
		'categories' => array( 'pages' ),
		'content'    => '<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">' . esc_html__( 'Contact', 'ct-custom' ) . '</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"contact-intro"} -->
<p class="contact-intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam posuere ipsum nec velit mattis elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas eu placerat metus, eget placerat libero.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"contact-columns"} -->
<div class="wp-block-group contact-columns">
<!-- wp:group {"tagName":"section","className":"contact-form-column"} -->
<section class="wp-block-group contact-form-column">
<!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'Contact us', 'ct-custom' ) . '</h2>
<!-- /wp:heading -->
<!-- wp:shortcode -->[ct_contact_form]<!-- /wp:shortcode -->
</section>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","className":"contact-details-column"} -->
<section class="wp-block-group contact-details-column">
<!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'Reach us', 'ct-custom' ) . '</h2>
<!-- /wp:heading -->
<!-- wp:shortcode -->[ct_contact_details]<!-- /wp:shortcode -->
</section>
<!-- /wp:group -->
</div>
<!-- /wp:group -->',
	) );
}
add_action( 'init', 'ct_custom_contact_pattern' );

require get_template_directory() . '/inc/custom-header.php';

require get_template_directory() . '/inc/template-tags.php';

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';

require get_template_directory() . '/inc/theme-settings.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}