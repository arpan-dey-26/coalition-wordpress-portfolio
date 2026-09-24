<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package CT_Custom
 */

function ct_custom_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ct_custom_woocommerce_setup' );

function ct_custom_woocommerce_scripts() {
	wp_enqueue_style( 'ct-custom-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'ct-custom-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'ct_custom_woocommerce_scripts' );

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function ct_custom_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';
	return $classes;
}
add_filter( 'body_class', 'ct_custom_woocommerce_active_body_class' );

function ct_custom_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'ct_custom_woocommerce_products_per_page' );

function ct_custom_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'ct_custom_woocommerce_thumbnail_columns' );

function ct_custom_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'ct_custom_woocommerce_loop_columns' );

function ct_custom_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);
	return wp_parse_args( $defaults, $args );
}
add_filter( 'woocommerce_output_related_products_args', 'ct_custom_woocommerce_related_products_args' );

function ct_custom_woocommerce_product_columns_wrapper() {
	$columns = ct_custom_woocommerce_loop_columns();
	echo '<div class="columns-' . absint( $columns ) . '">';
}
add_action( 'woocommerce_before_shop_loop', 'ct_custom_woocommerce_product_columns_wrapper', 40 );

function ct_custom_woocommerce_product_columns_wrapper_close() {
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop', 'ct_custom_woocommerce_product_columns_wrapper_close', 40 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function ct_custom_woocommerce_wrapper_before() {
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
}
add_action( 'woocommerce_before_main_content', 'ct_custom_woocommerce_wrapper_before' );

function ct_custom_woocommerce_wrapper_after() {
	?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
}
add_action( 'woocommerce_after_main_content', 'ct_custom_woocommerce_wrapper_after' );