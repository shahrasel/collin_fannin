<?php
/**
 * Grace-Church Framework: WordPress utilities
 *
 * @package	grace_church
 * @since	grace_church 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('grace_church_wp_theme_setup')) {
	add_action( 'grace_church_action_before_init_theme', 'grace_church_wp_theme_setup' );
	function grace_church_wp_theme_setup() {

		// Pre query: Add posts per page value into wp query
		add_action( 'pre_get_posts', 						'grace_church_query_add_posts_per_page' );

		// Pre query: Add filter to main query
		add_filter('posts_where', 							'grace_church_query_posts_where', 10, 2);

		// Filter categories list - exclude unwanted cats from widget output
		add_action('widget_categories_args',				'grace_church_query_exclude_categories');
		add_action('widget_categories_dropdown_args',		'grace_church_query_exclude_categories');
		add_action('widget_posts_args',						'grace_church_query_exclude_posts' );

		// Save start values in the views and likes counters when save or publish post
		add_action('publish_post',							'grace_church_init_post_counters');
		add_action('save_post',								'grace_church_init_post_counters');

		// AJAX: Get next page on blog streampage
		add_action('wp_ajax_view_more_posts', 				'grace_church_callback_view_more_posts');
		add_action('wp_ajax_nopriv_view_more_posts',		'grace_church_callback_view_more_posts');

		// AJAX: Incremental search
		add_action('wp_ajax_ajax_search',					'grace_church_callback_ajax_search');
		add_action('wp_ajax_nopriv_ajax_search',			'grace_church_callback_ajax_search');

		// AJAX: Change month in the calendar widget
		add_action('wp_ajax_calendar_change_month',			'grace_church_callback_calendar_change_month');
		add_action('wp_ajax_nopriv_calendar_change_month',	'grace_church_callback_calendar_change_month');

		// AJAX: Set post likes/views count
		add_action('wp_ajax_post_counter', 					'grace_church_callback_post_counter');
		add_action('wp_ajax_nopriv_post_counter', 			'grace_church_callback_post_counter');

		// AJAX: New user registration
		add_action('wp_ajax_registration_user',				'grace_church_callback_registration_user');
		add_action('wp_ajax_nopriv_registration_user',		'grace_church_callback_registration_user');

		// AJAX: User login
		add_action('wp_ajax_login_user',					'grace_church_callback_login_user');
		add_action('wp_ajax_nopriv_login_user',				'grace_church_callback_login_user');

		// Allow user login by email from WP login dialog
		add_filter('authenticate',							'grace_church_allow_email_login', 20, 3);

		// Add categories (taxonomies) filter for custom posts types
		add_action( 'restrict_manage_posts', 				'grace_church_show_taxonomies_filters' );

		// Clear taxonomies cache when save or delete post or category
		add_action( 'save_post', 							'grace_church_clear_cache_all', 10, 2 );
		add_action( 'delete_post', 							'grace_church_clear_cache_all', 10, 2 );
		add_action( 'edit_category', 						'grace_church_clear_cache_categories',   10, 1 );
		add_action( 'create_category', 						'grace_church_clear_cache_categories', 10, 1 );
		add_action( 'delete_category', 						'grace_church_clear_cache_categories', 10, 1 );

		// Clear WP categories cache 
		add_action('wp_ajax_clear_cache',					'grace_church_callback_clear_cache');
		add_action('wp_ajax_nopriv_clear_cache', 			'grace_church_callback_clear_cache');
	}
}



/* Blog tags
------------------------------------------------------------------------------------- */

// Return blog records type
if (!function_exists('grace_church_get_blog_type')) {
	function grace_church_get_blog_type($query=null) {
		global $wp_query;
		static $page='';
		if (!empty($page)) return $page;
		if ( $query===null ) $query = $wp_query;
		$page = apply_filters('grace_church_filter_get_blog_type', $page, $query);
		return $page;
	}
}

// Return blog title
if (!function_exists('grace_church_get_blog_title')) {
	function grace_church_get_blog_title() {
		global $wp_query;
		static $title='';
		if (!empty($title)) return $title;
		$page  = grace_church_get_blog_type();
		$title = apply_filters('grace_church_filter_get_blog_title', $title, $page);
		return $title;
	}
}

// Show breadcrumbs path
if (!function_exists('grace_church_show_breadcrumbs')) {
	function grace_church_show_breadcrumbs($args=array()) {
		global $wp_query, $post;
		
		grace_church_set_global('in_breadcrumbs', true);
		
		$args = array_merge( array(
			'home' => esc_html__('Home', 'grace-church'),		// Home page title (if empty - not showed)
			'home_url' => '',						// Home page url
			'show_all_filters' => true,				// Add "All photos" (All videos) before categories list
			'show_all_posts' => true,				// Add "All posts" at start 
			'truncate_title' => 50,					// Truncate all titles to this length (if 0 - no truncate)
			'truncate_add' => '...',				// Append truncated title with this string
			'delimiter' => '<span class="breadcrumbs_delimiter"></span>',			// Delimiter between breadcrumbs items
			'max_levels' => grace_church_get_theme_option('breadcrumbs_max_level'),		// Max categories in the path (0 - unlimited)
			'echo' => true							// If true - show on page, else - only return value
			), is_array($args) ? $args : array( 'home' => $args )
		);

		$type = grace_church_get_blog_type();
		$title = grace_church_strshort(grace_church_get_blog_title(), $args['truncate_title'], $args['truncate_add']);

		if ( in_array($type, array('home', 'frontpage')) ) return '';

		if ( $args['max_levels']<=0 ) $args['max_levels'] = 999;

		$need_reset = true;
		$rez = $rez_parent = $rez_all = $rez_level = $rez_period = '';
		$cat = $parentTax = '';
		$level = $parent = $post_id = 0;

		// Get current post ID and path to current post/page/attachment ( if it have parent posts/pages )
		if ($type == 'page' || $type == 'attachment' || is_single()) {
			$pageParentID = isset($wp_query->post->post_parent) ? $wp_query->post->post_parent : 0;
			$post_id = ($type == 'attachment' ? $pageParentID : (isset($wp_query->post->ID) ? $wp_query->post->ID : 0));
			while ($pageParentID > 0) {
				$pageParent = get_post($pageParentID);
				$level++;
				if ($level > $args['max_levels'])
					$rez_level = '...';
				else
					$rez_parent = '<a class="breadcrumbs_item cat_post" href="' . get_permalink($pageParent->ID) . '">' 
									. trim(grace_church_strshort($pageParent->post_title, $args['truncate_title'], $args['truncate_add']))
									. '</a>' 
									. (!empty($rez_parent) ? $args['delimiter'] : '') 
									. ($rez_parent);
				if (($pageParentID = $pageParent->post_parent) > 0) $post_id = $pageParentID;
			}
		}
		
		$depth = 0;

		$taxonomy = apply_filters('grace_church_filter_get_current_taxonomy', '', $type);
		$ex_cats = $taxonomy == 'category' ? explode(',', grace_church_get_theme_option('exclude_cats')) : array();
		
		do {
			if ($depth++ == 0) {
				if (is_single() || is_attachment()) {
					if ($args['show_all_filters']) {
						$post_format = get_post_format($post_id);
						if (($tpl_id = grace_church_get_template_page_id('only-'.($post_format))) > 0) {
							$level++;
							if ($level > $args['max_levels'])
								$rez_level = '...';
							else
								$rez_all .= (!empty($rez_all) ? $args['delimiter'] : '') 
										. '<a class="breadcrumbs_item all" href="' . get_permalink($tpl_id) . '">' 
											. sprintf( esc_html__('All %s', 'grace-church'), grace_church_get_post_format_name($post_format, false))
										. '</a>';
						}
					}
					$cats = grace_church_get_terms_by_post_id( array(
						'post_id'  => $post_id, 
						'taxonomy' => $taxonomy,
						'exclude'  => $ex_cats
						)
					);
					$cat = !empty($cats) && !empty($cats[$taxonomy]->terms) ? $cats[$taxonomy]->terms[0] : false;
					if ($cat) {
						$level++;
						if ($level > $args['max_levels'])
							$rez_level = '...';
						else
							$rez_parent = '<a class="breadcrumbs_item cat_post" href="'.esc_url($cat->link).'">' 
											. trim(grace_church_strshort($cat->name, $args['truncate_title'], $args['truncate_add']))
											. '</a>' 
											. (!empty($rez_parent) ? $args['delimiter'] : '') 
											. ($rez_parent);
					}
				} else if ( $type == 'category' ) {
					$cat_id = (int) get_query_var( 'cat' );
					if (empty($cat_id)) $cat_id = get_query_var( 'category_name' );
					$cat = get_term_by( (int) $cat_id > 0 ? 'id' : 'slug', $cat_id, 'category', OBJECT);
				} else if ( ($tax = grace_church_is_taxonomy()) != '' ) {
					$cat = get_term_by( 'slug', get_query_var( $tax ), $tax, OBJECT);
				}
				if ($cat) {
					$parent = $cat->parent;
					$parentTax = $cat->taxonomy;
				}
			}
			if ($parent) {
				$cat = get_term_by( 'id', $parent, $parentTax, OBJECT);
				if ($cat) {
					if (!in_array($cat->term_id, $ex_cats)) {
						$cat_link = get_term_link($cat->slug, $cat->taxonomy);
						$level++;
						if ($level > $args['max_levels'])
							$rez_level = '...';
						else
							$rez_parent = '<a class="breadcrumbs_item cat_parent" href="'.esc_url($cat_link).'">' 
											. trim(grace_church_strshort($cat->name, $args['truncate_title'], $args['truncate_add']))
											. '</a>' 
											. (!empty($rez_parent) ? $args['delimiter'] : '') 
											. ($rez_parent);
					}
					$parent = $cat->parent;
				}
			}
		} while ($parent);

		if ($args['show_all_posts']) {
			$all_title = grace_church_get_stream_page_title($type);
			$all_parts = explode(':', $all_title);
			if (count($all_parts) > 1)
				$all_title = trim($all_parts[1]);
			if ( $all_title && grace_church_strtolower($title) != grace_church_strtolower($all_title)) {
				$all_link = grace_church_get_stream_page_link($type);
				if (!empty($all_link))
					$rez_all = '<a class="breadcrumbs_item all" href="' . esc_url($all_link) . '">' . ($all_title) . '</a>' . (!empty($rez_all) ? $args['delimiter'] : '') . ($rez_all);
			}
		}

		$rez_period = apply_filters('grace_church_filter_get_period_links', '', $type, $args['delimiter']);

		if (!is_front_page()) {	// && !is_home()
			$rez .= (isset($args['home']) && $args['home']!='' ? '<a class="breadcrumbs_item home" href="' . esc_url($args['home_url'] ? $args['home_url'] : esc_url( home_url( '/' ) )) . '">' . ($args['home']) . '</a>' . ($args['delimiter']) : '')
				. (!empty($rez_all)    ? ($rez_all)    . ($args['delimiter']) : '')
				. (!empty($rez_level)  ? ($rez_level)  . ($args['delimiter']) : '')
				. (!empty($rez_parent) ? ($rez_parent) . ($args['delimiter']) : '')
				. (!empty($rez_period) ? ($rez_period) . ($args['delimiter']) : '')
				. ($title ? '<span class="breadcrumbs_item current">' . ($title) . '</span>' : '');
		}

		if ($args['echo'] && !empty($rez)) echo ($rez);

		grace_church_set_global('in_breadcrumbs', false);

		return $rez;
	}
}

// Show pages links below list or single page
if (!function_exists('grace_church_show_pagination')) {
	function grace_church_show_pagination($args=array()) {
		$args = array_merge(array(
			'offset' => 0,				// Offset to first showed record
			'id' => 'pagination',		// 'id' attribute
			'class' => 'pagination',	// 'class' attribute
			'button_class' => 'theme_button',		// 'class' attribute for each page button
			'style' => 'pages',
			'show_pages' => 5,
			'pages_in_group' => 10,
			'pages_text' => '', 		//__('Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'grace-church'),
			'current_text' => "%PAGE_NUMBER%",
			'page_text' => "%PAGE_NUMBER%",
			'first_text'=> esc_html__('&laquo; First', 'grace-church'),
			'last_text' => esc_html__("Last &raquo;", 'grace-church'),
			'prev_text' => esc_html__("&laquo; Prev", 'grace-church'),
			'next_text' => esc_html__("Next &raquo;", 'grace-church'),
			'dot_text' => "&hellip;",
			'before' => '',
			'after' => '',
			),  is_array($args) ? $args 
				: (is_int($args) ? array( 'offset' => $args ) 		// If send number parameter - use it as offset
					: array( 'id' => $args, 'class' => $args )));	// If send string parameter - use it as 'id' and 'class' name
		if (empty($args['before']))	$args['before'] = '<nav id="'.esc_attr($args['id']).'" class="'.esc_attr($args['class']).'" role="navigation">';
		if (empty($args['after'])) 	$args['after'] = '</nav>';
		if (!is_single()) {
			grace_church_show_pagination_blog($args);
		} else {
			grace_church_show_pagination_single($args);
		}
	}
}

