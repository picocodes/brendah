<?php
/**
 * The template for displaying sidebars on woocommerce pages
 *
 * @package Brendah
 */

$sidebar = brendah_get_sidebar();

?>

<?php if ( (is_active_sidebar( $sidebar ) && get_theme_mod( 'sidebar', 'right-sidebar' ) !=  'no-sidebar') || is_customize_preview()) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( $sidebar ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
