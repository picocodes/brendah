<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the .site-content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Brendah
 * @since 1.0.0
 */
?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<?php
					/**
					 * Fires before the footer copyright text is printed.
					 *
					 * @since Brendah 1.0
					 */
					do_action( 'brendah-credits' );
				?>
				
				<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'brendah' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'brendah' ), 'WordPress' ); ?></a>
			</div><!-- .site-info -->
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
