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

			$footer_copyright_text = get_theme_mod( 'copyright_text' );
            if( !empty( $footer_copyright_text ) ) {
               echo $footer_copyright_text;
            } else { ?>
                <a href="<?php echo esc_url( __( 'https://github.com/picocodes/', 'brendah' ) ); ?>" class="imprint">
					<?php printf( esc_html__( 'Theme Brendah By %s', 'brendah' ), 'Noptin' ); ?>
				</a>
		<?php } ?>
		
	</div>
	
