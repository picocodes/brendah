<?php
/**
 * Brendah functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Brendah
 * @since Brendah 1.0.0
 */
 
if ( ! function_exists( 'brendah_setup' ) ) :
 
/**
 * Registers support for various Theme features.
 *
 * Create a function called brendah_setup() in your child theme to overide this.
 *
 * @since 1.0.0
 *
 * @return void
 */
 
 function brendah_setup() {
	 
	//Make the theme available for translation
	load_theme_textdomain( 'brendah', get_template_directory() . '/languages' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	
	// Tells WordPress that this theme does not explitely define a title tag
	add_theme_support( 'title-tag' );
	
	//This theme is html5 compliant
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 */	 
	add_theme_support( 'post-thumbnails' );
	
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'editor-style.css') );
	
	/*
	 * This theme is WooCommerce compatible
	 *
	 * See: https://wordpress.org/plugins/woocommerce
	 */
	add_theme_support( 'woocommerce' );
	
	/*
	 * This theme is compatible with ajax live search
	 *
	 * See: https://wordpress.org/plugins/ajax-live-search
	 */
	add_theme_support( 'ajax-live-search' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		array(
			'top'    => __( 'Top Menu', 'brendah' ),
		)
	);
 }
 
endif; // brendah_setup
add_action( 'after_setup_theme', 'brendah_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function brendah_content_width() {

	$content_width = 700;

	/**
	 * Filter Brendah content width of the theme.
	 *
	 * @since Brendah 1.0.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'brendah_content_width', $content_width );
}
add_action( 'after_setup_theme', 'brendah_content_width', 0 );


/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Brendah 1.0.0
 */
function brendah_widgets_init() {
	
	//Main sidebar that appears to the rigt/left of the content area
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'brendah' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'brendah' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer', 'brendah' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer area.', 'brendah' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	//WC sidebars
	if ( class_exists( 'WooCommerce' ) ) {
		$sidebars = array( 'account', 'checkout', 'cart', 'product', 'shop');

		foreach( $sidebars as $sidebar ){
			register_sidebar( array(
				'name'          => ucwords("$sidebar"),
				'id'            => $sidebar,
				'description'   => sprintf( __( 'Add widgets here to appear in your WooCommerce %s page sidebar.', 'brendah' ), $sidebar),
				'before_widget' => '<section id="%1$s" class="widget woocommerce-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
		}
	}

}
add_action( 'widgets_init', 'brendah_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Brendah 1.0.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function brendah_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'brendah' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'brendah_excerpt_more' );


/**
 * Enques stylesheets and script files.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Brendah 1.0.0
 */
function brendah_scripts() {

	//Google fonts
	wp_enqueue_style( 'brendah-fonts', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap' );

    // Main theme stylesheet.
	wp_enqueue_style( 'brendah-style', get_stylesheet_uri() );
	
	// Load the html5 shiv.
	wp_enqueue_script( 'brendah-html5', get_template_directory_uri() . '/js/html5.min.js', array(), '3.7.3' );
	wp_script_add_data( 'brendah-html5', 'conditional', 'lt IE 9' );
	
	/*
	 * Main theme javascript file
	 * Contains the skip link focus fix; etc
	 */
	wp_enqueue_script( 'brendah-script', get_template_directory_uri() . '/js/brendah.js', array('jquery'), '1.0.5', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'brendah_scripts' );

if ( ! function_exists( 'brendah_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 */
function brendah_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'brendah_entry_meta' ) ) :
/**
 * Prints HTML with meta information for author, date etc.
 *
 */
function brendah_entry_meta() {
	
	//Display author information on posts only
	if ( 'post' === get_post_type() ) {
		
		$author_avatar_size = apply_filters( 'brendah_author_avatar_size', 36 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'brendah' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
		
	}
	
	//The date
	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		brendah_entry_date();
	}

	
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo ' | <span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'brendah' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'brendah_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own brendah_entry_date() function to override in a child theme.
 *
 * @since Brendah 1.0
 */
function brendah_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published screen-reader-text" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( ' | <span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'brendah' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

/**
 * Adds custom classes to the array of body classes.
 *
 */
function brendah_body_classes( $classes ) {
	
	// Adds a class of no-sidebar to sites without active sidebar or the chosen sidebar position.
	if ( ! is_active_sidebar( brendah_get_sidebar() )) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = get_theme_mod( 'sidebar', 'right-sidebar' );
	}
	
	return $classes;
}
add_filter( 'body_class', 'brendah_body_classes' );

/**
 * Checks the sidebar for a page
 *
 */
function brendah_get_sidebar() {

	$sidebar = 'sidebar-1';
	if ( class_exists( 'WooCommerce' ) ) {

		if ( is_account_page() ) {
			$sidebar= 'account';
		}
		
		if ( is_checkout() ) {
			$sidebar= 'checkout';
		}
		
		if ( is_cart() ) {
			$sidebar= 'cart';
		}
		
		if ( is_product() ) {
			$sidebar= 'product';
		}
		
		if ( is_shop() || is_product_category() ) {
			$sidebar= 'shop';
		}

	}
	return $sidebar;

}

/**
 * Filters the ajax live search template file
 *
 */
function brendah_ajax_live_search_template( $template ) {
		
	return '/template-parts/content-search.php';
	
}
add_filter( 'ajax-live-search-template', 'brendah_ajax_live_search_template' );

/**
 * Add woocommerce support
 *
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper',10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end',10);
add_action('woocommerce_before_main_content', 'brendah_woocommerce_output_content_wrapper', 10);
add_action('woocommerce_after_main_content', 'brendah_woocommerce_output_content_wrapper_end', 10);

function brendah_woocommerce_output_content_wrapper() {
	?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
	<?php
}

function brendah_woocommerce_output_content_wrapper_end() {
	?>
	</main><!-- .site-main -->
</div><!-- .content-area -->
	<?php
}

add_action( 'comment_post', 'brendah_ajax_comments', 20, 2 );
/**
 * Provide responses to comments.js based on detecting an XMLHttpRequest parameter.
 *
 * @param $comment_ID     ID of new comment.
 * @param $comment_status Status of new comment. 
 *
 * @return echo JSON encoded responses with HTML structured comment, success, and status notice.
 */
function brendah_ajax_comments( $comment_ID, $comment_status ) {
	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		// This is an AJAX request. Handle response data. 
		switch ( $comment_status ) {
			case '0':
				// Comment needs moderation; notify comment moderator.
				wp_notify_moderator( $comment_ID );
				$return = array( 
					'response' => '', 
					'success'  => 1, 
					'status'   => __( 'Your comment has been sent for moderation. It should be approved soon!', 'brendah' ) 
				);
				wp_send_json( $return );
				break;
			case '1':
				// Approved comment; generate comment output and notify post author.
				$comment            = get_comment( $comment_ID );
				$comment_class      = comment_class( 'brendah-ajax-comment', $comment_ID, $comment->comment_post_ID, false );
				
				$comment_output     = '
						<li id="comment-' . $comment->comment_ID . '"' . $comment_class . ' tabindex="-1">
							<article id="div-comment-' . $comment->comment_ID . '" class="comment-body">
								<footer class="comment-meta">
									<div class="comment-author vcard">'.
										get_avatar( $comment->comment_author_email )
										.'<b class="fn">' . __( 'You said:', 'brendah' ) . '</b> 
									</div>

									<div class="comment-meta comment-metadata"><a href="#comment-'. $comment->comment_ID .'">' . 
										get_comment_date( 'F j, Y \a\t g:i a', $comment->comment_ID ) .'</a>
									</div>
								</footer>
								
								<div class="comment-content">' . $comment->comment_content . '</div>
								<div class="reply">' .get_comment_reply_link(array(), $comment->comment_ID, $comment->comment_post_ID) . '</div>
							</article>
						</li>';
				
				if ( $comment->comment_parent == 0 ) {
					$output = $comment_output;
				} else {
					$output = "<ul class='children'>$comment_output</ul>";
				}

				wp_notify_postauthor( $comment_ID );
				$return = array( 
					'response'=>$output , 
					'success' => 1, 
					'status'=> sprintf( __( 'Thanks for commenting! Your comment has been approved. <a href="%s">Read your comment</a>', 'brendah' ), "#comment-$comment_ID" ) 
				);
				wp_send_json( $return );
				break;
			default:
				// The comment status was not a valid value. Only 0 or 1 should be returned by the comment_post action.
				$return = array( 
					'response' => '', 
					'success'  => 0, 
					'status'   => __( 'There was an error posting your comment. Try again later!', 'brendah' ) 
				);
				wp_send_json( $return );
		}
	}
}

/**
 * Register the recommended plugins for this theme.
 *
 */
function brendah_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name'      => 'Noptin &mdash; Newsletter Subscribe Forms And Widgets',
			'slug'      => 'newsletter-optin-box',
			'required'  => false,
		),


	);

	/*
	 * Array of configuration settings.
	 */
	$config = array(
		'id'           => 'brendah',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'brendah_register_required_plugins' );


//tgmpa
require_once('inc/class-tgm-plugin-activation.php');

//Customizer settings
require_once('inc/customizer.php');

//Welcome page
require_once('inc/admin.php');