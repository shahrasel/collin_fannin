<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
$mydb = new wpdb('physician_collin','Piup6?35','physician_collin','localhost:3306');
if(empty($_SESSION['ses_user'])) {
    $_SESSION['adminuser'] = '';
    header('Location:'.site_url());
    exit;
}

global $wpdb;
if(!empty($_POST)) {

    //if (!empty($_POST['username']) && !empty($_POST['comment'])) {
        //$wpdb->query("Update `wp_testimonials` set `name`='" . $_POST['username'] . "', `rating`='" . $_POST['rating'] . "', `comment`='" . $_POST['comment'] . "' where id=".$_POST['id']);

    $mydb->query("UPDATE `wp_req_appointments` SET `first_name` = '" . $_POST['first_name'] . "', `last_name` = '" . $_POST['last_name'] . "', `cell` = '" . $_POST['cell'] . "', `email` = '" . $_POST['email'] . "', `network_type` = '" . $_POST['network_type'] . "', `insurance_name` = '" . $_POST['insurance_provider'] . "', `preferred_appointment` = '" . $_POST['pref_appoint_time'] . "' WHERE `id` = ".$_POST['id']);

        wp_redirect(get_site_url().'/appointment-requests');
        exit();
   // }
}


$testimonial = $mydb->get_results("select * from wp_req_appointments where id='".$_REQUEST['id']."' and doctor_id='".$_SESSION['ses_user']['id']."' limit 1") ;
if(empty($testimonial[0])) {
    $_SESSION['ses_user'] = '';
    wp_redirect( site_url().'/' ); exit;
}
$testimonial_info = $testimonial[0];

get_header();
wp_enqueue_style( 'style11', get_template_directory_uri().'/css/jquery-ui.css' );
wp_enqueue_script( 'jquery-ui', get_template_directory_uri().'/js/jquery-ui.js', false );
wp_enqueue_script( 'jquery-ui1', get_template_directory_uri().'/js/jquery-ui-timepicker-addon.js', false );
/**
 * Template Name: Appointment Request Edit Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */


if(!empty($_SESSION['ses_user'])):
?>

	<style>
    .sc_contact_form1.sc_contact_form_style_1 .sc_contact_form_info .sc_contact_form_item {
        width: 47.45%;
    }
	label{
		color:#000;	
	}
	.scheme_original .sc_team_style_team-4 .sc_team_item_info .sc_team_item_title a:hover{
		color: #fff !important;	
	}
	</style>


	<div class="sc_contact_form_wrap" style="margin-bottom:40px">
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button style="background-color: #ff9279">Appointment Requests</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/testimonials"><button>Testimonials</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="https://physicianfinder.collinfannincms.com/wp-content/uploads/2020/01/CollinFannin2019Dir_web.pdf" target="_blank"><button>Electronic Directory</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button>My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="sc_contact_form_wrap">

      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="first_name">First Name</label>
              <input type="text" placeholder="First Name" name="first_name" id="first_name" value="<?php echo $testimonial_info->first_name ?>" required>
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="last_name">Last Name</label>
              <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo $testimonial_info->last_name ?>" required>
            </div>


              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="cell">Cell</label>
                  <input type="text" placeholder="Cell" name="cell" id="cell" value="<?php echo $testimonial_info->cell ?>" required>
              </div>
              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="email">Last Name</label>
                  <input type="text" placeholder="Email" name="email" id="email" value="<?php echo $testimonial_info->email ?>" required>
              </div>


              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="network_type">Network Type</label>
                  <select name="network_type" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                      <option value="">Select Network</option>
                      <option value="Medicare" <?php if($testimonial_info->network_type=='Medicare'): ?>selected<?php endif; ?>>Medicare</option>
                      <option value="PPO" <?php if($testimonial_info->network_type=='PPO'): ?>selected<?php endif; ?>>PPO</option>
                      <option value="HMO" <?php if($testimonial_info->network_type=='HMO'): ?>selected<?php endif; ?>>HMO</option>
                  </select>
              </div>
              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="insurance_provider">Insurance Provider</label>
                  <input type="text" placeholder="Insurance Provider" name="insurance_provider" id="insurance_provider" value="<?php echo $testimonial_info->insurance_name ?>">
              </div>


            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="pref_appoint_time">Preffered Appointment Time</label>
                <input type="text" placeholder="Preffered Appointment Time" name="pref_appoint_time" id="showing_time" value="<?php echo $testimonial_info->preferred_appointment ?>">
            </div>
            
          <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

          <div style="clear: both">
              <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
                <button>UPDATE</button>
              </div>
          </div>
          
        </form>
      </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
<script>jQuery(document).ready( function($) {
        jQuery('#showing_time').datetimepicker({
            timeFormat: "hh:mm tt",
        });
    });
</script>