// Single page navigation
if (!function_exists('grace_church_show_pagination_single')) {
	function grace_church_show_pagination_single( $args ) {
		global $wp_query, $post;
		// Don't print empty markup on single pages if there's nowhere to navigate.
		if ( is_single() ) {
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
			$next = get_adjacent_post( false, '', false );
			if ( ! $next && ! $previous )
				return;
		}
		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
			return;
		echo ($args['before']);
		if ( is_single() ) {
			?>
			<h3 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'grace-church' ); ?></h3>
			<?php
			// navigation links for single posts
			previous_post_link( '<div class="pager_prev '.esc_attr($args['button_class']).'">%link</div>', '<span class="pager_nav">' . ($args['prev_text']) . '</span> %title' );
			next_post_link( '<div class="pager_next '.esc_attr($args['button_class']).'">%link</div>', '%title <span class="pager_nav">' . ($args['next_text']) . '</span>' );
		} else if ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) {	// navigation links for home, archive, and search pages
			if ( get_previous_posts_link() ) {
				?><div class="pager_prev <?php echo esc_attr($args['button_class']); ?>"><?php previous_posts_link( $args['prev_text'] ); ?></div><?php
			}
			if ( get_next_posts_link() ) {
				?><div class="pager_next <?php echo esc_attr($args['button_class']); ?>"><?php next_posts_link( $args['next_text'] ); ?></div><?php
			}
		}
		echo ($args['after']);
	}
}

// Blog pagination
if (!function_exists('grace_church_show_pagination_blog')) {
	function grace_church_show_pagination_blog($opt) {
		global $wp_query;
	
		$output = '';
		
		if (!is_single()) {
			$num_posts = $wp_query->found_posts - ($opt['offset'] > 0 ? $opt['offset'] : 0);
			$posts_per_page = intval(get_query_var('posts_per_page'));
			$cur_page = intval(get_query_var('paged'));
			if ($cur_page==0) $cur_page = intval(get_query_var('page'));
			if (empty($cur_page) || $cur_page == 0) $cur_page = 1;
			$show_pages = $opt['show_pages'] > 0 ? $opt['show_pages'] : $opt['pages_in_group'];
			$show_pages_start = $cur_page - floor($show_pages/2);
			$show_pages_end = $show_pages_start + $show_pages - 1;
			$max_page = ceil($num_posts / $posts_per_page);
			$cur_group = ceil($cur_page / $opt['pages_in_group']);
	
			if ($max_page > 1) {
	
				$output .= $opt['before'];
	
				if ($opt['style'] == 'pages') {
					// Page XX from XXX
					if ($opt['pages_text']) {
						$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($cur_page), $opt['pages_text']);
						$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
						$output .= '<span class="pager_pages '.esc_attr($opt['button_class']).'">' . ($pages_text) . '</span>';
					}
					if ($cur_page > 1) {
						// First page
						$page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $opt['first_text']);
						$output .= '<a href="'.esc_url(get_pagenum_link()).'" class="pager_first '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
						// Prev page
						$output .= '<a href="'.esc_url(get_pagenum_link($cur_page-1)).'" class="pager_prev '.esc_attr($opt['button_class']).'">'.($opt['prev_text']).'</a>';
					}
					// Page buttons
					$group = 1;
					$dot1 = $dot2 = false;
					for ($i = 1; $i <= $max_page; $i++) {
						if ($i % $opt['pages_in_group'] == 1) {
							$group = ceil($i / $opt['pages_in_group']);
							if ($group != $cur_group)
								$output .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="pager_group '.esc_attr($opt['button_class']).'">'.($i).'-'.min($i+$opt['pages_in_group']-1, $max_page).'</a>';
						}
						if ($group == $cur_group) {
							if ($i < $show_pages_start) {
								if (!$dot1) {
									$output .= '<a href="'.esc_url(get_pagenum_link($show_pages_start-1)).'" class="pager_dot '.esc_attr($opt['button_class']).'">'.($opt['dot_text']).'</a>';
									$dot1 = true;
								}
							} else if ($i > $show_pages_end) {
								if (!$dot2) {
									$output .= '<a href="'.esc_url(get_pagenum_link($show_pages_end+1)).'" class="pager_dot '.esc_attr($opt['button_class']).'">'.($opt['dot_text']).'</a>';
									$dot2 = true;
								}
							} else if ($i == $cur_page) {
								$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $opt['current_text']);
								$output .= '<span class="pager_current active '.esc_attr($opt['button_class']).'">'.($page_text).'</span>';
							} else {
								$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $opt['page_text']);
								$output .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="'.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
							}
						}
					}
					if ($cur_page < $max_page) {
						// Next page
						$output .= '<a href="'.esc_url(get_pagenum_link($cur_page+1)).'" class="pager_next '.esc_attr($opt['button_class']).'">'.($opt['next_text']).'</a>';
						// Last page
						$page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $opt['last_text']);
						$output .= '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="pager_last '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
					}
	
				} else if ($opt['style'] == 'slider') {
					
					// Enqueue swiper scripts and styles
					grace_church_enqueue_slider();
	
					if ($cur_page > 1) {
						// First page
						$page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $opt['first_text']);
						$page_text = str_replace("&laquo;", '', $page_text);
						$output .= '<a href="'.esc_url(get_pagenum_link()).'" class="pager_first '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
						// Prev page
						$page_text = str_replace("&laquo;", '', $opt['prev_text']);
						$output .= '<a href="'.esc_url(get_pagenum_link($cur_page-1)).'" class="pager_prev '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
					}
					// Page XX from XXX
					if (empty($opt['pages_text'])) 
						$opt['pages_text'] = esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%', 'grace-church');
					$pages_text = str_replace("%CURRENT_PAGE%", '<input class="pager_cur" readonly="readonly" type="text" size="1" value="'.esc_attr($cur_page).'">', $opt['pages_text']);
					$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
					$output .= '<div class="pager_pages">' . ($pages_text);
					// Page buttons
					$output .= '<div class="pager_slider">'
						. '<div class="sc_slider sc_slider_swiper sc_slider_controls sc_slider_controls_top sc_slider_nopagination sc_slider_noautoplay swiper-slider-container">'
						. '<div class="slides swiper-wrapper" data-current-slide="'.esc_attr($cur_group).'">';
					$group = 1;
					$row_opened = false;
					for ($i = 1; $i <= $max_page; $i++) {
						if ($i % $opt['pages_in_group'] == 1) {
							$group = ceil($i / $opt['pages_in_group']);
							$output .= ($i > 1 ? '</tr></table></div></div>' : '') . '<div class="swiper-slide"><div class="pager_numbers"><table>';
							$row_opened = false;
						}
						if ($i % $opt['show_pages'] == 1) {
							if ($row_opened)
								$output .= '</tr>';
							$output .= '<tr>';
							$row_opened = true;
						}
						if ($i == $cur_page) {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $opt['current_text']);
							$output .= '<td><a href="#" class="active">'.($page_text).'</a></div>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $opt['page_text']);
							$output .= '<td><a href="'.esc_url(get_pagenum_link($i)).'">'.($page_text).'</a></td>';
						}
					}
					$output .= '</tr></table></div></div>';
					$output .= '</div>'
						. '</div>'
						. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
						. '</div>'
						. '</div>';
					if ($cur_page < $max_page) {
						// Next page
						$page_text = str_replace("&raquo;", '', $opt['next_text']);
						$output .= '<a href="'.esc_url(get_pagenum_link($cur_page+1)).'" class="pager_next '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
						// Last page
						$page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $opt['last_text']);
						$page_text = str_replace("&raquo;", '', $page_text);
						$output .= '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="pager_last '.esc_attr($opt['button_class']).'">'.($page_text).'</a>';
					}
	
				}
				$output .= $opt['after'];
			}
		}
		echo ($output);
	}
}


// Get next page on blog streampage (viewmore button callback)
if ( !function_exists( 'grace_church_callback_view_more_posts' ) ) {
	function grace_church_callback_view_more_posts() {
        global $_REQUEST, $post, $wp_query, $GRACE_CHURCH_GLOBALS;

        if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
			die();
	
		$response = array('error'=>'', 'data' => '', 'no_more_data' => 0);
		
		$page = $_REQUEST['page'];
		$args = unserialize(stripslashes($_REQUEST['data']));
		$vars = unserialize(stripslashes($_REQUEST['vars']));
	
		if ($page > 0 && is_array($args) && is_array($vars)) {
			extract($vars);
			$args['page'] = $page;
			$args['paged'] = $page;
			$args['ignore_sticky_posts'] = 1;
			// Use query_posts() instead new WP_Query because this is a AJAX handler and it die after working
			// (not need to restore main query)
			if (!isset($wp_query))
				$wp_query = new WP_Query( $args );
			else
				query_posts($args);
			$per_page = count($wp_query->posts);
			$response['no_more_data'] = $page>=$wp_query->max_num_pages;
			$post_number = 0;
			$response['data'] = '';
			$flt_ids = array();
			while ( have_posts() ) { the_post(); 
				$post_number++;
				$post_args = array(
					'layout' => $vars['blog_style'],
					'number' => $post_number,
					'add_view_more' => false,
					'posts_on_page' => $per_page,
					'columns_count' => $vars['columns_count'],
					// Get post data
					'content' => grace_church_get_template_property($vars['blog_style'], 'need_content'),
					'terms_list' => !grace_church_param_is_off($vars['filters']) || grace_church_get_template_property($vars['blog_style'], 'need_terms'),
					'strip_teaser' => false,
					'parent_tax_id' => $vars['parent_tax_id'],
					'sidebar' => $vars['show_sidebar'] != 'hide',
					'filters' => $vars['filters'],
					'hover' => $vars['hover'] ? $vars['hover'] : 'square effect_dir',
					'hover_dir' => $vars['hover_dir'] ? $vars['hover_dir'] : 'left_to_right',
					'show' => false
				);
				$post_data = grace_church_get_post_data($post_args);
				$response['data'] .= grace_church_show_post_layout($post_args, $post_data);
				if ($vars['filters']=='tags') {
					if (!empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms) && is_array($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms)) {
						foreach ($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms as $tag) {
							$flt_ids[$tag->term_id] = $tag->name;
						}
					}
				}
			}
			$response['filters'] = $flt_ids;
		} else {
			$response['error'] = esc_html__('Wrong query arguments', 'grace-church');
		}
		
		echo json_encode($response);
		die();
	}
}

