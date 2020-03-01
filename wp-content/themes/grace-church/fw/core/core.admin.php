<?php
/**
 * Grace-Church Framework: Admin functions
 *
 * @package	grace_church
 * @since	grace_church 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Admin actions and filters:
------------------------------------------------------------------------ */

if (is_admin()) {

	/* Theme setup section
	-------------------------------------------------------------------- */
	
	if ( !function_exists( 'grace_church_admin_theme_setup' ) ) {
		add_action( 'grace_church_action_before_init_theme', 'grace_church_admin_theme_setup', 11 );
		function grace_church_admin_theme_setup() {
			if ( is_admin() ) {
				add_action("admin_head",			'grace_church_admin_prepare_scripts');
				add_action("admin_enqueue_scripts",	'grace_church_admin_load_scripts');
				add_action('tgmpa_register',		'grace_church_admin_register_plugins');

				// AJAX: Get terms for specified post type
				add_action('wp_ajax_grace_church_admin_change_post_type', 		'grace_church_callback_admin_change_post_type');
				add_action('wp_ajax_nopriv_grace_church_admin_change_post_type','grace_church_callback_admin_change_post_type');
			}
		}
	}
	
	// Load required styles and scripts for admin mode
	if ( !function_exists( 'grace_church_admin_load_scripts' ) ) {
		//add_action("admin_enqueue_scripts", 'grace_church_admin_load_scripts');
		function grace_church_admin_load_scripts() {
			grace_church_enqueue_script( 'grace_church-debug-script', grace_church_get_file_url('js/core.debug.js'), array('jquery'), null, true );
			//if (grace_church_options_is_used()) {
				grace_church_enqueue_style( 'grace_church-admin-style', grace_church_get_file_url('css/core.admin.css'), array(), null );
				grace_church_enqueue_script( 'grace_church-admin-script', grace_church_get_file_url('js/core.admin.js'), array('jquery'), null, true );
			//}
			if (grace_church_strpos($_SERVER['REQUEST_URI'], 'widgets.php')!==false) {
				grace_church_enqueue_style( 'grace_church-fontello-style', grace_church_get_file_url('css/fontello-admin/css/fontello-admin.css'), array(), null );
				grace_church_enqueue_style( 'grace_church-animations-style', grace_church_get_file_url('css/fontello-admin/css/animation.css'), array(), null );
			}
		}
	}
	
	// Prepare required styles and scripts for admin mode
	if ( !function_exists( 'grace_church_admin_prepare_scripts' ) ) {
		//add_action("admin_head", 'grace_church_admin_prepare_scripts');
		function grace_church_admin_prepare_scripts() {
            global $GRACE_CHURCH_GLOBALS;
			?>
			<script>
				if (typeof GRACE_CHURCH_GLOBALS == 'undefined') var GRACE_CHURCH_GLOBALS = {};
				jQuery(document).ready(function() {
					GRACE_CHURCH_GLOBALS['admin_mode']	= true;
                    GRACE_CHURCH_GLOBALS['ajax_nonce'] 	= "<?php echo esc_attr($GRACE_CHURCH_GLOBALS['ajax_nonce']); ?>";
                    GRACE_CHURCH_GLOBALS['ajax_url']	= "<?php echo esc_url($GRACE_CHURCH_GLOBALS['ajax_url']); ?>";
					GRACE_CHURCH_GLOBALS['user_logged_in'] = true;
				});
			</script>
			<?php
		}
	}
	
	// AJAX: Get terms for specified post type
	if ( !function_exists( 'grace_church_callback_admin_change_post_type' ) ) {
		//add_action('wp_ajax_grace_church_admin_change_post_type', 		'grace_church_callback_admin_change_post_type');
		//add_action('wp_ajax_nopriv_grace_church_admin_change_post_type',	'grace_church_callback_admin_change_post_type');
		function grace_church_callback_admin_change_post_type() {
            global $GRACE_CHURCH_GLOBALS;
                if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
				die();
			$post_type = $_REQUEST['post_type'];
			$terms = grace_church_get_list_terms(false, grace_church_get_taxonomy_categories_by_post_type($post_type));
			$terms = grace_church_array_merge(array(0 => esc_html__('- Select category -', 'grace-church')), $terms);
			$response = array(
				'error' => '',
				'data' => array(
					'ids' => array_keys($terms),
					'titles' => array_values($terms)
				)
			);
			echo json_encode($response);
			die();
		}
	}

	// Return current post type in dashboard
	if ( !function_exists( 'grace_church_admin_get_current_post_type' ) ) {
		function grace_church_admin_get_current_post_type() {
			global $post, $typenow, $current_screen;
			if ( $post && $post->post_type )							//we have a post so we can just get the post type from that
				return $post->post_type;
			else if ( $typenow )										//check the global $typenow — set in admin.php
				return $typenow;
			else if ( $current_screen && $current_screen->post_type )	//check the global $current_screen object — set in sceen.php
				return $current_screen->post_type;
			else if ( isset( $_REQUEST['post_type'] ) )					//check the post_type querystring
				return sanitize_key( $_REQUEST['post_type'] );
			else if ( isset( $_REQUEST['post'] ) ) {					//lastly check the post id querystring
				$post = get_post( sanitize_key( $_REQUEST['post'] ) );
				return !empty($post->post_type) ? $post->post_type : '';
			} else														//we do not know the post type!
				return '';
		}
	}
	
	// Register optional plugins
	if ( !function_exists( 'grace_church_admin_register_plugins' ) ) {
		function grace_church_admin_register_plugins() {

			$plugins = apply_filters('grace_church_filter_required_plugins', array(
				array(
					'name' 		=> 'Grace-church Utilities',
					'slug' 		=> 'grace-church-utils',
					'source'	=> grace_church_get_file_dir('plugins/grace-church-utils.zip'),
					'required' 	=> true
				),
				array(
					'name' 		=> 'Visual Composer',
					'slug' 		=> 'js_composer',
					'source'	=> grace_church_get_file_dir('plugins/js_composer.zip'),
					'required' 	=> false
				),
				array(
					'name' 		=> 'Revolution Slider',
					'slug' 		=> 'revslider',
					'source'	=> grace_church_get_file_dir('plugins/revslider.zip'),
					'required' 	=> false
				),
				array(
					'name' 		=> 'Tribe Events Calendar',
					'slug' 		=> 'the-events-calendar',
					'source'	=> grace_church_get_file_dir('plugins/the-events-calendar.zip'),
					'required' 	=> false
				),
                array(
                    'name' 		=> 'Essential Grid',
                    'slug' 		=> 'essential-grid',
                    'source'	=> grace_church_get_file_dir('plugins/essential-grid.zip'),
                    'required' 	=> false
                ),
                array(
                    'name' 		=> 'Content Timeline',
                    'slug' 		=> 'content_timeline',
                    'source'	=> grace_church_get_file_dir('plugins/content_timeline.zip'),
                    'required' 	=> false
                ),
                array(
                    'name' 		=> 'PayPal Donation',
                    'slug' 		=> 'paypal-donations',
                    'source'	=> grace_church_get_file_dir('plugins/paypal_donations.zip'),
                    'required' 	=> false
                ),
				array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					//'source'	=> grace_church_get_file_dir('plugins/wp-instagram-widget.zip'),
					'required' 	=> false
				)
			));
			$config = array(
				'domain'			=> 'grace-church',					// Text domain - likely want to be the same as your theme.
				'default_path'		=> '',							// Default absolute path to pre-packaged plugins
				'parent_menu_slug'	=> 'themes.php',				// Default parent menu slug
				'parent_url_slug'	=> 'themes.php',				// Default parent URL slug
				'menu'				=> 'install-required-plugins',	// Menu slug
				'has_notices'		=> true,						// Show admin notices or not
				'is_automatic'		=> true,						// Automatically activate plugins after installation or not
				'message'			=> '',							// Message to output right before the plugins table
				'strings'			=> array(
                    'page_title'                        => esc_html__( 'Install Required Plugins', 'grace-church' ),
                    'menu_title'                        => esc_html__( 'Install Plugins', 'grace-church' ),
                    'installing'                        => esc_html__( 'Installing Plugin: %s', 'grace-church' ), // %1$s = plugin name
                    'oops'                              => esc_html__( 'Something went wrong with the plugin API.', 'grace-church' ),
                    'notice_can_install_required'       => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_can_install_recommended'    => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_cannot_install'             => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_can_activate_required'      => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_can_activate_recommended'   => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_cannot_activate'            => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_ask_to_update'              => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'grace-church' ), // %1$s = plugin name(s)
                    'notice_cannot_update'              => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'grace-church' ), // %1$s = plugin name(s)
                    'install_link'                      => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'grace-church' ),
                    'activate_link'                     => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'grace-church' ),
                    'return'                            => esc_html__( 'Return to Required Plugins Installer', 'grace-church' ),
                    'plugin_activated'                  => esc_html__( 'Plugin activated successfully.', 'grace-church' ),
                    'complete'                          => esc_html__( 'All plugins installed and activated successfully. %s', 'grace-church'), // %1$s = dashboard link
                    'nag_type'                          => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
				)
			);

			tgmpa( $plugins, $config );
		}
	}

	require_once( grace_church_get_file_dir('lib/tgm/class-tgm-plugin-activation.php') );

	require_once( grace_church_get_file_dir('tools/emailer/emailer.php') );
	require_once( grace_church_get_file_dir('tools/po_composer/po_composer.php') );
}

?>