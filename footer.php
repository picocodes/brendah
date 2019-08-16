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
			<?php
				get_template_part( 'template-parts/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) :
					?>
					<nav class="social-navigation wrap" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'brendah' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . brendah_get_svg( array( 'icon' => 'chain' ) ),
								)
							);
						?>
					</nav><!-- .social-navigation -->
					<?php
				endif;

				
				?>

			<div class="site-info">
				<?php
					/**
					 * Fires before the footer copyright text is printed.
					 *
					 * @since Brendah 1.0
					 */
					do_action( 'brendah-credits' );

					get_template_part( 'template-parts/footer', 'info' );
				?>
				
				
			</div><!-- .site-info -->
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>
