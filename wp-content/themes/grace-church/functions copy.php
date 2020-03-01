<?php
/**
 * Theme sprecific functions and definitions
 */

if($_POST['is_loggedin'] ==1) {
	$cfcms_info = $wpdb->get_row("select * from ".$wpdb->prefix."cfcms_directory where username ='".$_POST['log']."' and password ='".$_POST['pwd']."'",'ARRAY_A');
	session_start();
	$_SESSION['ses_user'] = $cfcms_info;

	wp_redirect( site_url().'/cfcms-directory' ); exit;
}
if($_REQUEST['logout'] == 'true') {
	session_start();
	$_SESSION['ses_user'] = '';
}

//print_r($_REQUEST);
//exit;
/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'grace_church_theme_setup' ) ) {
	add_action( 'grace_church_action_before_init_theme', 'grace_church_theme_setup', 1 );
	function grace_church_theme_setup() {

		// Register theme menus
		add_filter( 'grace_church_filter_add_theme_menus',		'grace_church_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'grace_church_filter_add_theme_sidebars',	'grace_church_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'grace_church_filter_importer_options',		'grace_church_set_importer_options' );

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'grace_church_add_theme_menus' ) ) {
	//add_filter( 'grace_church_filter_add_theme_menus', 'grace_church_add_theme_menus' );
	function grace_church_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'grace-church');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'grace_church_add_theme_sidebars' ) ) {
	//add_filter( 'grace_church_filter_add_theme_sidebars',	'grace_church_add_theme_sidebars' );
	function grace_church_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'grace-church' ),
				'sidebar_outer'		=> esc_html__( 'Outer Sidebar', 'grace-church' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'grace-church' )
			);
			if (grace_church_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'grace-church' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Set theme specific importer options
if ( !function_exists( 'grace_church_set_importer_options' ) ) {
	//add_filter( 'grace_church_filter_importer_options',	'grace_church_set_importer_options' );
	function grace_church_set_importer_options($options=array()) {
		if (is_array($options)) {
            $options['domain_dev'] = esc_url('church.ancorathemes.dnw');
            $options['domain_demo'] = esc_url('gracechurch.ancorathemes.com');
			$options['page_on_front'] = 'Home';
			$options['page_for_posts'] = 'Blog';
			$options['menus'] = array(						// Menus locations and names
                'menu-main'	  => esc_html__('Main menu', 'grace-church'),
                'menu-user'	  => esc_html__('User menu', 'grace-church'),
                'menu-footer' => esc_html__('Footer menu', 'grace-church'),
                'menu-outer'  => esc_html__('Main menu', 'grace-church')
			);
		}
		return $options;
	}
}




/* Include framework core files
------------------------------------------------------------------- */
// If now is WP Heartbeat call - skip loading theme core files
if (!isset($_POST['action']) || $_POST['action']!="heartbeat") {
	require_once( get_template_directory().'/fw/loader.php' );
}


add_image_size('strategic-partner-image', 241, 213, true);
add_image_size('strategic-partner-company-image', 670, 213, true);
add_image_size('platinum-partner-company-image', 479, 307, true);
add_image_size('silgold-partner-company-image', 458, 217, true);
add_image_size('Advertise-image', 283, 283, true);
add_image_size('committee-image', 370, 415, true);
add_image_size('video-image', 210, 118, true);


add_action('init', 'strategicpartners');
function strategicpartners()
{
  $labels = array(
    'name' => _x('Platinum', 'post type general name'),
    'singular_name' => _x('strategicpartners', 'post type singular name'),
    'add_new' => _x('Add New', 'strategicpartners'),
	'add_new_item' => __('Add New Platinum'),
    'edit_item' => __('Edit Platinum'),
    'new_item' => __('New Platinum'),
    'view_item' => __('View Platinum'),
    'search_items' => __('Search Platinum'),
    'not_found' =>  __('No Platinum found'),
    'not_found_in_trash' => __('No Platinum found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Platinum Category','cat_strategicpartners'),
  );
  register_post_type('strategicpartners',$args);
}


add_action('init', 'platinumsponsors');
function platinumsponsors()
{
  $labels = array(
    'name' => _x('Gold', 'post type general name'),
    'singular_name' => _x('platinumsponsors', 'post type singular name'),
    'add_new' => _x('Add New', 'platinumsponsors'),
	'add_new_item' => __('Add New Gold'),
    'edit_item' => __('Edit Gold'),
    'new_item' => __('New Gold'),
    'view_item' => __('View Gold'),
    'search_items' => __('Search Gold'),
    'not_found' =>  __('No Gold found'),
    'not_found_in_trash' => __('No Gold found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Gold Category','cat_platinumsponsors'),
  );
  register_post_type('platinumsponsors',$args);
}



add_action('init', 'goldsponsors');
function goldsponsors()
{
  $labels = array(
    'name' => _x('Silver', 'post type general name'),
    'singular_name' => _x('goldsponsors', 'post type singular name'),
    'add_new' => _x('Add New', 'goldsponsors'),
	'add_new_item' => __('Add New Silver'),
    'edit_item' => __('Edit Silver'),
    'new_item' => __('New Silver'),
    'view_item' => __('View Silver'),
    'search_items' => __('Search Silver'),
    'not_found' =>  __('No Silver found'),
    'not_found_in_trash' => __('No Silver found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Silver Category','cat_goldsponsors'),
  );
  register_post_type('goldsponsors',$args);
}


add_action('init', 'silversponsors');
function silversponsors()
{
  $labels = array(
    'name' => _x('Bronze', 'post type general name'),
    'singular_name' => _x('silversponsors', 'post type singular name'),
    'add_new' => _x('Add New', 'silversponsors'),
	'add_new_item' => __('Add New Bronze'),
    'edit_item' => __('Edit Bronze'),
    'new_item' => __('New Bronze'),
    'view_item' => __('View Bronze'),
    'search_items' => __('Search Bronze'),
    'not_found' =>  __('No Bronze found'),
    'not_found_in_trash' => __('No Bronze found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Bronze Category','cat_silversponsors'),
  );
  register_post_type('silversponsors',$args);
}


add_action('init', 'adverstising');
function adverstising()
{
  $labels = array(
    'name' => _x('Adverstising', 'post type general name'),
    'singular_name' => _x('Adverstising', 'post type singular name'),
    'add_new' => _x('Add New', 'Adverstising'),
	'add_new_item' => __('Add New Adverstising'),
    'edit_item' => __('Edit Adverstising'),
    'new_item' => __('New Adverstising'),
    'view_item' => __('View Adverstising'),
    'search_items' => __('Search Adverstising'),
    'not_found' =>  __('No Adverstising found'),
    'not_found_in_trash' => __('No Adverstising found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 6,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Adverstising Category','cat_adverstising'),
  );
  register_post_type('adverstising',$args);
}


function getStrategicPartner() {
	global $wpdb;
	$project_arr = array();
	$strategic_lists = $wpdb->get_results("select id,post_title,post_content,post_name from ".$wpdb->prefix."posts where post_type = 'strategicpartners' and post_status ='publish' order by post_date desc",'ARRAY_A');
	if(count($strategic_lists)>0) {
		$i = 0;
		foreach($strategic_lists as $project_list) {
			$pdf_file_id =  get_post_meta($project_list['id']);
			$project_arr[$i]['meta'] = $pdf_file_id;

			$project_arr[$i]['id'] = $project_list['id'];
			$project_arr[$i]['title'] = $project_list['post_title'];
			$project_arr[$i]['posttext'] = $project_list['post_content'];
			$project_arr[$i]['post_name'] = $project_list['post_name'];

			$i++;
		}
	}
	return $project_arr;
}

function getPlatinumSponsors() {
	global $wpdb;
	$project_arr = array();
	$strategic_lists = $wpdb->get_results("select id,post_title,post_content,post_name from ".$wpdb->prefix."posts where post_type = 'platinumsponsors' and post_status ='publish' order by post_date desc",'ARRAY_A');
	if(count($strategic_lists)>0) {
		$i = 0;
		foreach($strategic_lists as $project_list) {
			$pdf_file_id =  get_post_meta($project_list['id']);
			$project_arr[$i]['meta'] = $pdf_file_id;

			$project_arr[$i]['id'] = $project_list['id'];
			$project_arr[$i]['title'] = $project_list['post_title'];
			$project_arr[$i]['posttext'] = $project_list['post_content'];
			$project_arr[$i]['post_name'] = $project_list['post_name'];

			$i++;
		}
	}
	return $project_arr;
}

function getGoldSponsors() {
	global $wpdb;
	$project_arr = array();
	$strategic_lists = $wpdb->get_results("select id,post_title,post_content,post_name from ".$wpdb->prefix."posts where post_type = 'goldsponsors' and post_status ='publish' order by post_date desc",'ARRAY_A');
	if(count($strategic_lists)>0) {
		$i = 0;
		foreach($strategic_lists as $project_list) {
			$pdf_file_id =  get_post_meta($project_list['id']);
			$project_arr[$i]['meta'] = $pdf_file_id;

			$project_arr[$i]['id'] = $project_list['id'];
			$project_arr[$i]['title'] = $project_list['post_title'];
			$project_arr[$i]['posttext'] = $project_list['post_content'];
			$project_arr[$i]['post_name'] = $project_list['post_name'];

			$i++;
		}
	}
	return $project_arr;
}

function getSilverSponsors() {
	global $wpdb;
	$project_arr = array();
	$strategic_lists = $wpdb->get_results("select id,post_title,post_content,post_name from ".$wpdb->prefix."posts where post_type = 'silversponsors' and post_status ='publish' order by post_date desc",'ARRAY_A');
	if(count($strategic_lists)>0) {
		$i = 0;
		foreach($strategic_lists as $project_list) {
			$pdf_file_id =  get_post_meta($project_list['id']);
			$project_arr[$i]['meta'] = $pdf_file_id;

			$project_arr[$i]['id'] = $project_list['id'];
			$project_arr[$i]['title'] = $project_list['post_title'];
			$project_arr[$i]['posttext'] = $project_list['post_content'];
			$project_arr[$i]['post_name'] = $project_list['post_name'];

			$i++;
		}
	}
	return $project_arr;
}


//print_r($news_lists);
//exit;
wp_enqueue_style( 'style', get_template_directory_uri().'/rating_lib/css/star-rating-svg.css' );

wp_enqueue_style( 'style11', get_template_directory_uri().'/css/jquery-ui.css' );

$page = get_page_by_title( 'Physician Finder Home' );

//wp_enqueue_script( 'script2', get_template_directory_uri().'/js/rasel_custom.js');

function physician_finder_form($atts) {
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $sql = "SELECT distinct specialty FROM `wp_cfcms_directory` where specialty<>'' order by specialty asc";
    $specialtyLists = $wpdb->get_results($sql,'ARRAY_A');

    $sql = "SELECT distinct office_zip FROM `wp_cfcms_directory` where office_zip<>'' order by office_zip asc";
    $zipLists = $wpdb->get_results($sql,'ARRAY_A');

    echo '<form action="'.site_url().'/physicians-list/">
            <div class="sc_columns columns_wrap"  style="padding-right:0px;margin-top:0px;margin-right:0px;padding:5px 20px;background-color: #fff">
                <div class="column-1_2 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px;background-color: #fff">
                    <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                          <td width="98%">                
                            <div class="btn-group bootstrap-select" style="text-align: center;">
                                <select class="tribe-bar-views-select tribe-no-param" name="speciality" style="width: 100%">
                                  <option value="">Speciality</option>';
                                    $str = "";
                                    foreach($specialtyLists as $specialtyList) {
                                        $str .='<option value="'.$specialtyList['specialty'].'">'.$specialtyList['specialty'].'</option>';
                                    }
                                    echo $str;
                                 echo '</select>
                            </div>
                          </td>
                          <td>&nbsp;|&nbsp;</td>
                        </tbody>
                      </table>  
                </div>
                <div class="column-1_2 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px">
                      <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                      
                      <td width="33%">                
                        <div class="btn-group bootstrap-select">
                            <select name="accepts" id="accepts" style="width: 100%">
                              <option value="">Accepts</option>
                                <option value="Insurance (PPO)">Insurance (PPO)</option>
                                <option value="Insurance (HMO)">Insurance (HMO)</option>
                                <option value="BCBS Advantage HMO">BCBS Advantage HMO</option>
                                <option value="Insurance (EPO)">Insurance (EPO)</option>
                                <option value="TRICARE (Military)">TRICARE (Military)</option>
                                <option value="Medicare">Medicare</option>
                                <option value="Medicaid">Medicaid</option>
                                <option value="Cash">Cash</option>
                                <option value="Uninsured Patients">Uninsured Patients</option>
                             </select>
                        </div>
                      </td>
                      <td>&nbsp;|&nbsp;</td>
                      
                      <td width="32%" style="background-color: #fff">                
                        <div class="btn-group bootstrap-select">
                            
                               <input type="text" class="tribe-bar-views-select tribe-no-param" placeholder="Enter Zip Code" name="zip">
                        </div>
                      </td>
                      <td width="32%" style="padding: 0px">                
                        <div class="btn-group bootstrap-select">
                            <input type="submit" value="FIND" style="width: 100%">
                        </div>
                      </td>
                    </tbody>
                  </table>  
                </div>
        </div></form>';

}

add_shortcode('physician_finder_form', 'physician_finder_form');


function physician_finder_form_list_view($atts) {
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;



    $where_sql = " 1=1 ";
    if(!empty($_REQUEST['speciality'])) {
        $where_sql .= " and specialty like '%".$_REQUEST['speciality']."%'";
    }

    if(!empty($_REQUEST['accepts'])) {
        $where_sql .= " and accept_medicare like '%".$_REQUEST['accepts']."%'";
    }

    if(!empty($_REQUEST['zip'])) {
        $where_sql .= " and office_zip like '%".$_REQUEST['zip']."%'";
    }

    $sql = "SELECT * FROM `wp_cfcms_directory` where ".$where_sql." order by name asc";
    $doctorLists = $wpdb->get_results($sql,'ARRAY_A');

    echo '<div class="vc_row-full-width"></div>
        <div id="sc_team_1710748512_wrap" class="sc_team_wrap">
            <div id="sc_team_1710748512" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" style="width:100%;" data-interval="8036" data-slides-per-view="4">
                <div class="sc_columns columns_wrap">';

                $str = "";
                $i=1;
                    if(!empty($doctorLists)) {
                        foreach ($doctorLists as $doctorList):
                            $str .= '<div class="column-1_4 column_padding_bottom" style="text-align: center"><a href="' . site_url() . '/physician-details/?id=' . $doctorList['id'] . '">';
                            if (!empty($doctorList['image'])):
                                $str .= '<img src="' . $doctorList['image'] . '" style="border-radius:50%;max-width: 150px">';
                            else:
                                $str .= '<img src="https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" style="border-radius:50%;max-width: 150px">';
                            endif;
                            $str .= '<h5 style="margin-top: 0.3em;font-size: 1.1rem">' . $doctorList['name'] . '</h5>
                            <p style="margin-bottom: 0px;"><i>' . $doctorList['specialty'] . '</i></p>
                            <p>' . $doctorList['office_city'] . ($doctorList['office_state'] ? ', ' . $doctorList['office_state'] : '') . '</p>
                        </a></div>';
                            if ($i % 4 == 0) {
                                $str .= '<div class="clearfix visible-sm"></div>';
                            }
                            $i++;
                        endforeach;
                    }
                    else {
                        $str .= "<div style='color: red;text-align: center' >Sorry, no physicians found. Please pick another zip code.</div>";
                    }
                 echo $str;
                echo '</div>
            </div>
            
        </div>';
}

add_shortcode('physician_finder_form_list_view', 'physician_finder_form_list_view');


function physician_finder_form1($atts) {
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $sql = "SELECT distinct specialty FROM `wp_cfcms_directory` where specialty<>'' order by specialty asc";
    $specialtyLists = $wpdb->get_results($sql,'ARRAY_A');

    $sql = "SELECT distinct office_zip FROM `wp_cfcms_directory` where office_zip<>'' order by office_zip asc";
    $zipLists = $wpdb->get_results($sql,'ARRAY_A');


    echo '<form action="'.site_url().'/physicians-list/">
            <div class="sc_columns columns_wrap"  style="padding-right:0px;margin-top:0px;margin-right:0px;padding:5px 2px;background-color: #777777">
                <div class="column-1_2 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px;background-color: #fff">
                    <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                        <tbody><tr>
                          <td width="49%">                
                            <div class="btn-group bootstrap-select" style="text-align: center;">
                                <select class="tribe-bar-views-select tribe-no-param" name="speciality" style="width: 100%">
                                  <option value="">Speciality</option>';
                                    $str = "";
                                    foreach($specialtyLists as $specialtyList) {
                                        $str .='<option value="'.$specialtyList['specialty'].'" '.(($_REQUEST['speciality']==$specialtyList['specialty'])?'selected':'').'>'.$specialtyList['specialty'].'</option>';
                                    }
                                    echo $str;
                                 echo '</select>
                            </div>
                          </td>
                          <td>&nbsp;|&nbsp;</td>
                          <td width="49%">                
                            <div class="btn-group bootstrap-select">
                                <select name="accepts" id="accepts" style="width: 100%">
                                  <option value="">Accepts</option>
                                    
                                 
                                 
                                 <option value="Insurance (PPO)" '.(($_REQUEST['accepts']=='Insurance (PPO)')?'selected':'').'>Insurance (PPO)</option>
                                    <option value="Insurance (HMO)" '.(($_REQUEST['accepts']=='Insurance (HMO)')?'selected':'').'>Insurance (HMO)</option>
                                    <option value="BCBS Advantage HMO" '.(($_REQUEST['accepts']=='BCBS Advantage HMO')?'selected':'').'>BCBS Advantage HMO</option>
                                    <option value="Insurance (EPO)" '.(($_REQUEST['accepts']=='Insurance (EPO)')?'selected':'').'>Insurance (EPO)</option>
                                    <option value="TRICARE (Military)" '.(($_REQUEST['accepts']=='TRICARE (Military)')?'selected':'').'>TRICARE (Military)</option>
                                    <option value="Medicare" '.(($_REQUEST['accepts']=='Medicare')?'selected':'').'>Medicare</option>
                                    <option value="Medicaid" '.(($_REQUEST['accepts']=='Medicare')?'selected':'').'>Medicaid</option>
                                    <option value="Cash" '.(($_REQUEST['accepts']=='Medicare')?'selected':'').'>Cash</option>
                                    <option value="Uninsured Patients" '.(($_REQUEST['accepts']=='Medicare')?'selected':'').'>Uninsured Patients</option>
                                    </select>
                            </div>
                          </td>
                          <td>&nbsp;|&nbsp;</td>
                        </tbody>
                      </table>  
                </div>
                <div class="column-1_2 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px">
                      <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                      <td width="49%" style="background-color: #fff">                
                        <div class="btn-group bootstrap-select">
                            <input type="text" class="tribe-bar-views-select tribe-no-param" placeholder="Enter Zip Code" name="zip" value="'.$_REQUEST['zip'].'">
                        </div>
                      </td>
                      <td width="49%" style="padding: 0px">                
                        <div class="btn-group bootstrap-select">
                            <input type="submit" value="FIND" style="width: 100%">
                        </div>
                      </td>
                    </tbody>
                  </table>  
                </div>
        </div></form>';
}

add_shortcode('physician_finder_form1', 'physician_finder_form1');

function physician_details_user_photo_name($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='".$_REQUEST['id']."' limit 1") ;
    $doctor_info = $doctor_single[0];
    //print_r($doctor_info);exit;
    $str = "";
    if(!empty($doctor_info->image)):
        $str.='<img src="'.$doctor_info->image.'" style="border-radius:50%;max-width: 150px">';
    else:
        $str.='<img src="https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" style="border-radius:50%;max-width: 150px">';
    endif;
    $str.='<h5 style="margin-top: 0.3em; font-size: 1.1rem; color: #031f73;">'.$doctor_info->name.'</h5>';
    $str.='<p style="margin-bottom: 0px;"><span style="color: #5f5f5f;"><i>'.$doctor_info->specialty.'</i></span></p>';
    echo $str.='<span style="color: #fd7200;">'.$doctor_info->office_city.', '.$doctor_info->office_state.'</span>';

}
add_shortcode('physician_details_user_photo_name', 'physician_details_user_photo_name');


function physician_details_doctor_accept($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='".$_REQUEST['id']."' limit 1") ;
    $doctor_info = $doctor_single[0];



    if(!empty($doctor_info->accept_medicare)) {
        $arr = explode(',',trim($doctor_info->accept_medicare));

        $str = "";
        $str .= '<p style="text-align: center; color: #031f73; font-weight: bold;font-size: 20px;margin-bottom: 5px;">Accepts</p><div style="text-align: center;">';


        foreach ($arr as $ar):
            $str .= '<span style="padding: 5px 10px; background-color: #031f73; color: #fff; font-size: 12px; margin: 7px; border-radius: 20px;display: inline-block">' . $ar . '</span>';
        endforeach;
        $str .= '</div>';
        echo $str;
    }

}
add_shortcode('physician_details_doctor_accept', 'physician_details_doctor_accept');


function physician_details_doctor_details($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='".$_REQUEST['id']."' limit 1") ;
    $doctor_info = $doctor_single[0];

    echo $doctor_info->biography;
}
add_shortcode('physician_details_doctor_details', 'physician_details_doctor_details');



function physician_details_doctor_office_info($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='".$_REQUEST['id']."' limit 1") ;
    $doctor_info = $doctor_single[0];

    //echo $doctor_info->biography;
    $str = "<p style=\"color: #031f73; font-weight: bold; font-size: 16px;\">OFFICE INFO</p>";

    if(!empty($doctor_info->office_address1)) {
        $str .= '<p>' . $doctor_info->office_address1 . ' ' . $doctor_info->office_address2 . '<br/>' . $doctor_info->office_state . ' ' . strtok($doctor_info->office_zip, '-') . '</p>';
    }

    if(!empty($doctor_info->office_phone)) {
        $str .= '<p style="color: #031f73; font-weight: bold; font-size: 14px;">Phone: <span style="color: #9fa0a3; font-weight: normal;">' . $doctor_info->office_phone . '</span></p>';
    }

    if(!empty($doctor_info->office_fax)) {
        $str .= '<p style="color: #031f73; font-weight: bold; font-size: 14px;">Fax: <span style="color: #9fa0a3; font-weight: normal;">' . $doctor_info->office_fax . '</span></p>';
    }

    if(!empty($doctor_info->office_email)) {
        $str .= '<p style="color: #031f73; font-weight: bold; font-size: 14px;">Email: <span style="color: #9fa0a3; font-weight: normal;">' . $doctor_info->office_email . '</span></p>';
    }

    if(!empty($doctor_info->website)) {
        $str .= '<p style="color: #031f73; font-weight: bold; font-size: 14px;">Website: <span style="color: #9fa0a3; font-weight: normal;">' . $doctor_info->website . '</span></p>';
    }

    if(!empty($doctor_info->office_direction)) {
        $str .= '<a href="' . $doctor_info->office_direction . '" target="_blank"><img src="' . site_url() . '/wp-content/uploads/2019/11/Get-Direction.jpg" alt="" /></a>';
    }
    echo $str;
}
add_shortcode('physician_details_doctor_office_info', 'physician_details_doctor_office_info');


$flag = 0;

if(!empty($_POST['doctor_detail_formsub'])) {

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $privatekey = '6LdiZx4TAAAAAMzcaIc5l0R-DWjvP1cZvM8YYhww';
    $response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);

    //if(!empty($data->success) && ($data->success == true)) {

        global $wpdb;
        //$wpdb->query("INSERT INTO `wp_purchase_directory` (`id`, `name`, `email`, `cell`, `quantity`, `address`, `city`, `state`, `zip`, `message`, `created`) VALUES (NULL, '".$_POST['username']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['quantity']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['zip']."', '".$_POST['message']."', '".time()."')");
        $wpdb->query("INSERT INTO `wp_req_appointments` (`id`, `doctor_id`, `first_name`, `last_name`, `cell`, `email`, `network_type`, `insurance_name`, `preferred_appointment`, `created`, `status`) VALUES (NULL, '".$_REQUEST['doctor_id']."', '".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['cell']."', '".$_POST['email']."', '".$_POST['network_type']."', '".$_POST['insurance_provider_name']."', '".$_POST['appointment_date_time']."', '".time()."', 'Active')");
        //echo "INSERT INTO `wp_req_appointments` (`id`, `doctor_id`, `first_name`, `last_name`, `cell`, `email`, `network_type`, `insurance_name`, `preferred_appointment`, `created`, `status`) VALUES (NULL, '".$_REQUEST['doctor_id']."', '".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['cell']."', '".$_POST['email']."', '".$_POST['network_type']."', '".$_POST['insurance_provider_name']."', '".$_POST['appointment_date_time']."', '".time()."', 'Active')";

        /*$message = 'New purchase directory message:<br/><br/>';
        $message .= '<b>Name:&nbsp;</b>'.$_POST['username'].'<br/>';
        $message .= '<b>Email:&nbsp;</b>'.$_POST['email'].'<br/>';
        $message .= '<b>Cell:&nbsp;</b>'.$_POST['phone'].'<br/>';
        $message .= '<b>Quanity:&nbsp;</b>'.$_POST['quantity'].'<br/>';

        $message .= '<br/><b>Mailing to:</b><br/>';
        $message .= '<b>Address:&nbsp;</b>'.$_POST['address'].'<br/>';
        $message .= '<b>City:&nbsp;</b>'.$_POST['city'].'<br/>';
        $message .= '<b>State:&nbsp;</b>'.$_POST['state'].'<br/>';
        $message .= '<b>Zip:&nbsp;</b>'.$_POST['zip'].'<br/>';

        $message .= '<b>Message:&nbsp;</b>'.$_POST['message'].'<br/>';

        $email = get_option( 'admin_email' );
        $headers = 'From: Collin Fannin <'.$_POST['email'].'>' . "\r\n";

        add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        wp_mail( $email, 'Purchase a directory', $message,$headers);
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );*/
        $flag = 1;
        $_POST = array();
    /*}
    else {
        $flag = 2;
    }*/
}