// Incremental search
if ( !function_exists( 'grace_church_callback_ajax_search' ) ) {
	function grace_church_callback_ajax_search() {
		global $_REQUEST, $post, $wp_query;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
			die();
	
		$response = array('error'=>'', 'data' => '');
		
		$s = $_REQUEST['text'];
	
		if (!empty($s)) {

			$show_types 	= grace_church_get_theme_option('ajax_search_types');
			$show_date 		= grace_church_get_theme_option('ajax_search_posts_date')=='yes' ? 1 : 0;
			$show_image 	= grace_church_get_theme_option('ajax_search_posts_image')=='yes' ? 1 : 0;
			$show_author 	= grace_church_get_theme_option('ajax_search_posts_author')=='yes' ? 1 : 0;
			$show_counters	= grace_church_get_theme_option('ajax_search_posts_counters')=='yes' ? grace_church_get_theme_option('blog_counters') : '';
			$args = array(
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'desc', 
				'posts_per_page' => max(1, min(10, grace_church_get_theme_option('ajax_search_posts_count'))),
				's' => esc_html($s),
				);
			// Filter post types
			if (!empty($show_types)) $args['post_type'] = explode(',', $show_types);
			// Exclude categories
			if (grace_church_strpos($show_types, 'post') !== false) {
				$ex = grace_church_get_theme_option('exclude_cats');
				if (!empty($ex))
					$args['category__not_in'] = explode(',', $ex);
			}

			$args = apply_filters( 'ajax_search_query', $args);	

			$post_number = 0;
			$output = '';

			if (!isset($wp_query))
				$wp_query = new WP_Query( $args );
			else
				query_posts($args);
			while ( have_posts() ) { the_post();
				$post_number++;
				require(grace_church_get_file_dir('templates/_parts/widgets-posts.php'));
			}
			if (empty($output)) {
				$output .= '<article class="post_item">' . esc_html__('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'grace-church') . '</article>';
			} else {
				$output .= '<article class="post_item"><a href="#" class="post_more search_more">' . esc_html__('More results &hellip;', 'grace-church') . '</a></article>';
			}
			$response['data'] = $output;
		} else {
			$response['error'] = esc_html__('The query string is empty!', 'grace-church');
		}
		
		echo json_encode($response);
		die();
	}
}


	
/* Page components layouts
------------------------------------------------------------------------------------- */

// Get modified calendar layout
if (!function_exists('grace_church_get_calendar')) {
	function grace_church_get_calendar($onlyFirstLetter = false, $get_month = 0, $get_year = 0, $opt=array()) {
		global $m, $monthnum, $year, $wp_locale, $posts;

		if ( isset($_GET['w']) ) $w = ''.intval($_GET['w']);
	
		// week_begins = 0 stands for Sunday
		$week_begins = intval(get_option('start_of_week'));
	
		// Let's figure out when we are
		if ( !empty($get_month) && !empty($get_year) ) {
			$thismonth = ''.zeroise(intval($get_month), 2);
			$thisyear = ''.intval($get_year);
		} else if ( !empty($monthnum) && !empty($year) ) {
			$thismonth = ''.zeroise(intval($monthnum), 2);
			$thisyear = ''.intval($year);
		} elseif ( !empty($w) ) {
			$thisyear = ''.intval(substr($m, 0, 4));
			$thismonth = strtotime("+{$w} weeks", "{$thisyear}-01-01");
		} elseif ( !empty($m) ) {
			$thisyear = ''.intval(substr($m, 0, 4));
			if ( strlen($m) < 6 )
				$thismonth = '01';
			else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
		} else {
			$thisyear = gmdate('Y', current_time('timestamp'));
			$thismonth = gmdate('m', current_time('timestamp'));
		}
		$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);
		$last_day = date('t', $unixmonth);
	
		// Post types in array
		$posts_types = explode(',', !empty($opt['post_type']) ? $opt['post_type'] : 'post');
		
		// Translators: Calendar caption: 1: month name, 2: 4-digit year
		$calendar_caption = _x('%1$s %2$s', 'calendar caption', 'grace-church');
		$calendar_output = '<table id="wp-calendar-'.str_replace('.', '', mt_rand()).'" class="wp-calendar"><thead><tr>';
	
		// Get days with posts
		$posts = apply_filters('grace_church_filter_calendar_get_curr_month_posts', array(), array(
			'posts_types' => $posts_types,
			'year' => $thisyear,
			'month' => $thismonth,
			'last_day' => $last_day
			)
		);
		if (count($posts) > (!empty($posts['done']) ? 1 : 0)) {
			// Get the current month and year
			$link = apply_filters('grace_church_filter_calendar_get_month_link', '', array(
				'posts_types' => $posts_types,
				'year' => $thisyear,
				'month' => $thismonth,
				'last_day' => $last_day
				)
			);
		} else
			$link = '';
		$calendar_output .= '<th class="month_cur" colspan="5">' . ($link ? '<a href="' . esc_url($link) . '" title="' . esc_attr( sprintf( esc_html__('View posts for %1$s %2$s', 'grace-church'), $wp_locale->get_month($thismonth), date('Y', mktime(0, 0, 0, $thismonth, 1, $thisyear)))) . '">' : '') . sprintf($calendar_caption, $wp_locale->get_month($thismonth), '<span>'.date('y', $unixmonth).'</span>') . ($link ? '</a>' : '') . '</th>';

        // Get the previous month and year with at least one post
        $prev = apply_filters('grace_church_filter_calendar_get_prev_month', array(), array(
                'posts_types' => $posts_types,
                'year' => $thisyear,
                'month' => $thismonth,
                'last_day' => $last_day
            )
        );
        $prev_month = !empty($prev) ? $prev['month'] : 0;
        $prev_year = !empty($prev) ? $prev['year'] : 0;
        $calendar_output .= '<th class="month_prev">';
        if ( $prev_year+$prev_month > 0 ) {
            $calendar_output .= '<a href="#" data-type="'.esc_attr(join(',', $posts_types)).'" data-year="' . esc_attr($prev_year) . '" data-month="' . esc_attr($prev_month) . '" title="' . esc_attr( sprintf( esc_html__('View posts for %1$s %2$s', 'grace-church'), $wp_locale->get_month($prev_month), date('Y', mktime(0, 0, 0, $prev_month, 1, $prev_year)))) . '">'
                //. '&laquo; ' . ($wp_locale->get_month_abbrev($wp_locale->get_month($prev_month)))
                . '</a>';
        } else {
            $calendar_output .= '&nbsp;';
        }
        $calendar_output .= '</th>';

		// Get the next month and year with at least one post
		$next = apply_filters('grace_church_filter_calendar_get_next_month', array(), array(
			'posts_types' => $posts_types,
			'year' => $thisyear,
			'month' => $thismonth,
			'last_day' => $last_day
			)
		);
		$next_month = !empty($next) ? $next['month'] : 0;
		$next_year = !empty($next) ? $next['year'] : 0;
		$calendar_output .= '<th class="month_next">';

		if ( $next_year+$next_month > 0 ) {
			$calendar_output .= '<a href="#" data-type="'.esc_attr(join(',', $posts_types)).'" data-year="' . esc_attr($next_year) . '" data-month="' . esc_attr($next_month) . '" title="' . esc_attr( sprintf( esc_html__('View posts for %1$s %2$s', 'grace-church'), $wp_locale->get_month($next_month), date('Y', mktime(0, 0 , 0, $next_month, 1, $next_year))) ) . '">'
				//. ($wp_locale->get_month_abbrev($wp_locale->get_month($next->month))) . ' &raquo;'
				. '</a>';
		} else {
			$calendar_output .= '&nbsp;';
		}
		$calendar_output .= '</th></tr><tr>';
	
		// Show Week days
		$myweek = array();
	
		for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
			$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
		}
	
		if (is_array($myweek) && count($myweek) > 0) {
			foreach ($myweek as $wd) {
//				$day_name = $onlyFirstLetter ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
                $day_name = $wp_locale->get_weekday_initial($wd);
				$wd = esc_attr($wd);
				$calendar_output .= "<th class=\"weekday\" scope=\"col\" title=\"$wd\">$day_name</th>";
			}
		}
	
		$calendar_output .= '</tr></thead><tbody><tr>';

		// See how much we should pad in the beginning
		$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
		if ( $pad != 0 )
			$calendar_output .= '<td colspan="'. esc_attr($pad) .'" class="pad"><span class="day_wrap">&nbsp;</span></td>';

		$daysinmonth = intval(date('t', $unixmonth));
		for ( $day = 1; $day <= $daysinmonth; ++$day ) {
			if ( isset($newrow) && $newrow )
				$calendar_output .= "</tr><tr>";
			$newrow = false;
			if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
				$calendar_output .= '<td class="today">';
			else
				$calendar_output .= '<td class="day">';
			if ( !empty($posts[$day]) )
				$calendar_output .= '<a class="day_wrap" href="' . esc_url(!empty($posts[$day]['link']) ? $posts[$day]['link'] : get_day_link($thisyear, $thismonth, $day)) . '" title="' . esc_attr( is_int($posts[$day]['titles']) ? $posts[$day]['titles'].' '. esc_html__('items', 'grace-church') : $posts[$day]['titles'] ) . "\">$day</a>";
			else
				$calendar_output .= '<span class="day_wrap">'.($day).'</span>';
			$calendar_output .= '</td>';
	
			if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
				$newrow = true;
		}
	
		$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
		if ( $pad != 0 && $pad != 7 )
			$calendar_output .= '<td class="pad" colspan="'. esc_attr($pad) .'"><span class="day_wrap">&nbsp;</span></td>';
	
		$calendar_output .= "</tr></tbody></table>";
	
		return $calendar_output;
	}
}

// Calendar change month
if ( !function_exists( 'grace_church_callback_calendar_change_month' ) ) {
	function grace_church_callback_calendar_change_month() {
		global $_REQUEST, $GRACE_CHURCH_GLOBALS;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
			die();
	
		$m = (int) $_REQUEST['month'];
		$y = (int) $_REQUEST['year'];
		$pt = $_REQUEST['post_type'];

		$response = array('error'=>'', 'data'=>grace_church_get_calendar(false, $m, $y, array('post_type'=>$pt)));

		echo json_encode($response);
		die();
	}
}


// Callback for output single comment layout
if (!function_exists('grace_church_output_single_comment')) {
	function grace_church_output_single_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case 'pingback' :
				?>
				<li class="trackback"><?php esc_html_e( 'Trackback:', 'grace-church' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'grace-church' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			case 'trackback' :
				?>
				<li class="pingback"><?php esc_html_e( 'Pingback:', 'grace-church' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'grace-church' ), '<span class="edit-link">', '<span>' ); ?>
				<?php
				break;
			default :
				$author_id = $comment->user_id;
				$author_link = get_author_posts_url( $author_id );
				?>
				<li id="comment-<?php comment_ID(); ?>" <?php comment_class('comment_item'); ?>>
					<div class="comment_author_avatar"><?php echo get_avatar( $comment, 75*min(2, max(1, grace_church_get_theme_option("retina_ready")))); ?></div>
					<div class="comment_content">
						<div class="comment_info">
							<span class="comment_author"><?php echo ($author_id ? '<a href="'.esc_url($author_link).'">' : '') . comment_author() . ($author_id ? '</a>' : ''); ?></span>
							<span class="comment_date"><span class="comment_date_label"><?php esc_html_e('Posted', 'grace-church'); ?></span> <span class="comment_date_value"><?php echo get_comment_date(get_option('date_format')); ?></span></span>
							<span class="comment_time"><?php echo get_comment_date(get_option('time_format')); ?></span>
						</div>
						<div class="comment_text_wrap">
							<?php if ( $comment->comment_approved == 0 ) { ?>
							<div class="comment_not_approved"><?php esc_html_e( 'Your comment is awaiting moderation.', 'grace-church' ); ?></div>
							<?php } ?>
							<div class="comment_text"><?php comment_text(); ?></div>
						</div>
						<?php if ($depth < $args['max_depth']) { ?>
							<div class="comment_reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
						<?php } ?>
					</div>
				<?php
				break;
		}
	}
}




	
/* Blog utils
------------------------------------------------------------------------------------- */
	
// Return ID for the page with specified template
if (!function_exists('grace_church_get_template_page_id')) {
	function grace_church_get_template_page_id($name) {
		$posts = grace_church_get_posts_by_meta_value('_wp_page_template', $name . '.php');
		$id = 0;
		for ($i=0; $i<count($posts); $i++) {
			if ($posts[$i]->post_status == 'publish') {
				$id = $posts[$i]->ID;
				break;
			}
		}
		return $id;
	}
}
	
// Detect current mode and return correspond template page ID
if (!function_exists('grace_church_detect_template_page_id')) {
	function grace_church_detect_template_page_id($key='') {
		static $template_id = '';
		if (!empty($template_id)) return $template_id;
		if (empty($key)) $key = grace_church_detect_inheritance_key();
		if (!empty($key)) {
			$inheritance = grace_church_get_theme_inheritance($key);
			if (is_singular() && !grace_church_get_global('blog_streampage') && !empty($inheritance['single_template'])) {
				$template_id = grace_church_get_template_page_id($inheritance['single_template']);
			}
			if ((!is_singular() || !$template_id) && !empty($inheritance['stream_template'])) {
				$template_id = grace_church_get_template_page_id($inheritance['stream_template']);
			}
		}
		if (empty($template_id)) $template_id = apply_filters('grace_church_filter_detect_template_page_id', 0, $key);
		return $template_id;
	}
}
	
// Detect current mode template slug
if (!function_exists('grace_church_detect_template_slug')) {
	function grace_church_detect_template_slug($key='') {
		static $template_slug = '';
		if (!empty($template_slug)) return $template_slug;
		if (empty($key)) $key = grace_church_detect_inheritance_key();
		if (!empty($key)) {
			$inheritance = grace_church_get_theme_inheritance($key);
			if (is_singular() && !grace_church_get_global('blog_streampage') && !empty($inheritance['single_template'])) {
				$template_slug = grace_church_get_slug($inheritance['single_template']);
			}
			if ((!is_singular() || !$template_slug) && !empty($inheritance['stream_template'])) {
				$template_slug = grace_church_get_slug($inheritance['stream_template']);
			}
		}
		if (empty($template_slug)) $template_slug = apply_filters('grace_church_filter_detect_template_slug', '', $key);
		if (empty($template_slug)) $template_slug = $key;
		return $template_slug;
	}
}
	
