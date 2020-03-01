<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
if(empty($_SESSION['ses_user'])) {
    $_SESSION['adminuser'] = '';
    header('Location:'.site_url());
    exit;
}
$mydb = new wpdb('physician_collin','Piup6?35','physician_collin','localhost:3306');

if($_REQUEST['task'] == 'delete' && !empty($_REQUEST[id])) {
    global $wpdb;

    $testimonial = $mydb->get_results("select * from wp_req_appointments where id='".$_REQUEST['id']."' and doctor_id='".$_SESSION['ses_user']['id']."' limit 1") ;

    if(empty($testimonial)) {
        $_SESSION['ses_user'] = '';
        wp_redirect( site_url().'/' ); exit;
    }
    else {
        $mydb->query("delete from `wp_req_appointments` where id=".$_REQUEST[id]);
    }
}
get_header();


/**
 * Template Name: Appointment requests Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */



$sql = "SELECT * FROM `wp_req_appointments` where status='Active' and doctor_id='".$_SESSION['ses_user']['id']."' order by id desc";

$appointmentLists = $mydb->get_results($sql,'ARRAY_A');


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

    <!--<div class="sc_contact_form_wrap">
      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="username">Name</label>
              <input type="text" placeholder="Full Name" name="username" id="username" value="<?php /*echo $_SESSION['ses_user']['name'] */?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="specialty">Specialty</label>
              
              
              <select name="specialty" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Select Specialty</option>
                <?php /*foreach($specialityLists as $specialityList): */?>
	                <option <?php /*if($_SESSION['ses_user']['specialty'] == $specialityList['specialty']): */?> selected <?php /*endif; */?> value="<?php /*echo $specialityList['specialty'] */?>"><?php /*echo $specialityList['specialty'] */?></option>
                <?php /*endforeach; */?>
              </select>
              
              
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Practice Name</label>
              <input type="text" placeholder="Practice Name" name="practice_name" id="practice_name" value="<?php /*echo $_SESSION['ses_user']['practice_name'] */?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
	            <label for="name">Photo</label>
                <?php /*if(!empty($_SESSION['ses_user']['image'])): */?>
                	<br/><img src="<?php /*echo $_SESSION['ses_user']['image'] */?>" width="100" /><br/>
                <?php /*else: */?>
                	 <br/><img src="https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" width="100" /><br/> 
                <?php /*endif; */?>
                <input type="file" name="image" style="border:none;padding-left:0px;" />
            </div>
            <div class="sc_contact_form_item sc_contact_form_message label_over" style="width:100%">
                <label for="biography">Biography</label>
                <textarea placeholder="Biography" name="biography" id="biography"><?php /*echo $_SESSION['ses_user']['biography'] */?></textarea>
              </div>
          </div>
            
            
            <div class="sc_contact_form_info">
            <h3>Office Info:</h3><p></p>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Address 1</label>
              <input type="text" placeholder="Office Address 1" name="office_address1" id="office_address1" value="<?php /*echo $_SESSION['ses_user']['office_address1'] */?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Address 2</label>
              <input type="text" placeholder="Office Address 2" name="office_address2" id="office_address2" value="<?php /*echo $_SESSION['ses_user']['office_address2'] */?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office City</label>
              <input type="text" placeholder="Office City" name="office_city" id="office_city" value="<?php /*echo $_SESSION['ses_user']['office_city'] */?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office State</label>
              <select name="office_state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Select State</option>
                <?php /*foreach($state_lists as $key=>$state_list): */?>
                    <option <?php /*if($_SESSION['ses_user']['state'] == $key): */?> selected="selected" <?php /*endif; */?> value="<?php /*echo $key */?>"><?php /*echo $state_list.' - '.$key */?></option>
                <?php /*endforeach; */?>
              </select>
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Zip Code</label>
              <input type="text" placeholder="Office Zip Code" name="office_zip" id="office_zip" value="<?php /*echo $_SESSION['ses_user']['office_zip'] */?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Phone</label>
              <input type="text" placeholder="Office Phone" name="office_phone" id="office_phone" value="<?php /*echo $_SESSION['ses_user']['office_phone'] */?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="office_fax">Office Fax</label>
              <input type="text" placeholder="Office Fax" name="office_fax" id="office_fax" value="<?php /*echo $_SESSION['ses_user']['office_fax'] */?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Email</label>
              <input type="text" placeholder="Office Email" name="office_email" id="office_email" value="<?php /*echo $_SESSION['ses_user']['office_email'] */?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Website</label>
              <input type="text" placeholder="Website" name="website" id="website" value="<?php /*echo $_SESSION['ses_user']['website'] */?>">
            </div>
            
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="manager_name">Manager Name</label>
              <input type="text" placeholder="Manager Name" name="manager_name" id="manager_name" value="<?php /*echo $_SESSION['ses_user']['manager_name'] */?>">
            </div>
          
          
          
          <h3>Assistance/Nurse Info:</h3><p></p>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Name</label>
              <input type="text" placeholder="Name" name="nurse_name" id="nurse_name" value="<?php /*echo $_SESSION['ses_user']['nurse_name'] */?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Phone</label>
              <input type="text" placeholder="Phone" name="nurse_phone" id="nurse_phone" value="<?php /*echo $_SESSION['ses_user']['nurse_phone'] */?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Email</label>
              <input type="text" placeholder="Email" name="nurse_email" id="nurse_email" value="<?php /*echo $_SESSION['ses_user']['nurse_email'] */?>">
          </div>
          
          
          <h3>Other Info:</h3>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Accepts Medicare</label>
              <select name="accept_medicare" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Accepts Medicare</option>
                <option <?php /*if($_SESSION['ses_user']['accept_medicare'] == 'yes'): */?> selected="selected" <?php /*endif; */?> value="yes">YES</option>
                <option <?php /*if($_SESSION['ses_user']['accept_medicare'] == 'no'): */?> selected="selected" <?php /*endif; */?> value="no">NO</option>
              </select>
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Hospital Affiliation(s)</label>
              <input type="text" placeholder="Hospital Affiliation(s)" name="hospital_affiliation" id="hospital_affiliation" value="<?php /*echo $_SESSION['ses_user']['hospital_affiliation'] */?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Medical School</label>
              <input type="text" placeholder="Medical School" name="medical_school" id="medical_school" value="<?php /*echo $_SESSION['ses_user']['medical_school'] */?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Residency</label>
            <input type="text" placeholder="Residency" name="residency" id="residency" value="<?php /*echo $_SESSION['ses_user']['residency'] */?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Internship</label>
            <input type="text" placeholder="Internship" name="internship" id="internship" value="<?php /*echo $_SESSION['ses_user']['internship'] */?>">
          </div>
          </div>
          <div class="sc_contact_form_item sc_contact_form_message label_over">
            <label for="name">Board Certification(s)</label>
            <textarea placeholder="Board Certification(s)" name="board_certification" id="board_certification"><?php /*echo $_SESSION['ses_user']['board_certification'] */?></textarea>
          </div>
          
          
          
          <input type="hidden" name="formsub" value="1">
          
          <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
            <button>UPDATE</button>
          </div>
          
        </form>
      </div>
    </div>-->

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
                                        <th style="text-align: center;">Network Type</th>
                                        <th style="text-align: center;">Insurance Provider</th>
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
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['network_type'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['insurance_name'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $appointmentList['preferred_appointment'] ?></td>
                                            <td align="center">
                                                <div class="sc_socials_item" style="padding: 0px 8px;background-color: #fd7711;width:12px">
                                                    <a href="<?php echo get_site_url() ?>/edit-appointment-request/?id=<?php echo $appointmentList['id'] ?>" class="social_icons social_twitter">
                                                        <span class="icon-pencil" style="color: #fff"></span>
                                                    </a>
                                                </div>
                                                <!--<i class="trx_demo_icon-pencil">&nbsp;</i> -->
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