function physician_details_contact($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section,$flag;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='" . $_REQUEST['id'] . "' limit 1");
    $doctor_info = $doctor_single[0];

    if($flag == 1) {
        echo '<div style="color:#25a162;text-align: center;margin-bottom: 20px;font-size: 16px;font-weight: bold;">Appointment Request Sent Successfully</div>';
    }
    echo '
<div class="sc_contact_form_wrap">
    <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">
            <div class="sc_contact_form_info">
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="first_name">First Name</label>
                  <input type="text" placeholder="First Name" name="first_name" id="first_name" value="" required>
                </div>
                
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="last_name">Last Name</label>
                  <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="">
                </div>
                
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="cell">Cell</label>
                  <input type="text" placeholder="Cell" name="cell" id="cell" value="" required>
                </div>
                
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="email">Email</label>
                  <input type="text" placeholder="Email" name="email" id="email" value="">
                </div>
                
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="network_type">Network Type</label>
                  <select name="network_type" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" >
                    <option value="">Select Network Type</option>
                      <option value="PPO">PPO</option>
                      <option value="HMO">HMO</option>
                      <option value="Medicare">Medicare</option>
                  </select>
                </div>
                
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="insurance_provider_name">Insurance Provider Name</label>
                  <input type="text" placeholder="Insurance Provider Name" name="insurance_provider_name" id="insurance_provider_name" value="">
                </div>
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="appointment_date_time">Preferred Appointment Date/Time</label>
                  <input type="text" placeholder="Preferred Appointment Date/Time" name="appointment_date_time" id="showing_time" value="">
                </div>
                
                <div style="width: 100%">
                    <div class="g-recaptcha sc_contact_form_item sc_contact_form_field label_over" data-sitekey="6LdiZx4TAAAAALexHX1xPL0K1mtl-968nW7LIu6k"></div>
                </div>
                
              </div>
               <input type="hidden" name="doctor_id" value="'.$_GET['id'].'"> 
              <input type="hidden" name="doctor_detail_formsub" value="1">
              
              <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
                <button>SEND</button>
              </div>
          </form>
      </div>
</div>';
}