// Return slug for the specified template
if (!function_exists('grace_church_get_template_slug')) {
	function grace_church_get_template_slug($key) {
		$template_slug = '';
		$inheritance = grace_church_get_theme_inheritance($key);
		if (is_singular() && !grace_church_get_global('blog_streampage') && !empty($inheritance['single_template'])) {
			$template_slug = grace_church_get_slug($inheritance['single_template']);
		}
		if ((!is_singular() || !$template_slug) && !empty($inheritance['stream_template'])) {
			$template_slug = grace_church_get_slug($inheritance['stream_template']);
		}
		if (empty($template_slug)) $template_slug = $key;
		return $template_slug;
	}
}
	
// Return ID of the stream page for specified mode
if (!function_exists('grace_church_get_stream_page_id')) {
	function grace_church_get_stream_page_id($mode) {
		return apply_filters('grace_church_filter_get_stream_page_id', '', $mode);
	}
}
	
// Return link to the stream page for specified mode
if (!function_exists('grace_church_get_stream_page_link')) {
	function grace_church_get_stream_page_link($mode) {
		return apply_filters('grace_church_filter_get_stream_page_link', '', $mode);
	}
}
	
// Return title of the stream page for specified mode
if (!function_exists('grace_church_get_stream_page_title')) {
	function grace_church_get_stream_page_title($mode) {
		return apply_filters('grace_church_filter_get_stream_page_title', '', $mode);
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'grace_church_is_taxonomy' ) ) {
	function grace_church_is_taxonomy($query=null) {
		static $tax = '';
		if (!empty($tax)) return $tax;
		$tax = apply_filters('grace_church_filter_is_taxonomy',	$tax);
		if (!empty($tax)) return $tax;
		if ($query && $query->is_category() || is_category())
			$tax = 'category';
		else if ($query && $query->is_tag() || is_tag())
			$tax = 'post_tag';
		return $tax;
	}
}

// Return taxonomy term if current page is this taxonomy page
if ( !function_exists( 'grace_church_get_current_term' ) ) {
	function grace_church_get_current_term($tax='') {
		static $term = null;
		if (!empty($term)) return $term;
		if (empty($tax)) return null;
		if ($tax == 'category' ) {
			$cat_id = (int) get_query_var( 'cat' );
			if (empty($cat_id)) $cat_id = get_query_var( 'category_name' );
			$term = get_term_by( (int) $cat_id > 0 ? 'id' : 'slug', $cat_id, 'category', OBJECT);
		} else {
			$term = get_term_by( 'slug', get_query_var( $tax ), $tax, OBJECT);
		}
		return $term;
	}
}

// Return posts by meta_value
if (!function_exists('grace_church_get_posts_by_meta_value')) {
	function grace_church_get_posts_by_meta_value($meta_key, $meta_value, $count=1) {
		global $post;
		$args = array(
			'posts_per_page'	=> $count,
			'post_type'			=> array('post', 'page'),	//get_post_types( '', 'names' ),
			'post_status'		=> 'publish',
			'ignore_sticky_posts' => true,
			'meta_key'			=> $meta_key,
			'meta_compare'		=> '='
			);
		if ( is_float($meta_value) )
			$args['meta_value_num'] = $meta_value;
		else
			$args['meta_value'] = $meta_value;
		$query = new WP_Query($args);
		$posts = array();
		while ( $query->have_posts() ) { $query->the_post();
			$posts[] = $post;
		}
		wp_reset_postdata();
		return $posts;
	}
}

// Get taxonomies terms by post id
if (!function_exists('grace_church_get_terms_by_post_id')) {
	function grace_church_get_terms_by_post_id($args=array()) {
		$args = array_merge(array(
			'post_id' 	=> 0,
			'taxonomy' 	=> array(),
			'parent_id'	=> 0,
			'exclude'	=> array(),
		), is_array($args) ? $args : array('post_id'=>$args));
		global $wp_query;
		if (!$args['post_id']) $args['post_id'] = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		if (!is_array($args['taxonomy'])) $args['taxonomy'] = array($args['taxonomy']);
		$post_type = get_post_type($args['post_id']);
		$taxonomies = get_object_taxonomies( $post_type, 'objects' );
		// get method for the parent term detection
		$closest_method = grace_church_get_theme_option('close_category');
		// make terms list
		$terms_list = array();
		if (is_array($taxonomies) && count($taxonomies) > 0) {
			foreach ($taxonomies as $taxonomy_slug => $taxonomy_obj) {
				if (count($args['taxonomy'])>0 && !in_array($taxonomy_slug, $args['taxonomy'])) continue;
				// get the terms related to post
				// use it instead get_the_term_list() - return html string with terms
				if (false) $terms = get_the_term_list($args['post_id'], $taxonomy_slug);
				$terms = get_the_terms( $args['post_id'], $taxonomy_slug );
				if (!empty($terms) && is_array($terms)) {
					$terms_list[$taxonomy_slug] = $taxonomy_obj;
					$terms_list[$taxonomy_slug]->closest_parent = false;
					$terms_list[$taxonomy_slug]->terms			= array();
					$terms_list[$taxonomy_slug]->terms_ids		= array();
					$terms_list[$taxonomy_slug]->terms_slugs	= array();
					$terms_list[$taxonomy_slug]->terms_links	= array();
					foreach ( $terms as $term ) {
						if ($taxonomy_slug=='category' && in_array($term->term_id, $args['exclude'])) continue;
						$term->link = get_term_link( $term->slug, $taxonomy_slug );
						$terms_list[$taxonomy_slug]->terms[]		= $term; 
						$terms_list[$taxonomy_slug]->terms_ids[] 	= $term->term_id;
						$terms_list[$taxonomy_slug]->terms_slugs[]	= $term->slug;
						$terms_list[$taxonomy_slug]->terms_links[]	= '<a class="'.esc_attr($taxonomy_slug).'_link" href="'.get_term_link($term->slug, $taxonomy_slug).'">'.($term->name).'</a>';
						if ($taxonomy_obj->hierarchical && empty($terms_list[$taxonomy_slug]->closest_parent)) {
							$terms_list[$taxonomy_slug]->closest_parent = $closest_method == 'parental' ? grace_church_get_parent_taxonomy($term->term_id, $args['parent_id'], $taxonomy_slug) : $term;
							if (!empty($terms_list[$taxonomy_slug]->closest_parent->slug))
								$terms_list[$taxonomy_slug]->closest_parent->link = get_term_link( $terms_list[$taxonomy_slug]->closest_parent->slug, $terms_list[$taxonomy_slug]->closest_parent->taxonomy );
						}
					}
					if (!$terms_list[$taxonomy_slug]->closest_parent && !empty($terms_list[$taxonomy_slug]->terms)) {
						$terms_list[$taxonomy_slug]->closest_parent = $terms_list[$taxonomy_slug]->terms[0];
					}					
				}
				if (count($args['taxonomy'])>0 && in_array($taxonomy_slug, $args['taxonomy'])) break;
			}
		}
		return $terms_list;
	}
}

// Return categories objects by post id
if (!function_exists('grace_church_get_categories_by_post_id')) {
	function grace_church_get_categories_by_post_id($args = array()) {
		if (!is_array($args)) $args = array('post_id' => $args);
		if (!isset($args['taxonomy'])) $args['taxonomy'] = 'category';
		return grace_church_get_terms_by_post_id($args);
	}
}

// Return tags objects by post id
if (!function_exists('grace_church_get_tags_by_post_id')) {
	function grace_church_get_tags_by_post_id($args = array()) {
		if (!is_array($args)) $args = array('post_id' => $args);
		if (!isset($args['taxonomy'])) $args['taxonomy'] = 'post_tag';
		return grace_church_get_terms_by_post_id($args);
	}
}


// Return terms objects by taxonomy name
if (!function_exists('grace_church_get_terms_by_taxonomy')) {
	function grace_church_get_terms_by_taxonomy($tax_types = 'post_format', $args=array()) {
		if (!is_array($tax_types)) $tax_types = array($tax_types);
		$terms = get_terms($tax_types, $args);
		if (is_array($terms) && count($terms) > 0) {
			foreach ($terms as $k=>$v)
				$terms[$k]->link = get_term_link($v->slug, $v->taxonomy);
		}
		return $terms;
	}
}

// Return id closest taxonomy to specified parent
if (!function_exists('grace_church_get_parent_taxonomy')) {
	function grace_church_get_parent_taxonomy($id, $parent_id=0, $taxonomy='category') {
		$val = null;
		do {
			$tax = get_term_by( 'id', $id, $taxonomy, OBJECT);
			if (empty($tax->parent) || $tax->parent==$parent_id) {
				$val = $tax;
				$val->link = get_term_link($val->slug, $val->taxonomy);
				break;
			}
			$id = $tax->parent;
		} while ($id);
		return $val;
	}
}

// Return id closest category to specified parent
if (!function_exists('grace_church_get_parent_category')) {
	function grace_church_get_parent_category($id, $parent_id=0) {
		return grace_church_get_parent_taxonomy($id, $parent_id, 'category');
	}
}

// Return id nearest (or highest) parent taxonomy with specified property in array values
if (!function_exists('grace_church_get_parent_taxonomy_by_property')) {
	function grace_church_get_parent_taxonomy_by_property($id, $prop, $values, $highest=true, $taxonomy='category') {
		if ((int) $id == 0) {
			$tax = get_term_by( 'slug', $id, $taxonomy, OBJECT);
			$id = $tax->term_id;
		}
		if (!is_array($values)) $values = array($values);
		$val = $id;
		do {
			if ($props = grace_church_taxonomy_load_custom_options($id, $taxonomy)) {
				if (isset($props[$prop]) && !empty($props[$prop]) && in_array($props[$prop], $values)) {
					$val = $id;
					if (!$highest) break;
				}
			}
			$tax = get_term_by( 'id', $id, $taxonomy, OBJECT);
			$id = $tax->parent;
		} while ($id);
		return $val;
	}
}

// Return id nearest (or highest) parent category with specified property in array values
if (!function_exists('grace_church_get_parent_category_by_property')) {
	function grace_church_get_parent_category_by_property($id, $prop, $values, $highest=true) {
		return grace_church_get_parent_taxonomy_by_property($id, $prop, $values, $highest, 'category');
	}
}

// Show categories, tags, post-formats filters for posts and attachments
if ( !function_exists( 'grace_church_show_taxonomies_filters' ) ) {
	function grace_church_show_taxonomies_filters() {
		if (grace_church_get_theme_option('admin_add_filters')!='yes') return;
		$page = get_query_var('post_type');
		if ($page == 'post')
			$taxes = array('post_format', 'post_tag');
		else if ($page == 'attachment')
			$taxes = array('media_folder');
		else
			return;
		echo trim(grace_church_get_terms_filters($taxes));
	}
}

// Return string with <select> tags for each taxonomy
if (!function_exists('grace_church_get_terms_filters')) {
	function grace_church_get_terms_filters($taxes) {
		$output = '';
		if (is_array($taxes) && count($taxes) > 0) {
			foreach ($taxes as $tax) {
				$list = get_transient("grace_church_terms_filter_".($tax));
				if (!$list) {
					$list = '';
					$tax_obj = get_taxonomy($tax);
					$terms = grace_church_get_terms_hierarchical_list(grace_church_get_terms_by_taxonomy($tax));
					if (is_array($terms) && count($terms) > 0) {
						$tax_slug = str_replace(array('post_tag'), array('tag'), $tax);
						$list .= "<select name='$tax_slug' id='$tax_slug' class='postform'>"
								.  "<option value=''>" . esc_html($tax_obj->labels->all_items) . "</option>";
						foreach ($terms as $slug=>$name) {
							$list .= '<option value='. esc_attr($slug) . (isset($_REQUEST[$tax_slug]) && $_REQUEST[$tax_slug] == $slug || (isset($_REQUEST['taxonomy']) && $_REQUEST['taxonomy'] == $tax_slug && isset($_REQUEST['term']) && $_REQUEST['term'] == $slug) ? ' selected="selected"' : '') . '>' . esc_html($name) . '</option>';
						}
						$list .=  "</select>";
					}
				}
				set_transient("grace_church_terms_filter_".($tax), $list, 0);
				$output .= $list;
			}
		}
		return $output;
	}
}

