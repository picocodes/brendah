<?php
/**
 * Customizer functionality
 *
 * @package Brendah
 * @subpackage Admin
 * @since Brendah 1.0
 */

/**
 * Sets up the WordPress core custom background features.
 *
 * @since Brendah 1.0
 *
 * @see brendah_header_style()
 */
function brendah_custom_background() {

	/**
	 * Filter the arguments used when adding 'custom-background' support in Brendah.
	 *
	 * @since Brendah 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'brendah_custom_background_args', array(
		'default-color' => '#006b72;',
	) ) );

}
add_action( 'after_setup_theme', 'brendah_custom_background' );

if ( ! function_exists( 'brendah_header_style' ) ) :
/**
 * Styles the header text displayed on the site.
 *
 * Create your own brendah_header_style() function to override in a child theme.
 *
 * @since Brendah 1.0
 *
 * @see brendah_custom_header_and_background().
 */
function brendah_header_style() {
	// If the header text option is untouched, let's bail.
	if ( display_header_text() ) {
		return;
	}

	// If the header text has been hidden.
	?>
	<style type="text/css" id="brendah-header-css">
		.site-branding {
			margin: 0 auto 0 0;
		}

		.site-branding .site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	</style>
	<?php
}
endif; // brendah_header_style

/**
 * Adds postMessage support for site title and description for the Customizer.
 *
 * @since Brendah 1.0
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function brendah_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	
	// Sidebar Position
	$wp_customize->add_section( 'layout', array(
		'title'           => __( 'Layout', 'brendah' ),
	) );
	
	$wp_customize->add_setting( 'sidebar', array(
		'default'           => 'right-sidebar',
		'sanitize_callback' => 'brendah_sanitize_sidebar',
		'transport'         => 'postMessage',
	) );
	
	$wp_customize->add_control( 'sidebar', array(
		'label'    => __( 'Base Color Scheme', 'brendah' ),
		'section'  => 'layout',
		'type'     => 'select',
		'choices'  => apply_filters( 'brendah_sidebar_choices', array(
			'right-sidebar'     => __( 'Right Sidebar', 'brendah' ),
			'left-sidebar'     => __( 'Left Sidebar', 'brendah' ),
			'no-sidebar'     => __( 'No Sidebar', 'brendah' ),
		)),
		'priority' => 1,
	) );
	
	
	// Colors
	$wp_customize->add_setting( 'primary_color', array(
		'default'           => '#006b72',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
		'label'       => __( 'Primay Color', 'brendah' ),
		'section'     => 'colors',
	) ) );
	
	$wp_customize->add_setting( 'secondary_color', array(
		'default'           => '#04a5a5',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
		'label'       => __( 'Secondary Color', 'brendah' ),
		'section'     => 'colors',
	) ) );

}
add_action( 'customize_register', 'brendah_customize_register', 11 );

/**
 * Binds the JS listener to make Customizer color_css control.
 *
 * Passes color css data as colorCss global.
 *
 * @since Brendah 1.0
 */
function brendah_customize_control_js() {
	wp_enqueue_script( 'color-scheme-control', get_template_directory_uri() . '/js/color-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20160412', true );
}
add_action( 'customize_controls_enqueue_scripts', 'brendah_customize_control_js' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Brendah 1.0
 */
function brendah_customize_preview_js() {
	wp_enqueue_script( 'brendah-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20160412', true );
}
add_action( 'customize_preview_init', 'brendah_customize_preview_js', 20 );

/**
 * Sanitizes Sidebar choice
 *
 * @since Brendah 1.0
 *
 * @param string $value choice
 * @return string Choice
 */
function brendah_sanitize_sidebar( $value ) {
	$choices = apply_filters( 'brendah_sidebar_choices', array(
			'right-sidebar'     => __( 'Right Sidebar', 'brendah' ),
			'left-sidebar'     => __( 'Left Sidebar', 'brendah' ),
			'no-sidebar'     => __( 'No Sidebar', 'brendah' ),
		));

	if ( ! array_key_exists( $value, $choices ) ) {
		return 'right-sidebar';
	}

	return $value;
}

/* Returns primary color css */
function brendah_get_primary_color_css( $color ) {
	$css = '
		/* Backgrounds */
		.woocommerce #respond input#submit, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button,
		button,
		html input[type="button"],
		input[type="reset"],
		input[type="submit"]		{
			background-color: %1$s;
		}
		
		.search-submit:hover {
			background:  %1$s !important;
		}
		
		/* Colors */
		
		a,
		button:hover,
		html input[type="button"]:hover,
		input[type="reset"]:hover,
		input[type="submit"]:hover {
			color: %1$s;
		}
		
		/* Borders */
		button,
		html input[type="button"],
		input[type="reset"],
		input[type="submit"],
		.author-info,
		.gallery-item:hover,
		.widget		{
			border-color: %1$s;
		}
	';
	
	return sprintf( $css, $color);
}


/* Returns secondary color css */
function brendah_get_secondary_color_css( $color ) {
	$css = '	
		.woocommerce #respond input#submit:hover, 
		.woocommerce a.button:hover, 
		.woocommerce button.button:hover, 
		.woocommerce input.button:hover {
			background-color: %1$s;
		}
		
		/* Colors */
		a:visited,
		a:hover,
		a:active {
			color: %1$s;
		}
	';
	
	return sprintf( $css, $color);
}

/**
 * Outputs an Underscore template for generating CSS for the chosen colors
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 *
 * @since Brendah 1.0
 */
function brendah_color_scheme_css_template() {
	?>
	
	<script type="text/html" id="tmpl-brendah-colors">
		<?php echo brendah_get_primary_color_css( '{{ data.primary_color }}' ); ?>
		<?php echo brendah_get_secondary_color_css( '{{ data.secondary_color }}' ); ?>
	</script>
	
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'brendah_color_scheme_css_template' );

/**
 * Enqueues front-end CSS for base color
 *
 * @since Brendah 1.0
 *
 */
function brendah_primary_color_css() {
	$primary_color = get_theme_mod( 'primary_color', '#006b72' );
	
	wp_add_inline_style( 'brendah-style', brendah_get_primary_color_css( $primary_color ) );
}
add_action( 'wp_enqueue_scripts', 'brendah_primary_color_css' );

/**
 * Enqueues front-end CSS for secondary color
 *
 * @since Brendah 1.0
 *
 */
function brendah_secondary_color_css() {
	$secondary_color = get_theme_mod( 'secondary_color', '#04a5a5' );
	
	wp_add_inline_style( 'brendah-style', brendah_get_secondary_color_css( $secondary_color ) );
}
add_action( 'wp_enqueue_scripts', 'brendah_secondary_color_css' );