add_shortcode('physician_details_contact', 'physician_details_contact');

function physician_details_doctor_map($atts)
{
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    wp_enqueue_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAFqAPWaxVQnJMkCBEHvlP1fIqevvgoN44', false );
    wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui.js', false );
    wp_enqueue_script( 'jquery-ui1', get_template_directory_uri().'/js/jquery-ui-timepicker-addon.js', false );

    extract(shortcode_atts(array(
        'count' => 3
    ), $atts));

    global $post, $wpdb, $within_section;

    $doctor_single = $wpdb->get_results("select * from wp_cfcms_directory where id='".$_REQUEST['id']."' limit 1") ;
    $doctor_info = $doctor_single[0];

    $address_str = (($doctor_info->office_address1)?$doctor_info->office_address1:'').(($doctor_info->office_address2)?' '.$doctor_info->office_address2:'').(($doctor_info->office_city)?' '.$doctor_info->office_city:'').(($doctor_info->office_state)?' '.$doctor_info->office_state:'').(($doctor_info->office_zip)?' '.$doctor_info->office_zip:'');
    //echo $doctor_info->biography;
    //echo '<iframe style="border: 0;" src="https://goo.gl/maps/WQkQ4H1TQp1KGRAm9" width="480" height="375" frameborder="0" allowfullscreen="allowfullscreen"></iframe>';
    echo '<div id="map" style="width: 480px; height: 375px;"></div>';
    echo '<script>
            // Initialize and add the map
            function initMap() {
              // The location of Uluru
              var uluru = {lat: -25.344, lng: 131.036};
              // The map, centered at Uluru
              var map = new google.maps.Map(
                  document.getElementById(\'map\'), {zoom: 14, center: uluru});
              // The marker, positioned at Uluru
              
              
              
                
                //loop all the addresses and call a marker for each one
                //for (var x = 0; x < addressesArray.length; x++) {
                  jQuery.getJSON("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBMs-kF6e9KZURSKg2GLgMmAFF_V3LqvbU&address='.$address_str.'&sensor=false", null, function (data) {
                    var p = data.results[0].geometry.location
                    map.setCenter(data.results[0].geometry.location);
                    var latlng = new google.maps.LatLng(p.lat, p.lng);
                    //it will place marker based on the addresses, which they will be translated as geolocations.
                    //alert(latlng);
                    var marker= new google.maps.Marker({
                      position: latlng,
                      map: map
                    });
                  });
                //}
              
              
              //var marker = new google.maps.Marker({position: uluru, map: map});
            }
    </script>';
}
add_shortcode('physician_details_doctor_map', 'physician_details_doctor_map');

add_action( 'wp_footer', 'themeslug_enqueue_script' );
function themeslug_enqueue_script() {
    global $page,$post;

    if($page->post_name == 'physician-finder-home' && !is_admin()) {
        wp_enqueue_script('script1x1', 'https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js');
    }
    wp_enqueue_script( 'script1', get_template_directory_uri().'/rating_lib/jquery.star-rating-svg.js');

    $testimonial_lists = query_posts( array( 'post_type' => 'testimonial', 'testimonial_group' => 'group-3' ) );
    echo '<script>jQuery(document).ready( function($) {';
        if(!empty($testimonial_lists)) {
            foreach($testimonial_lists as $testimonial_list) {
                echo '$("#rating_'.$testimonial_list->ID.'").starRating({initialRating: '.get_field( "rating",$testimonial_list->ID ).',starSize: 25});';
            }
        }

        if($post->post_name == 'physician-details' && !is_admin()) {
            echo 'initMap();';
            echo 'jQuery(\'#showing_time\').datetimepicker({
                    timeFormat: "hh:mm tt",
                });';
        }

    echo '});</script>';
}