// Return terms list as hierarchical array
if (!function_exists('grace_church_get_terms_hierarchical_list')) {
	function grace_church_get_terms_hierarchical_list($terms, $opt=array()) {
		$opt = array_merge(array(
			'prefix_key' => '',
			'prefix_level' => '&nbsp;',
			'parent' => 0,
			'level' => ''
			), $opt);
		$rez = array();
		if (is_array($terms) && count($terms) > 0) {
			foreach ($terms as $term) {
				if ((is_object($term) ? $term->parent : $term['parent'])!=$opt['parent']) continue;
				$slug = is_object($term) ? $term->slug : $term['slug'];
				$name = is_object($term) ? $term->name : $term['name'];
				$count = is_object($term) ? $term->count : $term['count'];
				$rez[$opt['prefix_key'].($slug)] = ($opt['level'] ? $opt['level'].' ' : '').($name).($count ? ' ('.($count).')' : '');
				$rez = array_merge($rez, grace_church_get_terms_hierarchical_list($terms, array(
					'prefix_key' => $opt['prefix_key'],
					'prefix_level' => $opt['prefix_level'],
					'parent' => is_object($term) ? $term->term_id : $term['term_id'],
					'level' => ($opt['level']) . ($opt['prefix_level'])
					)
				));
			}
		}
		return $rez;
	}
}

// Clear all cache (when save or delete post)
if ( !function_exists( 'grace_church_clear_cache_all' ) ) {
	function grace_church_clear_cache_all($post_id=0, $post_obj=null) {
		delete_transient("grace_church_terms_filter_category");
		delete_transient("grace_church_terms_filter_post_tag");
		delete_transient("grace_church_terms_filter_post_format");
	}
}

// Clear categories cache (when create, edit or delete category)
if ( !function_exists( 'grace_church_clear_cache_categories' ) ) {
	function grace_church_clear_cache_categories($term_id=0) {
		delete_transient("grace_church_terms_filter_category");
	}
}



	
/* Show posts layout
------------------------------------------------------------------------------------- */

// Return merged parameters for show_post_layout() and get_post_data()
if (!function_exists('grace_church_get_post_data_options')) {
	function grace_church_get_post_data_options($opt) {
		$opt = array_merge(array(
			'layout' => '',				// Layout name - used to include layout file 'templates/xxx.php'
			'show' => true,				// Show layout into browser or return it as string
			'number' => 1,				// Post's number to detect even/odd and first/last classes
			'reviews' => true,			// Include Reviews marks into output array
			'counters' => grace_church_get_theme_option("blog_counters"),	// What counters use: views or comments
			'add_view_more' => false,	// Add "View more" link at end of the description
			'posts_on_page' => 1,		// How many posts queried
			'columns_count' => 3,		// How many posts output in one row
			'hover' => 'square effect_dir',	// Hover effect
			'hover_dir' => 'left_to_right',	// Hover direction
			'info' => true,				// Show info block in the layout
			'date_format' => '',		// PHP rule for date output. Can be split on two parts with sign '+'. For example: 'd M+Y' 
										// In the output array post_date="31 May 2014", post_date_part1="31 May", post_date_part2="2014"
			// Parameters for get_post_data()
			'sidebar' => !grace_church_param_is_off(grace_church_get_custom_option('show_sidebar_main')),	// Sidebar is visible on current page
			'readmore' => null,			// Text for the "Read more" link
			'strip_teaser' => grace_church_get_custom_option('show_text_before_readmore')!='yes',	// Strip text before <!--more--> tag in the content or show full content
			'substitute_gallery' => grace_church_get_custom_option('substitute_gallery')=='yes',	// Substitute standard WP gallery on theme slider
			'substitute_video'   => grace_church_get_custom_option('substitute_video')=='yes',		// Substitute tag <video> on the Youtube or Vimeo player
			'substitute_audio'   => grace_church_get_custom_option('substitute_audio')=='yes',		// Substitute tag <audio> on the Sound Cloud's player
			'parent_tax_id' => 0,		// Now showed category ID: if in the theme options 'close_category'='parental' - we detect closest category to this ID for each post
			'dedicated' => '',			// Dedicated content from the post (created with shortcode [trx_section dedicated="yes"]...[/trx_section]
			'location' => '',			// Location of the dedicated content or featured image: left|right|top
			'post_class' => '',			// Class for location above (used in the <div> or <article> with this post
			'content' => false,			// Do you need prepare full content for this post (do shortcodes, apply filters etc.) Usually need only for the single page
			'terms_list' => false		// Detect the full list of the post's terms (categories, tags, etc.)
		), $opt);
		if (empty($opt['layout'])) 
			$opt['layout'] = 'excerpt';
		return $opt;
	}
}

// Return post HTML-layout
if (!function_exists('grace_church_show_post_layout')) {
	function grace_church_show_post_layout($opt = array(), $post_data=null, $post_obj=null) {
		$opt = grace_church_get_post_data_options($opt);
		// Collect standard output
		$layout = '';
		$func_name = grace_church_get_template_function_name($opt['layout']);
		if (function_exists($func_name)) {
			if (!$opt['show']) ob_start();
			if ($post_data === null) {
				$post_data = grace_church_get_post_data($opt, $post_obj);
			}
			$layout = $func_name($opt, $post_data);
			if (!$opt['show'])  {
				$layout = ob_get_contents();
				ob_end_clean();
			}
			grace_church_clear_dedicated_content();
		}
		return $layout;
	}
}

