<?php
/**
 * Displays top navigation
 *
 * @since 1.0
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'brendah' ); ?>">
	<div class="mobile-top-header">
		<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
		<button  class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
			<?php get_template_part( 'template-parts/menu', 'svg' ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'brendah' ); ?></span>
		</button>
	</div>
	

	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'top',
			'container_id'   => 'brendah-top-menu',
		)
	);
	?>

</nav><!-- #site-navigation -->