function acf_load_color_field_choices( $field ) {

    // reset choices
    $field['choices'] = array();

    // remove any unwanted white space
    //$choices = array('','Shah','alam','rasel');

    global $wpdb;
    $doctor_lists = $wpdb->get_results("select id,name,username from ".$wpdb->prefix."cfcms_directory where 1=1 order by name asc",'ARRAY_A');
    if(count($doctor_lists)>0) {
        $i = 0;
        foreach ($doctor_lists as $doctor_list) {
            $field['choices'][ $doctor_list['id'] ] = $doctor_list['name'].(($doctor_list['username'])?' - '.$doctor_list['username']:'');
        }
    }





    // return the field
    return $field;

}

add_filter('acf/load_field/name=select_doctor', 'acf_load_color_field_choices');

// [xs_blog]
function trx_advertising($atts) {
    extract(shortcode_atts(array(
        'count' => 3
                    ), $atts));

    global $post, $wpdb, $within_section;

	$project_arr = array();
	$strategic_lists = $wpdb->get_results("select id,post_title,post_content,post_name from ".$wpdb->prefix."posts where post_type = 'adverstising' and post_status ='publish' order by post_date asc",'ARRAY_A');
	if(count($strategic_lists)>0) {
		$i = 0;
		foreach($strategic_lists as $project_list) {
			$pdf_file_id =  get_post_meta($project_list['id']);
			$project_arr[$i]['meta'] = $pdf_file_id;

			$project_arr[$i]['id'] = $project_list['id'];
			$project_arr[$i]['title'] = $project_list['post_title'];
			$project_arr[$i]['posttext'] = $project_list['post_content'];
			$project_arr[$i]['post_name'] = $project_list['post_name'];

			$i++;
		}
	}

	$str = '<div class="wpb_wrapper">
  <h6 style="margin-top:8%;margin-bottom:5%;text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>Advertising<span class="sc_title_divider_after"></span></h6>
  <div class="sc_columns columns_wrap">';
    $i = 1;
	foreach($project_arr as $advertising_list):

    	//$pdf_file_id =  get_post_meta($advertising_list['id'], 'Photo', false);
		$top_image = wp_get_attachment_image( get_post_thumbnail_id($advertising_list['id']),'Advertise-image' );

		if($i==1) {
			$q = 'first';
		}

		if($i%2 == 1){
			$p = 'odd';
		}
		else {
			$p = 'even';
		}

		$str .= '<div class="column-1_3 column_padding_bottom">
					<div class="sc_team_item sc_team_item_1 '.$p.' '.$q.'">
						<div class="priceBox">
                    
                		<a href="'.$advertising_list['meta']['Link URL'][0].'">'.$top_image.'</a>
						
				</div>
			</div>
		</div>';
		$i++;
	endforeach;

	$str .= '</div></div>';

	return $str;


}