// Return all post data as array
if (!function_exists('grace_church_get_post_data')) {
	function grace_church_get_post_data(&$opt, $post_obj=null) {
		$opt = grace_church_get_post_data_options($opt);
		global $post, $wp_query;
		$old_post = null;
		if (!empty($post) && is_object($post)) $old_post = clone $post;
		if ($post_obj != null) { $post = $post_obj; setup_postdata($post); }
		$cur_post = clone $post;
		$post_id = get_the_ID();
		$post_parent_id = wp_get_post_parent_id( $post_id );
		if ( !$post_parent_id ) $post_parent_id = 0;
		$post_type = get_post_type();
		$post_protected = post_password_required();
		$post_format = get_post_format();
		if (empty($post_format)) $post_format = 'standard';
		$post_icon = grace_church_get_custom_option('icon', grace_church_get_post_format_icon($post_format), $post_id, $post_type);	//!!!!! Get option from specified post
		$post_flags = array(
			'sticky' => is_sticky()
		);
		$post_link = get_permalink();
		$post_comments_link = get_comments_link();
		$post_date_sql = get_the_date('Y-m-d H:i:s');
		$post_date_stamp = get_the_date('U');
		$post_date = grace_church_get_date_or_difference($post_date_sql);
		if (!empty($opt['date_format'])) {
			$parts = explode('+', $opt['date_format']);
			$post_date_part1 = empty($parts[0]) ? '' : date($parts[0], $post_date_stamp);
			$post_date_part2 = empty($parts[1]) ? '' : date($parts[1], $post_date_stamp);
			if ( ($post_date_part1) . ($post_date_part2) != '' ) {
				$post_date = grace_church_get_date_translations($post_date_part1 . (!empty($post_date_part2) ? ' '.trim($post_date_part2) : ''));
			}
		}
	
		$post_comments = $post_views = $post_likes = 0;
		if ($opt['counters']!='') {
			$post_comments = get_comments_number();
			$post_views = grace_church_get_post_views($post_id);
			$post_likes = grace_church_get_post_likes($post_id);
		}
		$post_reviews_author = $post_reviews_users = 0;
		if ($opt['reviews']) {
			$post_reviews_author = grace_church_reviews_marks_to_display(get_post_meta($post_id, 'reviews_avg', true));
			$post_reviews_users  = grace_church_reviews_marks_to_display(get_post_meta($post_id, 'reviews_avg2', true));
		}
	
		$post_author = get_the_author();
		$post_author_id = get_the_author_meta('ID');
		$post_author_url = get_author_posts_url($post_author_id, '');
	
		// Is user can edit and/or delete this post?
		$allow_editor = grace_church_get_theme_option("allow_editor")=='yes';
		$post_edit_enable = $allow_editor && (
						($post_type=='post' && current_user_can('edit_posts', $post_id)) || 
						($post_type=='page' && current_user_can('edit_pages', $post_id))
						);
		$post_delete_enable = $allow_editor && (
						($post_type=='post' && current_user_can('delete_posts', $post_id)) || 
						($post_type=='page' && current_user_can('delete_pages', $post_id))
						);
	
		// Post content
		global $more;
		$old_more = $more;
		$more = -1;
		$post_content_original = trim(chop($post->post_content));
		$post_content_plain = trim(chop(get_the_content()));
		$more = $old_more;
		$post_content = trim(chop(get_the_content($opt['readmore'], $opt['strip_teaser'])));

		// Substitute WP [gallery] shortcode
		$thumb_sizes = grace_church_get_thumb_sizes(array(
			'layout' => $opt['layout']
		));
		if ($opt['content']) {
			if (!empty($post_content) && $opt['substitute_gallery'] && !grace_church_in_shortcode_blogger(true))	$post_content = grace_church_substitute_gallery($post_content, $post_id, $thumb_sizes['w'], 'none', true);
			$post_content = apply_filters('the_content', $post_content);
			if ($post_id != get_the_ID()) {		// Fix bug in the WPML
				$post = $cur_post;
				setup_postdata($post);
			}
			if (!empty($post_content)) {
				if ($opt['substitute_video'] && !grace_church_in_shortcode_blogger(true)) 	$post_content = grace_church_substitute_video($post_content, $thumb_sizes['w'], $thumb_sizes['h_crop']);
				if ($opt['substitute_audio'] && !grace_church_in_shortcode_blogger(true))	$post_content = grace_church_substitute_audio($post_content);
			}
		}

		// Post excerpt
		$post_excerpt_original = $post->post_excerpt;
		$post_excerpt = has_excerpt() || $post_protected ? get_the_excerpt() : '';
		if (empty($post_excerpt)) {
			if (($more_pos = grace_church_strpos($post_content_plain, '<span id="more-'))!==false) {
				$post_excerpt = grace_church_substr($post_content_plain, 0, $more_pos);
			} else {
				$post_excerpt = in_array($post_format, array('quote', 'link')) ? $post_content : strip_shortcodes(strip_tags(get_the_excerpt()));
			}
		}
		if (!empty($post_excerpt) && $opt['substitute_gallery'] && !grace_church_in_shortcode_blogger(true)) $post_excerpt = grace_church_substitute_gallery($post_excerpt, $post_id, $thumb_sizes['w'], $thumb_sizes['h_crop']);
		if (!empty($post_excerpt)) $post_excerpt = apply_filters('grace_church_filter_sc_clear_around', $post_excerpt);
		$post_excerpt = apply_filters('the_excerpt', $post_excerpt);
		if (!empty($post_excerpt)) {
			$post_excerpt = apply_filters('grace_church_filter_p_clear_around', $post_excerpt);
			if ($post_id != get_the_ID()) {		// Fix bug in the WPML
				$post = $cur_post;
				setup_postdata($post);
			}
			if ($opt['substitute_video'] && !grace_church_in_shortcode_blogger(true)) $post_excerpt = grace_church_substitute_video($post_excerpt, $thumb_sizes['w'], $thumb_sizes['h_crop']);
			if ($opt['substitute_audio'] && !grace_church_in_shortcode_blogger(true)) $post_excerpt = grace_church_substitute_audio($post_excerpt);
			$post_excerpt = trim(chop(str_replace(array('[...]', '[&hellip;]'), array('', ''), $post_excerpt)));
		}

		// Post Title
		$post_title = $post_title_plain = trim(chop(get_the_title()));
		$post_title = apply_filters('the_title',   $post_title);
		if ($post_id != get_the_ID()) {		// Fix bug in the WPML
			$post = $cur_post;
			setup_postdata($post);
		}

		// Prepare dedicated content
		$opt['dedicated'] = grace_church_get_dedicated_content();
		$opt['location']  = !empty($opt['location']) ? $opt['location'] : grace_church_get_custom_option('dedicated_location');
		if (empty($opt['location']) || $opt['location'] == 'default')
			$opt['location'] = grace_church_get_custom_option('dedicated_location', '', $post_id, $post_type);	//!!!!! Get option from specified post
		if ($opt['location']=='alter' && !is_single() && (!is_page() || isset($wp_query->is_posts_page) && $wp_query->is_posts_page==1)) {
			$loc = array('center', 'right', 'left');
			$opt['location'] = $loc[($opt['number']-1)%count($loc)];
		}
		if (!empty($opt['dedicated'])) {
			$class = grace_church_get_tag_attrib($opt['dedicated'], '<div class="sc_section>', 'class');
			if ($opt['location']=='default') {
				if (($pos = grace_church_strpos($class, 'sc_align'))!==false) {
					$pos += 8;
					$pos2 = grace_church_strpos($class, ' ', $pos);
					$opt['location'] = $pos2===false ? grace_church_substr($class, $pos) : grace_church_substr($class, $pos, $pos2-$pos);
				}
				if ($opt['location']=='' || $opt['location']=='default') $opt['location'] = 'center';
			}
			if (!is_singular() || grace_church_get_global('blog_streampage') || grace_church_in_shortcode_blogger(true) || (grace_church_strpos($class, 'sc_align')!==false && grace_church_strpos($class, 'columns')===false)) {
				$class = str_replace(array('sc_alignright', 'sc_alignleft', 'sc_aligncenter'), array('','',''), $class) . ' sc_align' . esc_attr($opt['location']);
				//if ($opt['location'] == 'center' && grace_church_strpos($class, 'column-2_3')===false && $opt['sidebar'])
				//	$class = str_replace('columns', '_columns', $class) . ' column-2_3';
				//else if (($opt['location'] == 'left' || $opt['location'] == 'right') && grace_church_strpos($class, 'column-1_2')===false)// && $opt['sidebar'])
				//	$class = str_replace('columns', '_columns', $class) . ' column-1_2';
				$opt['dedicated'] = grace_church_set_tag_attrib($opt['dedicated'], '<div class="sc_section>', 'class', $class);
			}
		} //else if ($opt['location']=='' || $opt['location']=='default')
			//$opt['location'] = 'center';
		//if ($opt['location']=='default') $opt['location']='center';
		$opt['post_class'] = $opt['location'];
		// Substitute <video> tags to <iframe> in dedicated content
		if ($opt['substitute_video'] && !grace_church_in_shortcode_blogger(true)) {
			$opt['dedicated'] = grace_church_substitute_video($opt['dedicated'], $thumb_sizes['w'], $thumb_sizes['h_crop']);
		}
		// Substitute <audio> tags with src from soundcloud to <iframe>
		if ($opt['substitute_audio'] && !grace_church_in_shortcode_blogger(true)) {
			$opt['dedicated'] = grace_church_substitute_audio($opt['dedicated']);
		}

		// Extract gallery, video and audio from full post content
		$post_thumb = $post_thumb_url = $post_attachment = $post_gallery = $post_video = $post_video_image = $post_audio = $post_audio_image = $post_url = $post_url_target = '';
		$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
		if (grace_church_substr($opt['layout'], 0, 6)=='single')
			$post_thumb = grace_church_get_resized_image_tag($post_id, $thumb_sizes['w'], $thumb_sizes['h'], null, false, false, true);
		else if (grace_church_substr($opt['layout'], 0, 10)=='attachment')
			$post_thumb = grace_church_get_resized_image_tag($post_attachment, $thumb_sizes['w'], $thumb_sizes['h'], null, false, false, true);
		else
			$post_thumb = grace_church_get_resized_image_tag($post_id, $thumb_sizes['w'], $post_type=='product' && grace_church_get_theme_option('crop_product_thumb')=='no' ? null :  $thumb_sizes['h']);
		$post_thumb_url = grace_church_get_tag_attrib($post_thumb, '<img>', 'src');
		if ($post_format == 'gallery') {
			$post_gallery = grace_church_build_gallery_tag(grace_church_get_post_gallery($post_content_plain, $post_id, max(2, grace_church_get_custom_option('gallery_max_slides'))), $thumb_sizes['w'], false, $post_link);
		} else if ($post_format == 'video') {
			$src = '';
			$post_video = grace_church_get_post_video($post_content_original, false);
			if ($post_video=='') {
				$src = grace_church_get_post_video($post_content_original, true);
				if (!grace_church_is_youtube_url($src) && !grace_church_is_vimeo_url($src))
					$src = '';
			} else {
				if (grace_church_substr($post_video, 0, 1)=='[') {
					$src = grace_church_get_tag_attrib($post_video, '[trx_video]', 'src');
					if (empty($src)) $src = grace_church_get_tag_attrib($post_video, '[trx_video]', 'url');
					if (empty($src)) $src = grace_church_get_post_video($post_video, true);
					$post_video_image = grace_church_get_tag_attrib($post_video, '[trx_video]', 'image');
					if ($post_video_image > 0) {
						$attach = wp_get_attachment_image_src( $post_video_image, 'full' );
						if (isset($attach[0]) && $attach[0]!='')
							$post_video_image = $attach[0];
					}
					if (!is_singular() || grace_church_get_global('blog_streampage')) {
						if (empty($post_video_image))
							$post_video_image = $post_thumb;
						if (empty($post_video_image))
							$post_video_image = grace_church_get_video_cover_image($src);
					}
					if (!empty($post_video_image))
						$post_video_image = grace_church_get_resized_image_tag($post_video_image, $thumb_sizes['w'], $thumb_sizes['h']);
				} else
					$src = grace_church_get_post_video($post_video, true);
			}
			if ($src) {
				$src = grace_church_get_video_player_url($src, $post_thumb!='' || $post_video_image!='');
				$post_video = '<video src="'.esc_url($src).'" width="'.esc_attr($thumb_sizes['w']).'" height="'.round($thumb_sizes['w']/16*9).'"></video>';
			}
			if ($post_video!='' && $opt['substitute_video']) {	// && !grace_church_in_shortcode_blogger(true)) {
				$post_video = grace_church_substitute_video($post_video, $thumb_sizes['w'], round($thumb_sizes['w']/16*9), false);	//$thumb_sizes['h_crop']);
			}
		} else if ($post_format == 'audio') {
			$src = $data = '';
			$post_audio = grace_church_get_post_audio($post_content_original, false);
			if ($post_audio=='') {
				$src = grace_church_get_post_audio($post_content_original, true);
			} else {
				if (grace_church_substr($post_audio, 0, 1)=='[') {
					$src = grace_church_get_tag_attrib($post_audio, '[trx_audio]', 'src');
					if (empty($src)) $src = grace_church_get_tag_attrib($post_audio, '[trx_audio]', 'url');
					if (empty($src)) $src = grace_church_get_post_audio($post_audio, true);
					$post_audio_image = grace_church_get_tag_attrib($post_audio, '[trx_audio]', 'image');
					if ($post_audio_image > 0) {
						$attach = wp_get_attachment_image_src( $post_audio_image, 'full' );
						if (isset($attach[0]) && $attach[0]!='')
							$post_audio_image = $attach[0];
					}
					if (empty($post_audio_image))
						$post_audio_image = $post_thumb;
					if ($post_audio_image)
						$post_audio_image = grace_church_get_resized_image_url($post_audio_image, $thumb_sizes['w'], $thumb_sizes['h']);
					$post_audio_title  = grace_church_get_tag_attrib($post_audio, '[trx_audio]', 'title');
					$post_audio_author = grace_church_get_tag_attrib($post_audio, '[trx_audio]', 'author');
					$data = ($post_audio_title != ''  ? ' data-title="'.esc_attr($post_audio_title).'"'   : '')
						   .($post_audio_author != '' ? ' data-author="'.esc_attr($post_audio_author).'"' : '')
						   .($post_audio_image != ''  ? ' data-image="'.esc_attr($post_audio_image).'"'   : '');
				} else
					$src = grace_church_get_post_audio($post_audio, true);
			}
			if ($src) {
				$post_audio = '<audio class="sc_audio" src="'.esc_url($src).'"'
					. ($data)
					. '></audio>';
			}
			if ($post_audio!='' && $opt['substitute_audio']) {	// && !grace_church_in_shortcode_blogger(true)) {
				$post_audio = grace_church_substitute_audio($post_audio, false);
			}
		}
		if ($post_format == 'image' && !$post_thumb && !is_single()) {
			if (($src = grace_church_get_post_image($post_content_original, $post_id))!='')
				$post_thumb = grace_church_get_resized_image_tag($src, $thumb_sizes['w'], $thumb_sizes['h_crop']);
		}
		if ($post_format == 'link') {
			$post_url_data = grace_church_get_post_link($post_content_original, false);
			$post_link = $post_url = $post_url_data['url'];
			$post_url_target = $post_url_data['target'];
		}

		// Get all post's terms
		$post_taxonomy = grace_church_get_taxonomy_categories_by_post_type($post_type);
		$post_taxonomy_tags = grace_church_get_taxonomy_tags_by_post_type($post_type);
		$post_terms = array();
		if ($opt['terms_list']) {
			$post_terms = grace_church_get_terms_by_post_id( array(
				'post_id' 	=> $post_id,
				'parent_id'	=> $post_type=='post' ? $opt['parent_tax_id'] : 0,
				'exclude'	=> $post_type=='post' ? explode(',', grace_church_get_theme_option('exclude_cats')) : array()
				)
			);
		}

		if ($old_post != null) { $post = $old_post; setup_postdata($post); }
		
		$post_data = compact('post_id', 'post_parent_id', 'post_protected', 'post_type', 'post_taxonomy', 'post_taxonomy_tags', 'post_format', 'post_flags', 'post_icon', 'post_link', 'post_comments_link', 'post_date_sql', 'post_date_stamp', 'post_date', 'post_date_part1', 'post_date_part2', 'post_comments', 'post_views', 'post_likes', 'post_reviews_author', 'post_reviews_users', 'post_author', 'post_author_id', 'post_author_url', 'post_title', 'post_title_plain', 'post_content_plain', 'post_content_original', 'post_content', 'post_excerpt_original', 'post_excerpt', 'post_thumb', 'post_thumb_url', 'post_attachment', 'post_gallery', 'post_video', 'post_video_image', 'post_audio', 'post_audio_image', 'post_url', 'post_url_target', 'post_terms', 'post_edit_enable', 'post_delete_enable');
	
		return apply_filters('grace_church_filter_get_post_data', $post_data, $opt, $post_obj);
	}
}

// Return custom_page_heading (if set), else - post title
if (!function_exists('grace_church_get_post_title')) {
	function grace_church_get_post_title($id = 0, $maxlength = 0, $add='...') {
		global $wp_query;
		if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$title = get_the_title($id);
		if ($maxlength > 0) $title = grace_church_strshort($title, $maxlength, $add);
		return $title;
	}
}

// Return post excerpt
if (!function_exists('grace_church_get_post_excerpt')) {
	function grace_church_get_post_excerpt($maxlength = 0, $add='...') {
		$descr = get_the_excerpt();
		$descr = trim(str_replace(array('[...]', '[&hellip;]'), array($add, $add), $descr));
		if (!empty($descr) && grace_church_strpos(',.:;-', grace_church_substr($descr, -1))!==false) $descr = grace_church_substr($descr, 0, -1);
		if ($maxlength > 0) $descr = grace_church_strshort($descr, $maxlength, $add);
		return $descr;
	}
}

//Return Post Views Count
if (!function_exists('grace_church_get_post_views')) {
	function grace_church_get_post_views($id=0){
		global $wp_query;
		if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$count_key = 'post_views_count';
		$count = get_post_meta($id, $count_key, true);
		if ($count===''){
			delete_post_meta($id, $count_key);
			add_post_meta($id, $count_key, '0');
			$count = 0;
		}
		return $count;
	}
}

//Set Post Views Count
if (!function_exists('grace_church_set_post_views')) {
	function grace_church_set_post_views($id=0, $counter=-1) {
		global $wp_query;
		if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$count_key = 'post_views_count';
		$count = get_post_meta($id, $count_key, true);
		if ($count===''){
			delete_post_meta($id, $count_key);
			add_post_meta($id, $count_key, 1);
		} else {
			$count = $counter >= 0 ? $counter : $count+1;
			update_post_meta($id, $count_key, $count);
		}
	}
}

//Return Post Likes Count
if (!function_exists('grace_church_get_post_likes')) {
	function grace_church_get_post_likes($id=0){
		global $wp_query;
		if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$count_key = 'post_likes_count';
		$count = get_post_meta($id, $count_key, true);
		if ($count===''){
			delete_post_meta($id, $count_key);
			add_post_meta($id, $count_key, '0');
			$count = 0;
		}
		return $count;
	}
}

//Set Post Likes Count
if (!function_exists('grace_church_set_post_likes')) {
	function grace_church_set_post_likes($id=0, $count=0) {
		global $wp_query;
		if (!$id) $id = $wp_query->current_post>=0 ? get_the_ID() : $wp_query->post->ID;
		$count_key = 'post_likes_count';
		update_post_meta($id, $count_key, $count);
	}
}


// Set post likes/views counters when save/publish post
// add_action('save_post',		'grace_church_init_post_counters');
// add_action('publish_post',	'grace_church_init_post_counters');
if ( !function_exists( 'grace_church_init_post_counters' ) ) {
	function grace_church_init_post_counters($id) {
		grace_church_get_post_views($id);
		grace_church_get_post_likes($id);
	}
}


