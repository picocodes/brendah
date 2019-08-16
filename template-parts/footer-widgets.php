<?php
/**
 * Displays footer widgets if assigned
 *
 * @since 1.0
 * @version 1.0
 */

?>

<?php
if ( is_active_sidebar( 'sidebar-2' ) )  : ?>

	<aside class="footer-widget-area wrap" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'brendah' ); ?>">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</aside><!-- .widget-area -->

<?php endif; ?>
