<?php
/**
 * The admin class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Brendah_Admin' ) ) :
	/**
	 * The Brendah admin class
	 */
	class Brendah_Admin {
		
		public $boards = array();
		
		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_menu', 				array( $this, 'welcome_register_menu' ) );
			add_action( 'load-themes.php',			array( $this, 'activation_admin_notice' ) );
			add_action( 'admin_enqueue_scripts', 	array( $this, 'welcome_style' ) );
			
			//Admin Boards . The picocodes filter is intentional for compatibility with other
			//picocodes plugins and themes			
			$theme = wp_get_theme(); 
			add_filter( 'picocodes_admin_boards', array( $this, 'picocodes_admin_boards' ), $theme->get( 'Name' ) );
			
			$this->boards = apply_filters('picocodes_admin_boards', array(), 'brendah');
			
			//Hook into the brendah welcome action
			add_action( 'brendah_welcome', 		array( $this, 'welcome_css' ), 			10 );
			add_action( 'brendah_welcome', 		array( $this, 'welcome_intro' ), 			20 );
			add_action( 'brendah_welcome', 		array( $this, 'welcome_boards' ), 		30 );
			add_action( 'brendah_welcome', 		array( $this, 'welcome_js' ), 		40 );
		}

		/**
		 * Adds an admin notice upon successful activation.
		 *
		 * @since 1.0.3
		 */
		public function activation_admin_notice() {
			global $pagenow;

			if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) { // Input var okay.
				add_action( 'admin_notices', array( $this, 'brendah_welcome_admin_notice' ), 99 );
			}
		}

		/**
		 * Display an admin notice linking to the welcome screen
		 *
		 * @since 1.0.3
		 */
		public function brendah_welcome_admin_notice() {
			?>
				<div class="updated notice is-dismissible">
					<p><?php echo sprintf( esc_html__( 'Thanks for choosing Brendah! You can read hints and tips on how get the most out of your new theme on the %swelcome screen%s.', 'brendah' ), '<a href="' . esc_url( admin_url( 'themes.php?page=brendah-welcome' ) ) . '">', '</a>' ); ?></p>
					<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=brendah-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php esc_attr_e( 'Get started with Brendah', 'brendah' ); ?></a></p>
				</div>
			<?php
		}

		/**
		 * Load welcome screen css
		 *
		 * @param string $hook_suffix the current page hook suffix.
		 * @return void
		 * @since  1.4.4
		 */
		public function welcome_style( $hook_suffix ) {
			global $brendah_version;

			if ( 'appearance_page_brendah-welcome' == $hook_suffix ) {
				wp_enqueue_script( 'masonry' );
			}
		}

		/**
		 * Creates the dashboard page
		 *
		 * @see  add_theme_page()
		 * @since 1.0.0
		 */
		public function welcome_register_menu() {
			add_theme_page( 'Brendah', 'Brendah', 'activate_plugins', 'brendah-welcome', array( $this, 'brendah_welcome_screen' ) );
		}

		/**
		 * The welcome screen
		 *
		 * @since 1.0.0
		 */
		public function brendah_welcome_screen() {
			require_once( ABSPATH . 'wp-load.php' );
			require_once( ABSPATH . 'wp-admin/admin.php' );
			require_once( ABSPATH . 'wp-admin/admin-header.php' );
			?>
			<div class="wrap about-wrap">

				<?php
				/**
				 * Fires when rendering the welcome page
				 *
				 */
				do_action( 'brendah_welcome' ); ?>

			</div>
			
			<?php
		}

		/**
		 * Welcome screen intro
		 *
		 * @since 1.0.0
		 */
		public function welcome_intro() {
			require_once( get_template_directory() . '/inc/welcome-screen/component-intro.php' );
		}


		/**
		 * Welcome screen boards
		 *
		 * @since 1.0.0
		 */
		public function welcome_boards() {
			$boards = $this->boards;
			include( get_template_directory() . '/inc/welcome-screen/component-boards.php' );
		}
		
		/**
		 * Welcome screen js section
		 *
		 * @since 1.0.0
		 */
		public function welcome_js() {
			require_once( get_template_directory() . '/inc/welcome-screen/component-js.php' );
		}
		
		/**
		 * Welcome screen css section
		 *
		 * @since 1.0.0
		 */
		public function welcome_css() {
			require_once( get_template_directory() . '/inc/welcome-screen/component-css.php' );
		}
		
		/**
		 * Returns an install woocommerce link
		 *
		 * @since 1.0.0
		 */
		public function get_woocommerce_link() {
			
			if ( class_exists( 'WooCommerce' ) )
				return '<p class="brendah-activated">' . esc_html__( 'WooCommerce is activated', 'brendah' ) . '</p>';
			
			$url = esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' ) );
			$msg = esc_html__( 'Install', 'brendah' );
			
			return "<a href='$url' class='button button-primary'>$msg</a>";
		}
		
		/**
		 * Returns an install als link
		 *
		 * @since 1.0.0
		 */
		public function get_als_link() {
			
			if ( class_exists( 'alsSearch' ) )
				return '<p class="brendah-activated">' . esc_html__( 'Ajax Live Search is activated', 'brendah' ) . '</p>';
			
			$url = esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=ajax-live-search' ), 'install-plugin_ajax-live-search' ) );
			$msg = esc_html__( 'Install', 'brendah' );
			
			$url2 = esc_url( 'https://ajaxlivesearch.xyz' );
			$msg2 = esc_html__( 'Learn More!', 'brendah' );
			
			return "<a href='$url' class='button button-primary'>$msg</a> <a href='$url2' class='button button-primary'>$msg2</a>";
		}
		
		/**
		 * Returns a donate als link
		 *
		 * @since 1.0.0
		 */
		public function get_donate_link() {
			
			if ( defined( 'ALS_IS_PRO') )
				return '<p class="brendah-activated">' . esc_html__( 'Ojoo! You are already using the premium version of Ajax Live Search.', 'brendah' ) . '</p>';
						
			$url = esc_url( 'https://ajaxlivesearch.xyz/download/#buy' );
			$msg = esc_html__( 'Get It!', 'brendah' );
			
			return "<a href='$url' class='button button-primary'>$msg</a>";
		}
		
		/**
		 * Returns a link to the customizer
		 *
		 * @since 1.0.0
		 */
		public function get_customizer_link() {
			
			//Sets the return url
			$return = self_admin_url( 'themes.php?page=brendah-welcome' );
			
			//customizer url
			$url = esc_url( self_admin_url( "customize.php?return=$return" ) );
			
			$msg = esc_html__( 'Customize', 'brendah' );
			
			return "<a href='$url' class='button button-primary'>$msg</a>";
		}
		
		/**
		 * Returns a link to the customizer
		 *
		 * @since 1.0.0
		 */
		public function get_contribute_link() {
			
			//Sets the return url
			$return = self_admin_url( 'themes.php?page=brendah-welcome' );
			
			//customizer url
			$url = esc_url( 'https://translate.wordpress.org/projects/wp-themes/brendah' );
			
			$msg = esc_html__( 'Translate ', 'brendah' );
			
			$url2 = esc_url( 'https://github.com/picocodes/brendah' );
			$msg2 = esc_html__( ' GitHub', 'brendah' );
			
			return "<a href='$url' class='button button-primary'>$msg</a> <a href='$url2' class='button button-primary'>$msg2</a>";
		}
		
		/**
		 * Welcome page boards
		 *
		 * @since 1.0.0
		 */
		public function picocodes_admin_boards($boards, $package ='brendah' ) {
			
			if ( is_array( $boards) ) {
				
				//woocommerce
				$boards['install-woocommerce'] = array(
					'title' => esc_html__( 'WooCommerce Ready!', 'brendah' ),
					'description' => esc_html__( 'Works fine as a stand-alone theme or as a WooCommerce store Theme.', 'brendah' ),
					'link' => $this->get_woocommerce_link(),
					);
				
				
				//ajax live search
				$boards['install-als'] = array(
					'title' => esc_html__( 'Ajax Live Search', 'brendah' ),
					'description' => esc_html__( "Brendah has been configured to work with the free Ajax Live Search plugin out of the box. You don't have to edit any theme files.", 'brendah' ),
					'link' => $this->get_als_link(),
					);
					
					
				//Customizer
				$boards['customize-brendah'] = array(
					'title' => esc_html__( 'Customize Brendah', 'brendah' ),
					'description' => esc_html__( 'Brendah fully integrates with the customizer to enable you set custom colors and layout options.', 'brendah' ),
					'link' => $this->get_customizer_link(),
					);
					
					
				//Contribute
				$boards['contribute-brendah'] = array(
					'title' => esc_html__( 'Contribute to Brendah', 'brendah' ),
					'description' => esc_html__( 'Use github to report a bug or send a pull request. You can also help translate Brendah on WordPress.', 'brendah' ),
					'link' => $this->get_contribute_link(),
					);
					
				//Donate
				$boards['donate-brendah'] = array(
					'title' => esc_html__( 'Donate', 'brendah' ),
					'description' => __( 'The best way to make a donation is by buying the premium version of Ajax Live Search plugin. It only costs <code>$29</code>.', 'brendah' ),
					'link' => $this->get_donate_link(),
					);
			}
			
			return $boards;
			
		}

	}

endif;

return new Brendah_Admin();