// AJAX: Set post likes/views count
// add_action('wp_ajax_post_counter', 			'grace_church_callback_post_counter');
// add_action('wp_ajax_nopriv_post_counter',	'grace_church_callback_post_counter');
if ( !function_exists( 'grace_church_callback_post_counter' ) ) {
	function grace_church_callback_post_counter() {
		global $_REQUEST, $GRACE_CHURCH_GLOBALS;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
			die();
	
		$response = array('error'=>'');
		
		$id = (int) $_REQUEST['post_id'];
		if (isset($_REQUEST['likes'])) {
			$counter = max(0, (int) $_REQUEST['likes']);
			grace_church_set_post_likes($id, $counter);
		} else if (isset($_REQUEST['views'])) {
			$counter = max(0, (int) $_REQUEST['views']);
			grace_church_set_post_views($id, $counter);
		}
		echo json_encode($response);
		die();
	}
}




/* Query manipulations
------------------------------------------------------------------------------------- */

// Pre query: Add filter to main query
if ( !function_exists( 'grace_church_query_posts_where' ) ) {
	// add_filter('posts_where', 'grace_church_query_posts_where', 10, 2);
	function grace_church_query_posts_where($where, $query) {
		global $wpdb; 
		if (is_admin() || $query->is_attachment) return $where;
		if (grace_church_strpos($where, 'post_status')===false && (!isset($_REQUEST['preview']) || $_REQUEST['preview']!='true') && (!isset($_REQUEST['vc_editable']) || $_REQUEST['vc_editable']!='true')) {
			if (current_user_can('read_private_pages') && current_user_can('read_private_posts'))
				$where .= " AND (" . esc_sql($wpdb->posts) . ".post_status='publish' OR " . esc_sql($wpdb->posts) . ".post_status='private')";
			else
				$where .= " AND " . esc_sql($wpdb->posts) . ".post_status='publish'";
		}
		return $where;
	}  
}

// Pre query: Add posts per page into query
if ( !function_exists( 'grace_church_query_add_posts_per_page' ) ) {
	// add_action( 'pre_get_posts', 'grace_church_query_add_posts_per_page' );
	function grace_church_query_add_posts_per_page($query) {
		if (is_admin() || !$query->is_main_query()) return;

		$orderby_set = true;
		$orderby = $order = $ppp = '';

		// Check template page settings
		if ($query->get('post_type')=='product' || $query->get('product_cat')!='' || $query->get('product_tag')!='') {
			$orderby_set = false;
			$page_id = get_option('woocommerce_shop_page_id');
		} else if ($query->is_archive()) {
			$page_id = grace_church_get_template_page_id('archive');
		} else if ($query->is_search()) {
			$page_id = grace_church_get_template_page_id('search');
			if (grace_church_get_theme_option('use_ajax_search')=='yes') {
				$show_types = grace_church_get_theme_option('ajax_search_types');
				if (!empty($show_types)) 
					$query->set('post_type', explode(',', $show_types));
			}
		} else if ($query->is_posts_page==1) {
			$page_id = isset($query->queried_object_id) ? $query->queried_object_id : grace_church_get_template_page_id('blog');
		} else {
			$orderby_set = false;
			$page_id = 0;
		}
		if ($page_id > 0) {
			$post_options = get_post_meta($page_id, 'post_custom_options', true);
			if (isset($post_options['posts_per_page']) && !empty($post_options['posts_per_page']) && !grace_church_is_inherit_option($post_options['posts_per_page'])) {
				$ppp = (int) $post_options['posts_per_page'];
			}
			if ($orderby_set) {
				if (isset($post_options['blog_sort']) && !empty($post_options['blog_sort']) && !grace_church_is_inherit_option($post_options['blog_sort']))
					$orderby = $post_options['blog_sort'];
				if (isset($post_options['blog_order']) && !empty($post_options['blog_order']) && !grace_church_is_inherit_option($post_options['blog_order']))
					$order = $post_options['blog_order'];
			}
		}

		// Check taxonomy settings
		if ( !empty($query->tax_query->queried_terms) && is_array($query->tax_query->queried_terms) ) {
			foreach($query->tax_query->queried_terms as $tax=>$terms) {
				if (!empty($terms['terms'][0])) {
					$term = $terms['terms'][0];
					$tax_options = grace_church_taxonomy_get_inherited_properties($tax, $term);
					if (empty($ppp) && isset($tax_options['posts_per_page']) && !empty($tax_options['posts_per_page']) && !grace_church_is_inherit_option($tax_options['posts_per_page'])) {
						$ppp = (int) $tax_options['posts_per_page'];
					}
					if ($orderby_set) {
						if (isset($tax_options['blog_sort']) && !empty($tax_options['blog_sort']) && !grace_church_is_inherit_option($tax_options['blog_sort']))
							$orderby = $tax_options['blog_sort'];
						if (isset($tax_options['blog_order']) && !empty($tax_options['blog_order']) && !grace_church_is_inherit_option($tax_options['blog_order']))
							$order = $tax_options['blog_order'];
					}
				}
				break;
			}
		}

		// Add parameters into query
		if (empty($ppp))
			$ppp = (int) grace_church_get_theme_option('posts_per_page');
		if ($ppp > 0)
			$query->set('posts_per_page', $ppp );

		if ($orderby_set) {
			if (empty($orderby))
				$orderby = grace_church_get_theme_option('blog_sort');
			if (empty($order))
				$order = grace_church_get_theme_option('blog_order');
			 grace_church_query_add_sort_order($query, $orderby, $order);
		}
		
		// Exclude categories
		$ex = grace_church_get_theme_option('exclude_cats');
		if (!empty($ex))
			$query->set('category__not_in', explode(',', $ex) );
	}
}

// Filter categories list - exclude unwanted cats from widget output
// add_action( 'widget_categories_args', 			'grace_church_query_exclude_categories' );
// add_action( 'widget_categories_dropdown_args',	'grace_church_query_exclude_categories' );
if ( !function_exists( 'grace_church_query_exclude_categories' ) ) {
	function grace_church_query_exclude_categories($args) {
		if (!is_admin()) {
			$ex = grace_church_get_theme_option('exclude_cats');
			if (!empty($ex))
				$args['exclude'] = $ex;
		}
		return $args;
	}
}
//add_action( 'widget_posts_args', 'grace_church_query_exclude_posts' );
if ( !function_exists( 'grace_church_query_exclude_posts' ) ) {
	function grace_church_query_exclude_posts($args) {
		if (!is_admin()) {
			$ex = grace_church_get_theme_option('exclude_cats');
			if (!empty($ex)) {
				$args['category__not_in'] = explode(',', $ex);
			}
		}
		return $args;
	}
}

// Add sorting parameter in query arguments
if (!function_exists('grace_church_query_add_sort_order')) {
	function grace_church_query_add_sort_order($args, $orderby='', $order='') {
		if (empty($order)) $order = grace_church_get_custom_option('blog_order');
		if (empty($orderby)) $orderby = grace_church_get_custom_option('blog_sort');
		$q = array();
		$q['order'] = $order=='asc' ? 'asc' : 'desc';
		if ($orderby == 'author_rating') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'reviews_avg';
			$q['meta_query'] = array(
				array(
					'meta_filter' => 'reviews',
					'key' => 'reviews_avg',
					'value' => 0,
					'compare' => '>=',
					'type' => 'NUMERIC'
				   )
			);
		} else if ($orderby == 'users_rating') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'reviews_avg2';
			$q['meta_query'] = array(
				array(
					'meta_filter' => 'reviews',
					'key' => 'reviews_avg2',
					'value' => 0,
					'compare' => '>=',
					'type' => 'NUMERIC'
				   )
			);
		} else if ($orderby == 'views') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'post_views_count';
		} else if ($orderby == 'comments') {
			$q['orderby'] = 'comment_count';
		} else if ($orderby == 'title' || $orderby == 'alpha') {
			$q['orderby'] = 'title';
		} else if ($orderby == 'rand' || $orderby == 'random')  {
			$q['orderby'] = 'rand';
		} else {
			$q['orderby'] = 'post_date';
		}
		foreach ($q as $mk=>$mv) {
			if (is_array($args))
				$args[$mk] = $mv;
			else
				$args->set($mk, $mv);
		}
		return $args;
	}
}

// Add post type and posts list or categories list in query arguments
if (!function_exists('grace_church_query_add_posts_and_cats')) {
	function grace_church_query_add_posts_and_cats($args, $ids='', $post_type='', $cat='', $taxonomy='') {
		if (!empty($ids)) {
			$args['post_type'] = empty($args['post_type']) 
									? (empty($post_type) ? array('post', 'page') : $post_type)
									: $args['post_type'];
			$args['post__in'] = explode(',', str_replace(' ', '', $ids));
		} else {
			$args['post_type'] = empty($args['post_type']) 
									? (empty($post_type) ? 'post' : $post_type)
									: $args['post_type'];
			$post_type = is_array($args['post_type']) ? $args['post_type'][0] : $args['post_type'];
			if (!empty($cat)) {
				$cats = !is_array($cat) ? explode(',', $cat) : $cat;
				if (empty($taxonomy))
					$taxonomy = grace_church_get_taxonomy_categories_by_post_type($post_type);
				if ($taxonomy == 'category') {				// Add standard categories
					if (is_array($cats) && count($cats) > 1) {
						$cats_ids = array();
						foreach($cats as $c) {
							$c = trim(chop($c));
							if (empty($c)) continue;
							if ((int) $c == 0) {
								$cat_term = get_term_by( 'slug', $c, $taxonomy, OBJECT);
								if ($cat_term) $c = $cat_term->term_id;
							}
							if ($c==0) continue;
							$cats_ids[] = (int) $c;
							$children = get_categories( array(
								'type'                     => $post_type,
								'child_of'                 => $c,
								'hide_empty'               => 0,
								'hierarchical'             => 0,
								'taxonomy'                 => $taxonomy,
								'pad_counts'               => false
							));
							if (is_array($children) && count($children) > 0) {
								foreach($children as $c) {
									if (!in_array((int) $c->term_id, $cats_ids)) $cats_ids[] = (int) $c->term_id;
								}
							}
						}
						if (count($cats_ids) > 0) {
							$args['category__in'] = $cats_ids;
						}
					} else {
						if ((int) $cat > 0) 
							$args['cat'] = (int) $cat;
						else
							$args['category_name'] = $cat;
					}
				} else {									// Add custom taxonomies
					if (!isset($args['tax_query']))
						$args['tax_query'] = array();
					$args['tax_query']['relation'] = 'AND';
					$args['tax_query'][] = array(
						'taxonomy' => $taxonomy,
						'include_children' => true,
						'field'    => (int) $cats[0] > 0 ? 'id' : 'slug',
						'terms'    => $cats
					);
				}
			}
		}
		return $args;
	}
}

// Add filters (meta parameters) in query arguments
if (!function_exists('grace_church_query_add_filters')) {
	function grace_church_query_add_filters($args, $filters=false) {
		if (!empty($filters)) {
			if (!is_array($filters)) $filters = array($filters);
			foreach ($filters as $v) {
				$found = false;
				if (in_array($v, array('reviews', 'thumbs'))) {							// Filter with meta_query
					if (!isset($args['meta_query']))
						$args['meta_query'] = array();
					else {
						for ($i=0; $i<count($args['meta_query']); $i++) {
							if ($args['meta_query'][$i]['meta_filter'] == $v) {
								$found = true;
								break;
							}
						}
					}
					if (!$found) {
						$args['meta_query']['relation'] = 'AND';
						if ($v == 'reviews') {
							$args['meta_query'][] = array(
								'meta_filter' => $v,
								'key' => 'reviews_avg'.(grace_church_get_theme_option('reviews_first')=='author' ? '' : '2'),
								'value' => 0,
								'compare' => '>',
								'type' => 'NUMERIC'
							);
						} else if ($v == 'thumbs') {
							$args['meta_query'][] = array(
								'meta_filter' => $v,
								'key' => '_thumbnail_id',
								'value' => false,
								'compare' => '!='
							);
						}
					}
				} else if (in_array($v, array('video', 'audio', 'gallery'))) {			// Filter with tax_query
					if (!isset($args['tax_query']))
						$args['tax_query'] = array();
					else {
						for ($i=0; $i<count($args['tax_query']); $i++) {
							if ($args['tax_query'][$i]['tax_filter'] == $v) {
								$found = true;
								break;
							}
						}
					}
					if (!$found) {
						$args['tax_query']['relation'] = 'AND';
						if ($v == 'video') {
							$args['tax_query'][] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-video' )
							);
						} else if ($v == 'audio') {
							$args['tax_query'] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-audio' )
							);
						} else if ($v == 'gallery') {
							$args['tax_query'] = array(
								'tax_filter' => $v,
								'taxonomy' => 'post_format',
								'field' => 'slug',
								'terms' => array( 'post-format-gallery' )
							);
						}
					}
				} else
					$args = apply_filters('grace_church_filter_query_add_filters', $args, $v);
			}
		}
		//if (empty($args['post_type'])) $args['post_type'] = 'post';
		return $args;
	}
}


	
/* Users utils
------------------------------------------------------------------------------------- */

