<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('grace_church_action_skin_theme_setup')) {
	add_action( 'grace_church_action_init_theme', 'grace_church_action_skin_theme_setup', 1 );
	function grace_church_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('grace_church_filter_used_fonts',			'grace_church_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('grace_church_filter_list_fonts',			'grace_church_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('grace_church_action_add_styles',			'grace_church_action_skin_add_styles');
		// Add skin inline styles
		add_filter('grace_church_filter_add_styles_inline',		'grace_church_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('grace_church_action_add_responsive',		'grace_church_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('grace_church_filter_add_responsive_inline',	'grace_church_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('grace_church_action_add_scripts',			'grace_church_action_skin_add_scripts');
		// Add skin scripts inline
		add_action('grace_church_action_add_scripts_inline',	'grace_church_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('grace_church_filter_compile_less',			'grace_church_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		grace_church_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'grace-church'),

			// Accent colors
			'accent1'				=> '#003d89',
			'accent1_hover'			=> '#ff9279',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#9fa0a3',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#3b3b42',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#344a5f',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#95a0aa',
			'inverse_hover'			=> '#ffffff',
			
			// Whole block border and background
			'bd_color'				=> '#f4f4f4',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#ffffff',
			'alter_light'			=> '#a0acb8',
			'alter_dark'			=> '#43454c',
			'alter_link'			=> '#43454c',
			'alter_hover'			=> '#189799',
			'alter_bd_color'		=> '#f4f4f4',
			'alter_bd_hover'		=> '#3d3e49',
			'alter_bg_color'		=> '#4e505d',
			'alter_bg_hover'		=> '#5e606d',
			'alter_bg_image'			=> grace_church_get_file_url('images/image_404.png'),
			'alter_bg_image_position'	=> 'center center',
			'alter_bg_image_repeat'		=> 'no-repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		grace_church_add_color_scheme('dark', array(

			'title'					=> esc_html__('Dark', 'grace-church'),

			// Accent colors
			'accent1'				=> '#20c7ca',
			'accent1_hover'			=> '#189799',
//			'accent2'				=> '#ff0000',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#909090',
			'text_light'			=> '#a0a0a0',
			'text_dark'				=> '#e0e0e0',
			'inverse_text'			=> '#f0f0f0',
			'inverse_light'			=> '#e0e0e0',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#e5e5e5',
			
			// Whole block border and background
			'bd_color'				=> '#000000',
			'bg_color'				=> '#333333',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#999999',
			'alter_light'			=> '#aaaaaa',
			'alter_dark'			=> '#d0d0d0',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#29fbff',
			'alter_bd_color'		=> '#909090',
			'alter_bd_hover'		=> '#888888',
			'alter_bg_color'		=> '#666666',
			'alter_bg_hover'		=> '#505050',
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);


		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		grace_church_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2.667rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.1em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.7em'
			)
		);
		grace_church_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.1em',
			'margin-top'	=> '1.3em',
			'margin-bottom'	=> '0.5em'
			)
		);
		grace_church_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.333rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.1em',
			'margin-top'	=> '1.5em',
			'margin-bottom'	=> '0.7em'
			)
		);
		grace_church_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.667rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.1em',
			'margin-top'	=> '1.2em',
			'margin-bottom'	=> '0.4em'
			)
		);
		grace_church_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.666rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.11em',
			'margin-top'	=> '1.1em',
			'margin-bottom'	=> '0.2em'
			)
		);
		grace_church_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.9333rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.1em',
			'margin-top'	=> '1.35em',
			'margin-bottom'	=> '0.75em'
			)
		);
		grace_church_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'grace-church'),
			'description'	=> '',
			'font-family'	=> 'Montserrat',
			'font-size' 	=> '1rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.8em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1em'
			)
		);
		grace_church_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		grace_church_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '0.6em',
			'margin-bottom'	=> '1.6em'
			)
		);
		grace_church_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.933rem',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '0.4em',
			'margin-bottom'	=> '0.4em'
			)
		);
		grace_church_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		grace_church_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '2rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.85em',
			'margin-top'	=> '0.5em',
			'margin-bottom'	=> '0.9em'
			)
		);
		grace_church_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '0.813rem',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em'
			)
		);
		grace_church_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'grace-church'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('grace_church_filter_skin_used_fonts')) {
	//add_filter('grace_church_filter_used_fonts', 'grace_church_filter_skin_used_fonts');
	function grace_church_filter_skin_used_fonts($theme_fonts) {
		//$theme_fonts['Roboto'] = 1;
		//$theme_fonts['Love Ya Like A Sister'] = 1;
        $theme_fonts['Montserrat'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('grace_church_filter_skin_list_fonts')) {
	//add_filter('grace_church_filter_list_fonts', 'grace_church_filter_skin_list_fonts');
	function grace_church_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => grace_church_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
        if (!isset($list['Montserrat']))			$list['Montserrat'] = array('family'=>'sans-serif', 'link'=>'Montserrat:,400,700');
		if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('grace_church_action_skin_add_styles')) {
	//add_action('grace_church_action_add_styles', 'grace_church_action_skin_add_styles');
	function grace_church_action_skin_add_styles() {
		// Add stylesheet files
		grace_church_enqueue_style( 'grace_church-skin-style', grace_church_get_file_url('skin.css'), array(), null );
		if (file_exists(grace_church_get_file_dir('skin.customizer.css')))
			grace_church_enqueue_style( 'grace_church-skin-customizer-style', grace_church_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('grace_church_filter_skin_add_styles_inline')) {
	//add_filter('grace_church_filter_add_styles_inline', 'grace_church_filter_skin_add_styles_inline');
	function grace_church_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = grace_church_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = grace_church_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('grace_church_action_skin_add_responsive')) {
	//add_action('grace_church_action_add_responsive', 'grace_church_action_skin_add_responsive');
	function grace_church_action_skin_add_responsive() {
		$suffix = grace_church_param_is_off(grace_church_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(grace_church_get_file_dir('skin.responsive'.($suffix).'.css')))
			grace_church_enqueue_style( 'theme-skin-responsive-style', grace_church_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('grace_church_filter_skin_add_responsive_inline')) {
	//add_filter('grace_church_filter_add_responsive_inline', 'grace_church_filter_skin_add_responsive_inline');
	function grace_church_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('grace_church_filter_skin_compile_less')) {
	//add_filter('grace_church_filter_compile_less', 'grace_church_filter_skin_compile_less');
	function grace_church_filter_skin_compile_less($files) {
		if (file_exists(grace_church_get_file_dir('skin.less'))) {
		 	$files[] = grace_church_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('grace_church_action_skin_add_scripts')) {
	//add_action('grace_church_action_add_scripts', 'grace_church_action_skin_add_scripts');
	function grace_church_action_skin_add_scripts() {
		if (file_exists(grace_church_get_file_dir('skin.js')))
			grace_church_enqueue_script( 'theme-skin-script', grace_church_get_file_url('skin.js'), array(), null );
		if (grace_church_get_theme_option('show_theme_customizer') == 'yes' && file_exists(grace_church_get_file_dir('skin.customizer.js')))
			grace_church_enqueue_script( 'theme-skin-customizer-script', grace_church_get_file_url('skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('grace_church_action_skin_add_scripts_inline')) {
	//add_action('grace_church_action_add_scripts_inline', 'grace_church_action_skin_add_scripts_inline');
	function grace_church_action_skin_add_scripts_inline() {
		// Todo: add skin specific scripts
		// Example:
		// echo '<script type="text/javascript">'
		//	. 'jQuery(document).ready(function() {'
		//	. "if (GRACE_CHURCH_GLOBALS['theme_font']=='') GRACE_CHURCH_GLOBALS['theme_font'] = '" . grace_church_get_custom_font_settings('p', 'font-family') . "';"
		//	. "GRACE_CHURCH_GLOBALS['theme_skin_color'] = '" . grace_church_get_scheme_color('accent1') . "';"
		//	. "});"
		//	. "< /script>";
	}
}
?>