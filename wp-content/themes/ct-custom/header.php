<?php $ct_custom_settings = ct_custom_get_theme_settings(); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'ct-custom' ); ?></a>

	<div class="top-bar">
		<div class="site-container top-bar-inner">
			<p class="header-phone">
				<?php if ( $ct_custom_settings['phone'] ) : ?>
					<span><?php esc_html_e( 'Call us now!', 'ct-custom' ); ?></span>
					<?php echo ct_custom_phone_link( $ct_custom_settings['phone'] ); ?>
				<?php endif; ?>
			</p>
			<?php if ( has_nav_menu( 'utility' ) ) : ?>
				<nav class="utility-navigation" aria-label="<?php esc_attr_e( 'Utility navigation', 'ct-custom' ); ?>">
					<?php wp_nav_menu( array( 'theme_location' => 'utility', 'container' => false, 'depth' => 1, 'fallback_cb' => false ) ); ?>
				</nav>
			<?php endif; ?>
		</div>
	</div>

	<header id="masthead" class="site-header">
		<div class="site-container header-inner">
			<div class="site-branding">
				<?php
				if ( $ct_custom_settings['logo_id'] && wp_attachment_is_image( $ct_custom_settings['logo_id'] ) ) :
					?>
					<a class="custom-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<?php echo wp_get_attachment_image( $ct_custom_settings['logo_id'], 'full', false, array( 'class' => 'custom-logo', 'alt' => get_bloginfo( 'name' ), 'loading' => false ) ); ?>
					</a>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				?>
				<p class="site-description screen-reader-text"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
			</div>

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'ct-custom' ); ?>">
				<button type="button" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'ct-custom' ); ?></button>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => false,
				) );
				?>
			</nav>
		</div>
	</header>

	<div id="content" class="site-content">