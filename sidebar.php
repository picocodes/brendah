<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package Brendah
 */
?>

<?php if ( (is_active_sidebar( 'sidebar-1' ) && get_theme_mod( 'sidebar', 'right-sidebar' ) !=  'no-sidebar') || is_customize_preview()) : ?>
	<aside id="secondary" class="sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