add_shortcode('trx_advertising', 'trx_advertising');



if(!empty($_FILES['fupload']['tmp_name'])) {
	global $wpdb;
	$valid = 1;
	if ($valid){
		if ($_FILES['fupload']['tmp_name']){

			$query = $wpdb->query("DELETE FROM `wp_cfcms_directory`");

			$rename = $_FILES['fupload']['name'];

			$target_path = "uploads/";

			$target_path = get_template_directory() .'/csvfiles/'. basename( $_FILES['fupload']['name']);





			if(move_uploaded_file($_FILES['fupload']['tmp_name'], $target_path)) {
				if (($handle = fopen($target_path, "r")) !== FALSE) {

				   fgetcsv($handle);

				   while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						$num = count($data);
						//exit;
						for ($c=0; $c < $num; $c++) {
						  $col[$c] = $data[$c];
						}

					$wpdb->query("insert into `wp_cfcms_directory` SET `username` = '".$col[0]."', `password` = '".$col[1]."', `name` = '".$col[2]."', `specialty` = '".$col[3]."', `practice_name` = '".$col[4]."', `image` = '".$col[5]."', `office_address1` = '".$col[6]."', `office_address2` = '".$col[7]."', `office_city` = '".$col[8]."', `office_state` = '".$col[9]."', `office_zip` = '".$col[10]."', `office_phone` = '".$col[11]."', `office_fax` = '".$col[12]."', `office_email` = '".$col[13]."', `website` = '".$col[14]."', `nurse_name` = '".$col[15]."', `nurse_phone` = '".$col[16]."', `nurse_email` = '".$col[17]."', `hospital_affiliation` = '".$col[18]."', `medical_school` = '".$col[19]."', `residency` = '".$col[20]."', `internship` = '".$col[21]."', `board_certification` = '".$col[22]."', `created` = '".time()."', `updated` = '".time()."'");
				 }
					fclose($handle);
				}
				//exit;
			}



		}


	}
}