// Check current user (or user with specified ID) role
// For example: if (grace_church_check_user_role('author')) { ... }
if (!function_exists('grace_church_check_user_role')) {
	function grace_church_check_user_role( $role, $user_id = null ) {
		if ( is_numeric( $user_id ) )
			$user = get_userdata( $user_id );
		else
			$user = wp_get_current_user();
		if ( empty( $user ) )
			return false;
		return in_array( $role, (array) $user->roles );
	}
}


// AJAX: New user registration
// add_action('wp_ajax_registration_user',			'grace_church_callback_registration_user');
// add_action('wp_ajax_nopriv_registration_user',	'grace_church_callback_registration_user');
if ( !function_exists( 'grace_church_callback_registration_user' ) ) {
	function grace_church_callback_registration_user() {
		global $_REQUEST, $GRACE_CHURCH_GLOBALS;
	
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) ) {
			die();
		}
	
		$user_name  = grace_church_substr($_REQUEST['user_name'], 0, 20);
		$user_email = grace_church_substr($_REQUEST['user_email'], 0, 60);
		$user_pwd   = grace_church_substr($_REQUEST['user_pwd'], 0, 20);
	
		$response = array('error' => '');
	
		$id = wp_insert_user( array ('user_login' => $user_name, 'user_pass' => $user_pwd, 'user_email' => $user_email) );
		if ( is_wp_error($id) ) {
			$response['error'] = $id->get_error_message();
		} else if (($notify = grace_church_get_theme_option('notify_about_new_registration'))!='no' && (($contact_email = grace_church_get_theme_option('contact_email')) || ($contact_email = grace_church_get_theme_option('admin_email')))) {
			$mail = grace_church_get_theme_option('mail_function');
			if (in_array($notify, array('both', 'admin', 'yes'))) {
				$subj = sprintf( esc_html__('Site %s - New user registration: %s', 'grace-church'), esc_html(get_bloginfo('site_name')), esc_html($user_name));
				$msg = "\n". esc_html__('New registration:', 'grace-church')
					."\n". esc_html__('Name:', 'grace-church').' '.esc_html($user_name)
					."\n". esc_html__('E-mail:', 'grace-church').' '.esc_html($user_email)
					."\n\n............ " . esc_html(get_bloginfo('site_name')) . " (" . esc_html(home_url('/')) . ") ............";
				$head = "Content-Type: text/plain; charset=\"utf-8\"\n"
					. "X-Mailer: PHP/" . phpversion() . "\n"
					. "Reply-To: " . sanitize_text_field($user_email) . "\n"
					. "To: " . sanitize_text_field($contact_email) . "\n"
					. "From: " . sanitize_text_field($user_email) . "\n"
					. "Subject: " . sanitize_text_field($subj) . "\n";
				@$mail($contact_email, $subj, $msg, $head);
			}
			if (in_array($notify, array('both', 'user', 'yes'))) {
				$subj = sprintf( esc_html__('Welcome to "%s"', 'grace-church'), get_bloginfo('site_name'));
				$msg = "\n". esc_html__('Your registration data:', 'grace-church')
					."\n". esc_html__('Name:', 'grace-church').' '.esc_html($user_name)
					."\n". esc_html__('E-mail:', 'grace-church').' '.esc_html($user_email)
					."\n". esc_html__('Password:', 'grace-church').' '.esc_html($user_pwd)
					."\n\n............ " . esc_html(get_bloginfo('site_name')) . " (<a href=\"" . esc_url( home_url('/') ) . "\">" . esc_html(home_url('/')) . "</a>) ............";
				$head = "Content-Type: text/plain; charset=\"utf-8\"\n"
					. "X-Mailer: PHP/" . phpversion() . "\n"
					. "Reply-To: " . sanitize_text_field($contact_email) . "\n"
					. "To: " . sanitize_text_field($user_email) . "\n"
					. "From: " . sanitize_text_field($contact_email) . "\n"
					. "Subject: " . sanitize_text_field($subj) . "\n";
				@$mail($user_email, $subj, $msg, $head);
			}
		}

		echo json_encode($response);
		die();
	}
}



// AJAX: Login user
// add_action('wp_ajax_login_user',			'grace_church_callback_login_user');
// add_action('wp_ajax_nopriv_login_user',	'grace_church_callback_login_user');
if ( !function_exists( 'grace_church_callback_login_user' ) ) {
	function grace_church_callback_login_user() {
		global $_REQUEST, $GRACE_CHURCH_GLOBALS;
	
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) ) {
			die();
		}
	
		$user_log = grace_church_substr($_REQUEST['user_log'], 0, 60);
		$user_pwd = grace_church_substr($_REQUEST['user_pwd'], 0, 20);
		$remember = grace_church_substr($_REQUEST['remember'], 0, 7)=='forever';

		$response = array('error' => '');

		if ( is_email( $user_log ) ) {
			$user = get_user_by('email', $user_log );
			if ( $user ) $user_log = $user->user_login;
		}

		$rez = wp_signon( array(
			'user_login' => $user_log,
			'user_password' => $user_pwd,
			'remember' => $remember
			), false );

		if ( is_wp_error($rez) ) {
			$response['error'] = $rez->get_error_message();
		}

		echo json_encode($response);
		die();
	}
}


// User login by name or email
if ( !function_exists( 'grace_church_allow_email_login' ) ) {
	function grace_church_allow_email_login( $user, $username, $password ) {
		if ( is_email( $username ) ) {
			$user = get_user_by('email', $username );
			if ( $user ) $username = $user->user_login;
		}
		return wp_authenticate_username_password( null, $username, $password );
	}
}



	
/* Nav menu utils
------------------------------------------------------------------------------------- */
if ( !function_exists( 'grace_church_get_nav_menu' ) ) {
	function grace_church_get_nav_menu($slug='', $custom_walker=false) {
		$menu = !empty($slug) ? grace_church_get_custom_option($slug) : '';
		$args = array(
			'menu'				=> empty($menu) || $menu=='default' || grace_church_is_inherit_option($menu) ? '' : $menu,
			'container'			=> '',
			'container_class'	=> '',
			'container_id'		=> '',
			'items_wrap'		=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'menu_class'		=> (!empty($slug) ? $slug : 'menu_main') . '_nav',
			'menu_id'			=> (!empty($slug) ? $slug : 'menu_main'),
			'echo'				=> false,
			'fallback_cb'		=> '',
			'before'			=> '',
			'after'				=> '',
			'link_before'       => '',
			'link_after'        => '',
			'depth'             => 11
		);
		if (!empty($slug))
			$args['theme_location'] = $slug;
		if ($custom_walker && class_exists('grace_church_custom_menu_walker') && grace_church_get_theme_option('custom_menu')=='yes')
			$args['walker'] = new grace_church_custom_menu_walker;
		return wp_nav_menu($args);
	}
}



	
/* Theme required shortcodes, types and taxes
------------------------------------------------------------------------------------- */

// Register theme required types and taxes
// Moved into plugin
if (false && !function_exists('grace_church_require_data')) {
	function grace_church_require_data( $type, $name, $args) {
		$fn = join('_', array('register', $type));
		if ($type == 'taxonomy')
			@$fn($name, $args['post_type'], $args);
		else
			@$fn($name, $args);
	}
}

// Register theme required shortcodes
// Moved into plugin
if (false && !function_exists('grace_church_require_shortcode')) {
	function grace_church_require_shortcode( $name, $callback) {
		$fn = join('_', array('add', 'shortcode'));
		@$fn($name, $callback);
	}
}




	
/* Other WP utils
------------------------------------------------------------------------------------- */

// Clear WP cache callback
if ( !function_exists( 'grace_church_callback_clear_cache' ) ) {
	function grace_church_callback_clear_cache() {
		global $_REQUEST, $GRACE_CHURCH_GLOBALS;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], $GRACE_CHURCH_GLOBALS['ajax_url'] ) )
			die();

		$response = array('error'=>'');

		grace_church_clear_cache('all');

		echo json_encode($response);
		die();
	}
}

// Clear WP cache (all, options or categories)
if (!function_exists('grace_church_clear_cache')) {
	function grace_church_clear_cache($cc) {
		if ($cc == 'categories' || $cc == 'all') {
			wp_cache_delete('category_children', 'options');
			$taxes = get_taxonomies();
			if (is_array($taxes) && count($taxes) > 0) {
				foreach ($taxes  as $tax ) {
					delete_option( "{$tax}_children" );
					_get_term_hierarchy( $tax );
				}
			}
		} else if ($cc == 'options' || $cc == 'all')
			wp_cache_delete('alloptions', 'options');
		if ($cc == 'all')
			wp_cache_flush();
	}
}




	
/* Shortcodes utils
------------------------------------------------------------------------------------- */

// Return do_shortcode() if exists
if (!function_exists('grace_church_do_shortcode')) {
	function grace_church_do_shortcode($text) {
		$parts = explode(' ', $text, 2);
		if (grace_church_substr($parts[0], 0, 5)!=='[trx_' || shortcode_exists(str_replace(array('[', ']'), array('', ''), $parts[0])))
			return do_shortcode($text);
		else
			return '';
	}
}

// Check params for "on" | "off" | "inherit" values
if (!function_exists('grace_church_param_is_on')) {
	function grace_church_param_is_on($prm) {
		return $prm>0 || in_array(grace_church_strtolower($prm), array('true', 'on', 'yes', 'show'));
	}
}
if (!function_exists('grace_church_param_is_off')) {
	function grace_church_param_is_off($prm) {
		return empty($prm) || $prm===0 || in_array(grace_church_strtolower($prm), array('false', 'off', 'no', 'none', 'hide'));
	}
}
if (!function_exists('grace_church_param_is_inherit')) {
	function grace_church_param_is_inherit($prm) {
		return in_array(grace_church_strtolower($prm), array('inherit', 'default'));
	}
}

// Clear dedicated content
if (!function_exists('grace_church_clear_dedicated_content')) {
	function grace_church_clear_dedicated_content() {
		global $GRACE_CHURCH_GLOBALS;
		$GRACE_CHURCH_GLOBALS['sc_section_dedicated'] = '';
	}
}

// Return dedicated content
if (!function_exists('grace_church_get_dedicated_content')) {
	function grace_church_get_dedicated_content() {
		global $GRACE_CHURCH_GLOBALS;
		return $GRACE_CHURCH_GLOBALS['sc_section_dedicated'];
	}
}

// Check if we are in the shortcode "trx_blogger" now
if (!function_exists('grace_church_in_shortcode_blogger')) {
	function grace_church_in_shortcode_blogger($from_blogger = false) {
		if (!$from_blogger) return false;
		global $GRACE_CHURCH_GLOBALS;
		return !empty($GRACE_CHURCH_GLOBALS['sc_blogger_busy']);
	}
}

// Return GAP wrapper start
if (!function_exists('grace_church_gap_start')) {
	function grace_church_gap_start() {
		return '<!-- #TRX_GAP_START# -->';
	}
}

// Return GAP wrapper end
if (!function_exists('grace_church_gap_end')) {
	function grace_church_gap_end() {
		return '<!-- #TRX_GAP_END# -->';
	}
}


// Replace GAP wrapper in the content
if (!function_exists('grace_church_gap_wrapper')) {
    function grace_church_gap_wrapper($str) {
        // Move VC row and column and wrapper inside gap
        $str_new = preg_replace('/(<div\s+class="[^"]*vc_row[^>]*>)[\r\n\s]*(<div\s+class="[^"]*vc_col[^>]*>)[\r\n\s]*(<div\s+class="[^"]*wpb_wrapper[^>]*>)[\r\n\s]*('.grace_church_gap_start().')/i', '\\4\\1\\2\\3', $str);
        if ($str_new != $str) $str_new = preg_replace('/('.grace_church_gap_end().')[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)/i', '\\2\\3\\4\\1', $str_new);
        // Gap layout
        return str_replace(
            array(
                grace_church_gap_start(),
                grace_church_gap_end()
            ),
            array(
                grace_church_close_all_wrappers(false) . '<div class="sc_gap">',
                '</div>' . grace_church_open_all_wrappers(false)
            ),
            $str_new
        );
    }
}

?>