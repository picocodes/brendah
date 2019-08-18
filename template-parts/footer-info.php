<?php
/**
 * Displays footer site info
 *
 * @since 1.0
 * @version 1.0
 */

?>
	<div class="wrap">
		<?php
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span> / ');
			}
		?>
		<a href="<?php echo esc_url( __( 'https://github.com/picocodes/', 'brendah' ) ); ?>" class="imprint">
			<?php printf( esc_html__( 'Theme Brendah By %s', 'brendah' ), 'Noptin' ); ?>
		</a>
	</div>
	