add_action('admin_menu', 'cfcmslist_edit_option');
function cfcmslist_edit_option() {
	add_menu_page( 'CFCMS List', 'CFCMS List', 'manage_options', 'cfcms-list', 'cfcmslist_edit');
}
function cfcmslist_edit()
{
	global $wpdb;

	$cfcms_lists = $wpdb->get_results("select * from wp_cfcms_directory order by ID asc",'ARRAY_A');




?>
<div class="wrap">
  <h2>CFCMS List&nbsp;&nbsp;&nbsp;

  </h2>
  <form method="post" action="" enctype="multipart/form-data">
    <?php wp_nonce_field('update-options') ?>
    <br/>
    <table width="90%" cellpadding="5" cellspacing="5">
      <tr>
        <td><strong>CFCMS List CSV File:</strong></td>
        <td><input type="file" name="fupload" ></td>
        <!--<td>Warning: Uploading a New CSV will delete & replace ALL items here.Existing orders are not affected.</td>-->
        <td>&nbsp;</td>
      </tr>
      <input type="hidden" name="cfcmscsvupload" value="1" />
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" id="submit" class="button button-primary" value="Upload" /></td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <p>(Note: Please save the CSV file into Windows Comma Separated Format)</p>
    <br/>

    <h3>Current Uploaded Items</h3>
    <?php if(!empty($cfcms_lists)): ?>
    <table class="wp-list-table widefat">
      <thead>
        <tr>
          <th width="1%">&nbsp;</th>
          <th width="20%">Username</th>
          <th width="7%">Password</th>
          <th width="22%">Name</th>
          <th width="10%">Specialty</th>
          <th width="10%">Image</th>
          <!--<th width="10%">Practice Name</th>-->
          <th width="10%">Office City</th>
          <th width="10%">Office State</th>
          <th width="10%">Office Zip</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach($cfcms_lists as $cfcms_list):  ?>
        <tr<?php if($i%2==1): ?> class="alternate"<?php endif; ?>>
          <td><input type="checkbox" name="id[]" /></td>
          <td><?php echo $cfcms_list['username'] ?></td>
          <td><?php echo $cfcms_list['password'] ?></td>
          <td><?php echo $cfcms_list['name'] ?></td>
          <td><?php echo $cfcms_list['specialty'] ?></td>
          <td><img src="<?php if(!empty($cfcms_list['image'])): ?><?php echo $cfcms_list['image']; else: ?>https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg<?php endif; ?>" width="70" /></td>
          <!--<td><?php echo $cfcms_list['practice_name'] ?></td>-->
          <td><?php echo $cfcms_list['office_city'] ?></td>
          <td><?php echo $cfcms_list['office_state'] ?></td>
          <td><?php echo $cfcms_list['office_zip'] ?></td>
        </tr>
        <?php $i++; endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th>&nbsp;</th>
          <th>Username</th>
          <th>Password</th>
          <th>Name</th>
          <th>Specialty</th>
          <th>Image</th>

          <th>Office City</th>
          <th>Office State</th>
          <th>Office Zip</th>
        </tr>
      </tfoot>
    </table>
    <?php endif; ?>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="school" />
  </form>
</div>
<?php
}





