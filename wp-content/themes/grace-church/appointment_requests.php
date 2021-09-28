<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
if(empty($_SESSION['ses_user'])) {
    $_SESSION['adminuser'] = '';
    header('Location:'.site_url());
    exit;
}

if($_REQUEST['task'] == 'delete' && !empty($_REQUEST[id])) {
    global $wpdb;

    $testimonial = $wpdb->get_results("select * from wp_req_appointments where id='".$_REQUEST['id']."' and bestof_id='".$_SESSION['ses_user']['id']."' limit 1") ;

    if(empty($testimonial)) {
        $_SESSION['ses_user'] = '';
        wp_redirect( site_url().'/' ); exit;
    }
    else {
        $wpdb->query("delete from `wp_req_appointments` where id=".$_REQUEST[id]);
    }
}
get_header();


/**
 * Template Name: Appointment requests Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */



$sql = "SELECT * FROM `wp_req_appointments` where status='Active' and bestof_id='".$_SESSION['ses_user']['id']."' order by id desc";

$appointmentLists = $wpdb->get_results($sql,'ARRAY_A');


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
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/my-profile"><button style="background-color: #FF005A">My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button style="background-color: #003D89">My Appointments</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner">
                <div class="wpb_wrapper">
                    <div class="sc_section">
                        <div class="sc_section_inner">
                            <div class="sc_table" style="width:100%;">
                                <p></p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th style="text-align: center;">Created</th>
                                        <th style="text-align: center;">First Name</th>
                                        <th style="text-align: center;">Last Name</th>
                                        <th style="text-align: center;">Cell Number</th>
                                        <th style="text-align: center;">Email Address</th>
                                        <th style="text-align: center;">Preffered Appt Time</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                    </tr>
                                    <?php foreach($appointmentLists as $appointmentList): ?>
                                        <tr align="center">
                                            <td class="theme_color_dark" style="line-height: 18px"><?php echo date('m-d-y h:i a',$appointmentList['created']) ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['first_name'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['last_name'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['cell'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['email'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['preferred_appointment'] ?></td>
                                            <td align="center">
                                                <div class="sc_socials_item" style="padding: 0px 8px;background-color: #fd7711;width:12px">
                                                    <a href="<?php echo get_site_url() ?>/edit-appointment-request/?id=<?php echo $appointmentList['id'] ?>" class="social_icons social_twitter">
                                                        <span class="icon-pencil" style="color: #fff"></span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="sc_socials_item" style="padding: 0px 8px;background-color: #c60913;width:12px">
                                                    <a href="<?php echo get_site_url() ?>/appointment-requests/?id=<?php echo $appointmentList['id'] ?>&task=delete" class="social_icons social_twitter" onclick="return confirm('Are you sure you want to delete this testimonial?');">
                                                        <span class="icon-trash" style="color: #fff"></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php endif; ?>

<?php if(empty($_SESSION['ses_user'])): ?>
	<?php 
		if(!empty($_POST['search'])) {
			$where_sql = " 1 = 1 ";
			
			if(!empty($_POST['sname'])) {
				$where_sql .= " and name like '%".$_POST['sname']."%'";		
			}
			if(!empty($_POST['scity'])) {
				$where_sql .= " and office_city = '".$_POST['scity']."'";		
			}
			if(!empty($_POST['szip'])) {
				$where_sql .= " and office_zip = '".$_POST['szip']."'";		
			}
			if(!empty($_POST['sspecialty'])) {
				$where_sql .= " and specialty like '%".$_POST['sspecialty']."%'";		
			}
			
			
			$sql = "SELECT * FROM `wp_cfcms_directory` where ".$where_sql." order by name asc";
			$cfcmsLists = $wpdb->get_results($sql,'ARRAY_A');
			
		}
	?>
<?php endif; ?>        


<?php get_footer(); ?>