add_action('admin_menu', 'physicianfinder_edit_option');
function physicianfinder_edit_option() {
	add_menu_page( 'Physician Fider List', 'Physician Fider List', 'manage_options', 'physician-list', 'physician_edit');
}
function physician_edit()
{
	global $wpdb;
	$sql = "SELECT distinct specialty FROM `wp_cfcms_directory` where specialty<>'' order by specialty asc";
	$specialityLists = $wpdb->get_results($sql,'ARRAY_A');


	if(!empty($_POST['physician_search'])) {
		$where_sql = " 1 = 1 ";
		//$cfcms_lists = $wpdb->get_results("select * from wp_cfcms_directory order by ID asc",'ARRAY_A');
		if(!empty($_POST['saname'])) {
			$where_sql .= " and name like '%".$_POST['saname']."%'";
		}
		if(!empty($_POST['sacity'])) {
			$where_sql .= " and office_city = '".$_POST['sacity']."'";
		}
		if(!empty($_POST['sazip'])) {
			$where_sql .= " and office_zip = '".$_POST['sazip']."'";
		}
		if(!empty($_POST['sapecialty'])) {
			$where_sql .= " and specialty like '%".$_POST['sapecialty']."%'";
		}


		$sql = "SELECT * FROM `wp_cfcms_directory` where ".$where_sql." order by name asc";
		$cfcmsLists = $wpdb->get_results($sql,'ARRAY_A');
		//print_r($cfcmsLists);

	}





?>
<div class="wrap">
  <h2>Physician List&nbsp;&nbsp;&nbsp;

  </h2>
  <form method="post" action="" enctype="multipart/form-data">
    <?php wp_nonce_field('update-options') ?>
    <br/>
    <table width="90%" cellpadding="5" cellspacing="5">
      <tr>
        <td width="40%"><input type="text" value="<?php echo $_POST['saname'] ?>" id="saname" name="saname" placeholder="Name" style="width:100%"></td>
        <td width="40%"><input type="text" value="<?php echo $_POST['sacity'] ?>" id="sacity" name="sacity" placeholder="City" style="width:100%"></td>
        <td width="20%">&nbsp;</td>
      </tr>

      <tr>
        <td><input type="text" value="<?php echo $_POST['sazip'] ?>" id="sazip" name="sazip" placeholder="Zip Code" style="width:100%"></td>
        <td>
        	<select name="sapecialty" style="width: 100%;">
                <option value="">Select Specialty</option>
                <?php foreach($specialityLists as $specialityList): ?>
                    <option <?php if($_POST['sazip'] == $specialityList['specialty']): ?> selected <?php endif; ?> value="<?php echo $specialityList['specialty'] ?>"><?php echo $specialityList['specialty'] ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>&nbsp;</td>
      </tr>

      <input type="hidden" name="physician_search" value="1" />
      <tr>
        <td><input type="submit" name="Submit" id="submit" class="button button-primary" value="Search" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>

    <?php if(!empty($cfcmsLists)): ?>
    <br/>
    <h3>Physician Lists</h3>
    <table class="wp-list-table widefat">
      <thead>
        <tr>
          <th width="20%">Username</th>
          <th width="22%">Name</th>
          <th width="10%">Specialty</th>
          <th width="10%">Image</th>
          <!--<th width="10%">Practice Name</th>-->
          <th width="10%">Office City</th>
          <th width="10%">Office State</th>
          <th width="10%">Office Zip</th>
          <!--<th width="1%">View</th>-->
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach($cfcmsLists as $cfcms_list):  ?>
        <tr<?php if($i%2==1): ?> class="alternate"<?php endif; ?>>
          <td><?php echo $cfcms_list['username'] ?></td>
          <!--<td><?php echo $cfcms_list['password'] ?></td>-->
          <td><?php echo $cfcms_list['name'] ?></td>
          <td><?php echo $cfcms_list['specialty'] ?></td>
          <td><img src="<?php if(!empty($cfcms_list['image'])): ?><?php echo $cfcms_list['image']; else: ?>https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg<?php endif; ?>" width="70" /></td>
          <!--<td><?php echo $cfcms_list['practice_name'] ?></td>-->
          <td><?php echo $cfcms_list['office_city'] ?></td>
          <td><?php echo $cfcms_list['office_state'] ?></td>
          <td><?php echo $cfcms_list['office_zip'] ?></td>
          <!--<td>
          	<img src="<?php echo get_template_directory_uri(); ?>/images/eye.png" style="width:30px;text-align:center">
          </td>-->
        </tr>
        <?php $i++; endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <!--<th>&nbsp;</th>-->
          <th>Username</th>
          <th>Name</th>
          <th>Specialty</th>
          <th>Image</th>

          <th>Office City</th>
          <th>Office State</th>
          <th>Office Zip</th>
        </tr>
      </tfoot>
    </table>
    <?php endif; ?>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="school" />
  </form>
</div>
<?php
}



add_action('init', 'committees');
function committees()
{
  $labels = array(
    'name' => _x('Committees', 'post type general name'),
    'singular_name' => _x('committees', 'post type singular name'),
    'add_new' => _x('Add New', 'committees'),
	'add_new_item' => __('Add New Committees'),
    'edit_item' => __('Edit Committees'),
    'new_item' => __('New Committees'),
    'view_item' => __('View Committees'),
    'search_items' => __('Search Committees'),
    'not_found' =>  __('No Committees found'),
    'not_found_in_trash' => __('No Committees found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Committees Category','cat_committees'),
  );
  register_post_type('committees',$args);
}


add_action('init', 'prescription');
function prescription()
{
  $labels = array(
    'name' => _x('Prescription', 'post type general name'),
    'singular_name' => _x('Prescription', 'post type singular name'),
    'add_new' => _x('Add New', 'Prescription'),
	'add_new_item' => __('Add New Prescription'),
    'edit_item' => __('Edit Prescription'),
    'new_item' => __('New Prescription'),
    'view_item' => __('View Prescription'),
    'search_items' => __('Search Prescription'),
    'not_found' =>  __('No Prescription found'),
    'not_found_in_trash' => __('No Prescription found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Prescription Category','cat_prescription'),
  );
  register_post_type('prescription',$args);
}

add_action('init', 'videos');
function videos()
{
  $labels = array(
    'name' => _x('Videos', 'post type general name'),
    'singular_name' => _x('Videos', 'post type singular name'),
    'add_new' => _x('Add New', 'Videos'),
	'add_new_item' => __('Add New Videos'),
    'edit_item' => __('Edit Videos'),
    'new_item' => __('New Videos'),
    'view_item' => __('View Videos'),
    'search_items' => __('Search Videos'),
    'not_found' =>  __('No Videos found'),
    'not_found_in_trash' => __('No Videos found in Trash'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => true,
    'menu_position' => 10,
	'_builtin' => false,
    'supports' => array('title','editor','thumbnail','Videos Category','cat_videos'),
  );
  register_post_type('videos',$args);
}

add_action('init', 'init_remove_support',100);
function init_remove_support(){
    $post_type = 'videos';
    remove_post_type_support( $post_type, 'editor');
}


?>