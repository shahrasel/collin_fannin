<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/**
 * Template Name: CFCMS Directory Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
session_start();
//print_r($_SESSION['ses_user']);
/*$frontpage_id = get_option('page_on_front');
$self_id = get_the_ID();
global $within_section;
$within_section = 'y';*/
get_header();
include_once( 'resize-class.php' );
global $wpdb;

$sql = "SELECT distinct specialty FROM `wp_cfcms_directory` where specialty<>'' order by specialty asc";
$specialityLists = $wpdb->get_results($sql,'ARRAY_A');





if(!empty($_SESSION['ses_user'])):
    $state_lists = array(
                'AL'=>"Alabama",
                'AK'=>"Alaska",
                'AZ'=>"Arizona",
                'AR'=>"Arkansas",
                'CA'=>"California",
                'CO'=>"Colorado",
                'CT'=>"Connecticut",
                'DE'=>"Delaware",
                'DC'=>"District Of Columbia",
                'FL'=>"Florida",
                'GA'=>"Georgia",
                'HI'=>"Hawaii",
                'ID'=>"Idaho",
                'IL'=>"Illinois",
                'IN'=>"Indiana",
                'IA'=>"Iowa",
                'KS'=>"Kansas",
                'KY'=>"Kentucky",
                'LA'=>"Louisiana",
                'ME'=>"Maine",
                'MD'=>"Maryland",
                'MA'=>"Massachusetts",
                'MI'=>"Michigan",
                'MN'=>"Minnesota",
                'MS'=>"Mississippi",
                'MO'=>"Missouri",
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",
                'OK'=>"Oklahoma",
                'OR'=>"Oregon",
                'PA'=>"Pennsylvania",
                'RI'=>"Rhode Island",
                'SC'=>"South Carolina",
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",
                'TX'=>"Texas",
                'UT'=>"Utah",
                'VT'=>"Vermont",
                'VA'=>"Virginia",
                'WA'=>"Washington",
                'WV'=>"West Virginia",
                'WI'=>"Wisconsin",
                'WY'=>"Wyoming");
    $flag = 0;



    if(!empty($_POST)) {


        global $wpdb;


        $pass_str = '';
        if(!empty($_POST['pass'])) {
            $pass_str = " password = '".$_POST['pass']."', ";
        }

        if(!empty($_FILES['bg_image']['name'])) {
            $sepext = explode('.', $_FILES['bg_image']['name']);
            $type = end($sepext);
            $uniqueID = uniqid();
            $newFileName = $uniqueID . '.' . $type;
            $RnewFileName = $uniqueID . '_R.' . $type;

            if (move_uploaded_file($_FILES['bg_image']['tmp_name'], get_template_directory() . "/images/cfcms_images/" . $newFileName)) {

                $resizeObj = new resize(get_template_directory() . "/images/cfcms_images/" . $newFileName);
                $resizeObj->resizeImage(1600, 235, 'auto');
                $resizeObj->saveImage(get_template_directory() . "/images/cfcms_images/" . $RnewFileName, 100);

                $bg_image_name = get_template_directory_uri() . '/images/cfcms_images/' . $RnewFileName;
            }
        }

        $bg_imge_sql_str = "";
        if(!empty($bg_image_name)) {
            $bg_imge_sql_str = "`bg_image` = '".$bg_image_name."',";
        }

        //print_r($_FILES);
        if(!empty($_FILES['image']['tmp_name'])) {
           $sepext = explode('.', $_FILES['image']['name']);
           $type = end($sepext);
           $uniqueID = uniqid();
           $newFileName = $uniqueID . '.' . $type;
           $RnewFileName = $uniqueID . '_R.' . $type;

           if (move_uploaded_file($_FILES['image']['tmp_name'], get_template_directory()."/images/cfcms_images/" . $newFileName)) {

                $resizeObj = new resize(get_template_directory()."/images/cfcms_images/" . $newFileName);
                $resizeObj->resizeImage(300, 300, 'auto');
                $resizeObj->saveImage(get_template_directory()."/images/cfcms_images/" . $RnewFileName, 100);

                $image_name = get_template_directory_uri().'/images/cfcms_images/'.$RnewFileName;
           }


           $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '".$_POST['username']."', `username` = '".$_POST['fusername']."', ".$pass_str." `specialty` = '".$_POST['specialty']."', `practice_name` = '".$_POST['practice_name']."', `image` = '".$image_name."', ".$bg_imge_sql_str."  `manager_name` = '".$_POST['manager_name']."',  `office_address1` = '".$_POST['office_address1']."', `office_address2` = '".$_POST['office_address2']."', `office_city` = '".$_POST['office_city']."', `office_state` = '".$_POST['office_state']."', `office_zip` = '".$_POST['office_zip']."', `office_phone` = '".$_POST['office_phone']."', `office_text` = '".$_POST['office_text']."', `office_fax` = '".$_POST['office_fax']."', `office_email` = '".$_POST['office_email']."', `website` = '".$_POST['website']."', `nurse_name` = '".$_POST['nurse_name']."', `nurse_phone` = '".$_POST['nurse_phone']."', `nurse_email` = '".$_POST['nurse_email']."', `accept_medicare` = '".implode(',',$_POST['accept_medicare'])."', `hospital_affiliation` = '".$_POST['hospital_affiliation']."', `medical_school` = '".$_POST['medical_school']."', `residency` = '".$_POST['residency']."', `internship` = '".$_POST['internship']."', `board_certification` = '".$_POST['board_certification']."', `biography` = '".$_POST['biography']."', `organization_legal_name` = '".$_POST['organization_legal_name']."', `doing_business_as_name` = '".$_POST['doing_business_as_name']."', `main_phone_number` = '".$_POST['main_phone_number']."', `purchasing_contact_name` = '".$_POST['purchasing_contact_name']."', `purchasing_contact_phone_number` = '".$_POST['purchasing_contact_phone_number']."', `purchasing_contact_fax` = '".$_POST['purchasing_contact_fax']."', `purchasing_contact_email` = '".$_POST['purchasing_contact_email']."', `shipping_address_with_suite` = '".$_POST['shipping_address_with_suite']."', `city` = '".$_POST['city']."', `state` = '".$_POST['state']."', `zip` = '".$_POST['zip']."', `class_of_trade` = '".$_POST['class_of_trade']."', `facility_type` = '".$_POST['facility_type']."', `tax_status` = '".$_POST['tax_status']."', `primary_provider_name` = '".$_POST['primary_provider_name']."', `federal_dea_certificate_number` = '".$_POST['federal_dea_certificate_number']."', `access_ethicon_suture_agreement` = '".$_POST['access_ethicon_suture_agreement']."', `name_of_corporate_owner` = '".$_POST['name_of_corporate_owner']."', `coid_number` = '".$_POST['coid_number']."', `executive_contact_name` = '".$_POST['executive_contact_name']."', `executive_contact_email` = '".$_POST['executive_contact_email']."', `comment` = '".$_POST['comment']."', `updated` = '".time()."' WHERE `id` = ".$_SESSION['ses_user']['id']);
        }
        else {

            $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '".$_POST['username']."',`username` = '".$_POST['fusername']."', ".$pass_str." `specialty` = '".$_POST['specialty']."', `practice_name` = '".$_POST['practice_name']."', ".$bg_imge_sql_str."  `manager_name` = '".$_POST['manager_name']."',   `office_address1` = '".$_POST['office_address1']."', `office_address2` = '".$_POST['office_address2']."', `office_city` = '".$_POST['office_city']."', `office_state` = '".$_POST['office_state']."', `office_zip` = '".$_POST['office_zip']."', `office_phone` = '".$_POST['office_phone']."', `office_text` = '".$_POST['office_text']."', `office_fax` = '".$_POST['office_fax']."',  `office_email` = '".$_POST['office_email']."', `website` = '".$_POST['website']."', `nurse_name` = '".$_POST['nurse_name']."', `nurse_phone` = '".$_POST['nurse_phone']."', `nurse_email` = '".$_POST['nurse_email']."', `accept_medicare` = '".implode(',',$_POST['accept_medicare'])."', `hospital_affiliation` = '".$_POST['hospital_affiliation']."', `medical_school` = '".$_POST['medical_school']."', `residency` = '".$_POST['residency']."', `internship` = '".$_POST['internship']."', `board_certification` = '".$_POST['board_certification']."', `biography` = '".$_POST['biography']."', `organization_legal_name` = '".$_POST['organization_legal_name']."', `doing_business_as_name` = '".$_POST['doing_business_as_name']."', `main_phone_number` = '".$_POST['main_phone_number']."', `purchasing_contact_name` = '".$_POST['purchasing_contact_name']."', `purchasing_contact_phone_number` = '".$_POST['purchasing_contact_phone_number']."', `purchasing_contact_fax` = '".$_POST['purchasing_contact_fax']."', `purchasing_contact_email` = '".$_POST['purchasing_contact_email']."', `shipping_address_with_suite` = '".$_POST['shipping_address_with_suite']."', `city` = '".$_POST['city']."', `state` = '".$_POST['state']."', `zip` = '".$_POST['zip']."', `class_of_trade` = '".$_POST['class_of_trade']."', `facility_type` = '".$_POST['facility_type']."', `tax_status` = '".$_POST['tax_status']."', `primary_provider_name` = '".$_POST['primary_provider_name']."', `federal_dea_certificate_number` = '".$_POST['federal_dea_certificate_number']."', `access_ethicon_suture_agreement` = '".$_POST['access_ethicon_suture_agreement']."', `name_of_corporate_owner` = '".$_POST['name_of_corporate_owner']."', `coid_number` = '".$_POST['coid_number']."', `executive_contact_name` = '".$_POST['executive_contact_name']."', `executive_contact_email` = '".$_POST['executive_contact_email']."', `comment` = '".$_POST['comment']."', `updated` = '".time()."' WHERE `id` = ".$_SESSION['ses_user']['id']);
        }
    }

    $cfcms_info = $wpdb->get_row("select * from ".$wpdb->prefix."cfcms_directory where `id` = ".$_SESSION['ses_user']['id'],'ARRAY_A');

    $_SESSION['ses_user'] = $cfcms_info;
        //print_r($_SESSION['ses_user']);
        //print_r($_SESSION['ses_user']);
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
        
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button >Appointment Requests</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/testimonials"><button>Testimonials</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="https://physicianfinder.collinfannincms.com/wp-content/uploads/2020/01/CollinFannin2019Dir_web.pdf" target="_blank"><button>Electronic Directory</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button style="background-color: #ff9279">My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="sc_contact_form_wrap">
      <?php if($flag == 1): ?>
        <p style="color: #fff; background-color: #007f00; padding: 10px;">Purchase request sent successfully!!!</p>
      <?php endif; ?>
      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="username">Name</label>
              <input type="text" placeholder="Full Name" name="username" id="username" value="<?php echo $_SESSION['ses_user']['name'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="specialty">Specialty</label>
              <!--<input type="text" placeholder="Specialty" name="specialty" id="specialty" value="<?php echo $_SESSION['ses_user']['specialty'] ?>">-->
              
              
              <select name="specialty" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Select Specialty</option>
                <?php foreach($specialityLists as $specialityList): ?>
	                <option <?php if($_SESSION['ses_user']['specialty'] == $specialityList['specialty']): ?> selected <?php endif; ?> value="<?php echo $specialityList['specialty'] ?>"><?php echo $specialityList['specialty'] ?></option>
                <?php endforeach; ?>
                
                <!--<option <?php if($_SESSION['ses_user']['sspecialty'] == 'Addiction Psychiatry'): ?> selected <?php endif; ?> value="Addiction Psychiatry">Addiction Psychiatry</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Adult Cardiothroacic Anesthesiology'): ?> selected <?php endif; ?> value="Adult Cardiothroacic Anesthesiology">Adult Cardiothroacic Anesthesiology</option>
                
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Adult Congenital Heart Disease'): ?> selected <?php endif; ?> value="Adult Congenital Heart Disease">Adult Congenital Heart Disease</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Brain Injury Medicine'): ?> selected <?php endif; ?> value="Brain Injury Medicine">Brain Injury Medicine</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Cardiology, Interventional'): ?> selected <?php endif; ?> value="Cardiology, Interventional">Cardiology, Interventional</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Cardiovascular Disease'): ?> selected <?php endif; ?> value="Cardiovascular Disease">Cardiovascular Disease</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Child Abuse Pediatrics'): ?> selected <?php endif; ?> value="Child Abuse Pediatrics">Child Abuse Pediatrics</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Emergency Medical Services'): ?> selected <?php endif; ?> value="Emergency Medical Services">Emergency Medical Services</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Emergency Medicine'): ?> selected <?php endif; ?> value="Emergency Medicine">Emergency Medicine</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Family Medicine'): ?> selected <?php endif; ?> value="Family Medicine">Family Medicine</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Gastroenterology'): ?> selected <?php endif; ?> value="Gastroenterology">Gastroenterology</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'General Practice'): ?> selected <?php endif; ?> value="General Practice">General Practice</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Hematology'): ?> selected <?php endif; ?> value="Hematology">Hematology</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Hepatology'): ?> selected <?php endif; ?> value="Hepatology">Hepatology</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Hospitalist'): ?> selected <?php endif; ?> value="Hospitalist">Hospitalist</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Legal Medicine'): ?> selected <?php endif; ?> value="Legal Medicine">Legal Medicine</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Nephrology'): ?> selected <?php endif; ?> value="Nephrology">Nephrology</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Neurological Surgery'): ?> selected <?php endif; ?> value="Neurological Surgery">Neurological Surgery</option>
                <option <?php if($_SESSION['ses_user']['sspecialty'] == 'Nutrition'): ?> selected <?php endif; ?> value="Nutrition">Nutrition</option>-->
                
              </select>
              
              
            </div>



              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Text Lead Number</label>
                  <input type="text" placeholder="Text Lead Number" name="office_text" id="office_text" value="<?php echo $_SESSION['ses_user']['office_text'] ?>" required>
              </div>

              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Login Email</label>
                  <input type="text" placeholder="Login Email" name="fusername" id="fusername" value="<?php echo $_SESSION['ses_user']['username'] ?>">
              </div>



              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Practice Name</label>
                  <input type="text" placeholder="Practice Name" name="practice_name" id="practice_name" value="<?php echo $_SESSION['ses_user']['practice_name'] ?>">
              </div>
              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Photo</label>
                  <?php if(!empty($_SESSION['ses_user']['image'])): ?>
                      <br/><img src="<?php echo $_SESSION['ses_user']['image'] ?>" width="100" /><br/>
                  <?php else: ?>
                      <br/><img src="https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" width="100" /><br/>
                  <?php endif; ?>
                  <input type="file" name="image" <?php if(empty($_SESSION['ses_user']['image'])): ?> required <?php endif; ?> style="border:none;padding-left:0px;" />
                  <p>250 px X 250px size photo is recommended</p>
              </div>







              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Background Image</label>
                  <?php if(!empty($_SESSION['ses_user']['bg_image'])): ?>
                      <br/><img src="<?php echo $_SESSION['ses_user']['bg_image'] ?>" width="100" /><br/>
                  <?php else: ?>
                      <br/><img src="https://physicianfinder.collinfannincms.com/wp-content/uploads/2019/11/Office-Background.jpg?id=2543" width="200" /><br/>
                  <?php endif; ?>
                  <input type="file" name="bg_image" style="border:none;padding-left:0px;" />
                  <p>1600px X 235px size photo is recommended</p>
              </div>
            <div class="sc_contact_form_item sc_contact_form_message label_over" style="width:100%;margin-left: 0px">
                <label for="biography">Biography</label>
                <textarea placeholder="Biography" name="biography" id="biography" style="height: 200px" required><?php echo $_SESSION['ses_user']['biography'] ?></textarea>
              </div>
          </div>
            
            
            <div class="sc_contact_form_info">
            <h3>Office Info:</h3><p></p>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Address 1</label>
              <input type="text" placeholder="Office Address 1" name="office_address1" id="office_address1" value="<?php echo $_SESSION['ses_user']['office_address1'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Address 2</label>
              <input type="text" placeholder="Office Address 2" name="office_address2" id="office_address2" value="<?php echo $_SESSION['ses_user']['office_address2'] ?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office City</label>
              <input type="text" placeholder="Office City" name="office_city" id="office_city" value="<?php echo $_SESSION['ses_user']['office_city'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office State</label>
              <select name="office_state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Select State</option>
                <?php foreach($state_lists as $key=>$state_list): ?>
                    <option <?php if($_SESSION['ses_user']['office_state'] == $key): ?> selected="selected" <?php endif; ?> value="<?php echo $key ?>"><?php echo $state_list.' - '.$key ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Zip Code</label>
              <input type="text" placeholder="Office Zip Code" name="office_zip" id="office_zip" value="<?php echo $_SESSION['ses_user']['office_zip'] ?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Phone</label>
              <input type="text" placeholder="Office Phone" name="office_phone" id="office_phone" value="<?php echo $_SESSION['ses_user']['office_phone'] ?>">
            </div>

            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="office_fax">Office Fax</label>
              <input type="text" placeholder="Office Fax" name="office_fax" id="office_fax" value="<?php echo $_SESSION['ses_user']['office_fax'] ?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Email</label>
              <input type="text" placeholder="Office Email" name="office_email" id="office_email" value="<?php echo $_SESSION['ses_user']['office_email'] ?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Website</label>
              <input type="text" placeholder="Website" name="website" id="website" value="<?php echo $_SESSION['ses_user']['website'] ?>">
            </div>
            
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="manager_name">Manager Name</label>
              <input type="text" placeholder="Manager Name" name="manager_name" id="manager_name" value="<?php echo $_SESSION['ses_user']['manager_name'] ?>">
            </div>


          
          <h3>Assistance/Nurse Info:</h3><p></p>


          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Name</label>
              <input type="text" placeholder="Name" name="nurse_name" id="nurse_name" value="<?php echo $_SESSION['ses_user']['nurse_name'] ?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Phone</label>
              <input type="text" placeholder="Phone" name="nurse_phone" id="nurse_phone" value="<?php echo $_SESSION['ses_user']['nurse_phone'] ?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Email</label>
              <input type="text" placeholder="Email" name="nurse_email" id="nurse_email" value="<?php echo $_SESSION['ses_user']['nurse_email'] ?>">
          </div>




            <h3>Accepts:</h3>
            <div>
                <div class="sc_contact_form_item sc_contact_form_field label_over" style="width: 100%">
                    <!--<label for="name">Accepts Medicare</label>-->
                    <table width="100%">
                        <tr>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Insurance (PPO)" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Insurance (PPO)')): ?> checked <?php endif; ?>></span>Insurance (PPO)</label></td>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Insurance (HMO)" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Insurance (HMO)')): ?> checked <?php endif; ?>></span>Insurance (HMO)</label></td>
                        </tr>

                        <tr>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="BCBS Advantage HMO" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'BCBS Advantage HMO')): ?> checked <?php endif; ?>></span>BCBS Advantage HMO</label></td>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Insurance (EPO)" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Insurance (EPO)')): ?> checked <?php endif; ?>></span>Insurance (EPO)</label></td>
                        </tr>

                        <tr>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="TRICARE (Military)" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'TRICARE (Military)')): ?> checked <?php endif; ?>></span>TRICARE (Military)</label></td>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Medicare" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Medicare')): ?> checked <?php endif; ?>></span>Medicare</label></td>
                        </tr>

                        <tr>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Medicaid" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Medicaid')): ?> checked <?php endif; ?>></span>Medicaid</label></td>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Cash" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Cash')): ?> checked <?php endif; ?>></span>Cash</label></td>
                        </tr>

                        <tr>
                            <td width="50%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input   type="checkbox" class="myCheckBox" name="accept_medicare[]" value="Uninsured Patients" <?php if(strstr($_SESSION['ses_user']['accept_medicare'],'Uninsured Patients')): ?> checked <?php endif; ?>></span>Uninsured Patients</label></td>
                            <td width="50%">&nbsp;</td>
                        </tr>
                    </table>
                </div>

                <div class="clearfix"></div>
          
          <h3>Other Info:</h3>

                <div class="sc_contact_form_item sc_contact_form_field label_over" style="display: none">
                </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Hospital Affiliation(s)</label>
              <input type="text" placeholder="Hospital Affiliation(s)" name="hospital_affiliation" id="hospital_affiliation" value="<?php echo $_SESSION['ses_user']['hospital_affiliation'] ?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Medical School</label>
              <input type="text" placeholder="Medical School" name="medical_school" id="medical_school" value="<?php echo $_SESSION['ses_user']['medical_school'] ?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Residency</label>
            <input type="text" placeholder="Residency" name="residency" id="residency" value="<?php echo $_SESSION['ses_user']['residency'] ?>">
          </div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Internship</label>
            <input type="text" placeholder="Internship" name="internship" id="internship" value="<?php echo $_SESSION['ses_user']['internship'] ?>">
          </div>
          </div>




                <div class="clearfix"></div>

          <div class="sc_contact_form_item sc_contact_form_message label_over">
            <label for="name">Board Certification(s)</label>
            <textarea placeholder="Board Certification(s)" name="board_certification" id="board_certification"><?php echo $_SESSION['ses_user']['board_certification'] ?></textarea>
          </div>

          <div class="clearfix"></div>


          <h3>PASSWORD:</h3>
                <div class="clearfix"></div>
          <div class="sc_contact_form_item sc_contact_form_field label_over">
                <label for="pass">Update Password</label>
                <input type="password" placeholder="Password" name="pass" id="pass" value="">
          </div>




        <hr style="color: #e3e3e3;border: 1px solid;margin-top: 50px;margin-bottom: 20px;">
                <div style="margin: 0 auto;color: #ff0000;text-align: center;font-size: 30px;font-weight: bold;margin-bottom: 20px;">GROUP PURCHASING ORGANIZATION INFO</div>

                <div class="clearfix"></div>

        <h3>FACILITY INFO & ORDER CONTACT PERSON</h3>
                <div class="clearfix"></div>

        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Organization Legal Name</label>
            <input type="text" placeholder="" name="organization_legal_name" id="organization_legal_name" value="<?php echo $_SESSION['ses_user']['organization_legal_name'] ?>" required>
        </div>

        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Doing Business as Name</label>
            <input type="text" placeholder="" name="doing_business_as_name" id="doing_business_as_name" value="<?php echo $_SESSION['ses_user']['doing_business_as_name'] ?>" required>
        </div>




                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Main Phone Number</label>
                    <input type="text" placeholder="" name="main_phone_number" id="main_phone_number" value="<?php echo $_SESSION['ses_user']['main_phone_number'] ?>" required>
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Purchasing Contact Name</label>
                    <input type="text" placeholder="" name="purchasing_contact_name" id="purchasing_contact_name" value="<?php echo $_SESSION['ses_user']['purchasing_contact_name'] ?>" required>
                </div>


                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Purchasing Contact Phone Number</label>
                    <input type="text" placeholder="" name="purchasing_contact_phone_number" id="purchasing_contact_phone_number" value="<?php echo $_SESSION['ses_user']['purchasing_contact_phone_number'] ?>" required>
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Purchasing Contact Fax</label>
                    <input type="text" placeholder="" name="purchasing_contact_fax" id="purchasing_contact_fax" value="<?php echo $_SESSION['ses_user']['purchasing_contact_fax'] ?>" required>
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Purchasing Contact Email</label>
                    <input type="text" placeholder="" name="purchasing_contact_email" id="purchasing_contact_email" value="<?php echo $_SESSION['ses_user']['purchasing_contact_email'] ?>" required>
                </div>
                <div class="clearfix"></div>


          <h3>FACILITY SHIPPING ADDRESS</h3>
                <div class="clearfix"></div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Shipping Address With Suite #</label>
            <input type="text" placeholder="" name="shipping_address_with_suite" id="shipping_address_with_suite" value="<?php echo $_SESSION['ses_user']['shipping_address_with_suite'] ?>" required>
        </div>
        <div class="clearfix"></div>

        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">City</label>
            <input type="text" placeholder="" name="city" id="city" value="<?php echo $_SESSION['ses_user']['city'] ?>" required>
        </div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="width: 20%;margin-right: 4%;">
            <label for="name">State</label>
            <!--<input type="text" placeholder="" name="state" id="state" value="<?php /*echo $_SESSION['ses_user']['state'] */?>" required>-->
            <select name="state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" required>
                <option value="">Select State</option>
                <?php foreach($state_lists as $key=>$state_list): ?>
                    <option <?php if($_SESSION['ses_user']['state'] == $key): ?> selected="selected" <?php endif; ?> value="<?php echo $key ?>"><?php echo $state_list.' - '.$key ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="width: 20%">
            <label for="name">Zip</label>
            <input type="text" placeholder="" name="zip" id="zip" value="<?php echo $_SESSION['ses_user']['zip'] ?>" required>
        </div>




        <h3>TYPE OF FACILITY</h3>
        <div class="clearfix"></div>
        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Class of Trade (Select from Dropdown)</label>
            <select name="class_of_trade" id="class_of_trade" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" required onchange="changeFacilitySelectbox()">
                <option value="">-- Select an option --</option>
                <option value="Ambulatory Care" <?php if($_SESSION['ses_user']['class_of_trade']=='Ambulatory Care'): ?> selected <?php endif; ?>>Ambulatory Care</option>
                <option value="Home Care" <?php if($_SESSION['ses_user']['class_of_trade']=='Home Care'): ?> selected <?php endif; ?>>Home Care</option>
                <option value="Long Term Care" <?php if($_SESSION['ses_user']['class_of_trade']=='Long Term Care'): ?> selected <?php endif; ?>>Long Term Care</option>
                <option value="Retail" <?php if($_SESSION['ses_user']['class_of_trade']=='Retail'): ?> selected <?php endif; ?>>Retail</option>
                <option value="Other" <?php if($_SESSION['ses_user']['class_of_trade']=='Other'): ?> selected <?php endif; ?>>Other</option>
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Facility Type (Select from Dropdown)</label>
            <select name="facility_type" id="facility_type" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" >
                <option value="">-- Select an option --</option>
            </select>
        </div>
        <div class="clearfix"></div>



        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Tax Status (Select from Dropdown)</label>
            <select name="tax_status" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" required>
                <option value="1">-- Select an option --</option>
                <option value="For Profit" <?php if($_SESSION['ses_user']['tax_status']=='For Profit'): ?> selected <?php endif; ?>>For Profit</option>
                <option value="Non Profit" <?php if($_SESSION['ses_user']['tax_status']=='Non Profit'): ?> selected <?php endif; ?>>Non Profit</option>
            </select>
        </div>
        <div class="clearfix"></div>





        <h3>IF PHYSICIAN OFFICE/CLINIC</h3>
        <div class="clearfix"></div>
        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Primary Provider Name</label>
            <input type="text" placeholder="" name="primary_provider_name" id="zip" value="<?php echo $_SESSION['ses_user']['primary_provider_name'] ?>" required>
        </div>
        <div class="clearfix"></div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Federal DEA Certificate Number</label>
            <input type="text" placeholder="" name="federal_dea_certificate_number" id="federal_dea_certificate_number" value="<?php echo $_SESSION['ses_user']['federal_dea_certificate_number'] ?>" required>
        </div>
        <div class="clearfix"></div>



        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px">
            <label for="name">Access to Ethicon Suture Agreement?</label>
            <!--<input type="text" placeholder="" name="access_ethicon_suture_agreement" id="zip" value="<?php /*echo $_SESSION['ses_user']['access_ethicon_suture_agreement'] */?>" required>-->
            <select name="access_ethicon_suture_agreement" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" required>
                <option value="">-- Select --</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="clearfix"></div>

        <h3>ABOUT YOUR ORGANIZATION AND WHO CAN SIGN AGREEMENTS</h3>

        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">Name of Corporate Owner</label>
            <input type="text" placeholder="" name="name_of_corporate_owner" id="name_of_corporate_owner" value="<?php echo $_SESSION['ses_user']['name_of_corporate_owner'] ?>" required>
        </div>

        <div class="sc_contact_form_item sc_contact_form_field label_over">
            <label for="name">COID Number (If financial reporting should roll under a parent COID)</label>
            <input type="text" placeholder="" name="coid_number" id="coid_number" value="<?php echo $_SESSION['ses_user']['coid_number'] ?>" >
        </div>
        <div class="clearfix"></div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 0px;">
            <label for="name">Executive Contact Name</label>
            <input type="text" placeholder="" name="executive_contact_name" id="executive_contact_name" value="<?php echo $_SESSION['ses_user']['executive_contact_name'] ?>" required>
        </div>

        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-left: 4%">
            <label for="name">Executive Contact Email</label>
            <input type="text" placeholder="" name="executive_contact_email" id="executive_contact_email" value="<?php echo $_SESSION['ses_user']['executive_contact_email'] ?>" required>
        </div>

        <div class="clearfix"></div>

        <!--<div class="sc_contact_form_item sc_contact_form_field label_over" style="width: 100%">
            <label for="name">Comment</label>
            <textarea name="comment" style="width: 100%;height: 100px;" ><?php /*echo $_SESSION['ses_user']['comment'] */?></textarea>
        </div>-->






                <input type="hidden" name="formsub" value="1">
          
          <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
              <!--<button>UPDATE</button>-->
              <input type="submit" class="scheme_original" value="UPDATE"  onclick="return formvalidation()">
          </div>
          
        </form>
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
		//print_r($cfcmsLists);
		
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

    <div class="sc_contact_form_wrap">
      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <h2>SEARCH DIRECTORY:</h2><p></p>
        <form action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="sname">Name</label>
              <input type="text" placeholder="Name" name="sname" id="sname" value="<?php echo $_POST['sname'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="scity">City</label>
              <input type="text" placeholder="City" name="scity" id="scity" value="<?php echo $_POST['scity'] ?>">
            </div>
            
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="szip">Zip</label>
              <input type="text" placeholder="Zip Code" name="szip" id="szip" value="<?php echo $_POST['szip'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="sspecialty">Specialty</label>
              <!--<input type="text" placeholder="Specialty" name="sspecialty" id="sspecialty" value="<?php echo $_POST['sspecialty'] ?>">-->
              <select name="sspecialty" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
                <option value="">Select Specialty</option>
                <?php foreach($specialityLists as $specialityList): ?>
	                <option <?php if($_POST['sspecialty'] == $specialityList['specialty']): ?> selected <?php endif; ?> value="<?php echo $specialityList['specialty'] ?>"><?php echo $specialityList['specialty'] ?></option>
                <?php endforeach; ?>
                
                <!--<option <?php if($_POST['sspecialty'] == 'Addiction Psychiatry'): ?> selected <?php endif; ?> value="Addiction Psychiatry">Addiction Psychiatry</option>
                <option <?php if($_POST['sspecialty'] == 'Adult Cardiothroacic Anesthesiology'): ?> selected <?php endif; ?> value="Adult Cardiothroacic Anesthesiology">Adult Cardiothroacic Anesthesiology</option>
                
                <option <?php if($_POST['sspecialty'] == 'Adult Congenital Heart Disease'): ?> selected <?php endif; ?> value="Adult Congenital Heart Disease">Adult Congenital Heart Disease</option>
                <option <?php if($_POST['sspecialty'] == 'Brain Injury Medicine'): ?> selected <?php endif; ?> value="Brain Injury Medicine">Brain Injury Medicine</option>
                <option <?php if($_POST['sspecialty'] == 'Cardiology, Interventional'): ?> selected <?php endif; ?> value="Cardiology, Interventional">Cardiology, Interventional</option>
                <option <?php if($_POST['sspecialty'] == 'Cardiovascular Disease'): ?> selected <?php endif; ?> value="Cardiovascular Disease">Cardiovascular Disease</option>
                <option <?php if($_POST['sspecialty'] == 'Child Abuse Pediatrics'): ?> selected <?php endif; ?> value="Child Abuse Pediatrics">Child Abuse Pediatrics</option>
                <option <?php if($_POST['sspecialty'] == 'Emergency Medical Services'): ?> selected <?php endif; ?> value="Emergency Medical Services">Emergency Medical Services</option>
                <option <?php if($_POST['sspecialty'] == 'Emergency Medicine'): ?> selected <?php endif; ?> value="Emergency Medicine">Emergency Medicine</option>
                <option <?php if($_POST['sspecialty'] == 'Family Medicine'): ?> selected <?php endif; ?> value="Family Medicine">Family Medicine</option>
                <option <?php if($_POST['sspecialty'] == 'Gastroenterology'): ?> selected <?php endif; ?> value="Gastroenterology">Gastroenterology</option>
                <option <?php if($_POST['sspecialty'] == 'General Practice'): ?> selected <?php endif; ?> value="General Practice">General Practice</option>
                <option <?php if($_POST['sspecialty'] == 'Hematology'): ?> selected <?php endif; ?> value="Hematology">Hematology</option>
                <option <?php if($_POST['sspecialty'] == 'Hepatology'): ?> selected <?php endif; ?> value="Hepatology">Hepatology</option>
                <option <?php if($_POST['sspecialty'] == 'Hospitalist'): ?> selected <?php endif; ?> value="Hospitalist">Hospitalist</option>
                <option <?php if($_POST['sspecialty'] == 'Legal Medicine'): ?> selected <?php endif; ?> value="Legal Medicine">Legal Medicine</option>
                <option <?php if($_POST['sspecialty'] == 'Nephrology'): ?> selected <?php endif; ?> value="Nephrology">Nephrology</option>
                <option <?php if($_POST['sspecialty'] == 'Neurological Surgery'): ?> selected <?php endif; ?> value="Neurological Surgery">Neurological Surgery</option>
                <option <?php if($_POST['sspecialty'] == 'Nutrition'): ?> selected <?php endif; ?> value="Nutrition">Nutrition</option>-->
                
              </select>
            </div>
          </div>
          <input type="hidden" name="search" value="1" />
          <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
            <button>SEARCH</button>
          </div>
        </form> 
      </div> 
    </div> 
    
    
    <?php if(!empty($cfcmsLists)): ?>
    <h2>RESULTS:</h2>
    
    <div class="sc_team_wrap" id="sc_team_659112401_wrap"><div data-slides-per-view="4" data-interval="7559" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_659112401"><div class="sc_columns columns_wrap">
    <?php foreach($cfcmsLists as $cfcmsList): ?><div class="column-1_4 column_padding_bottom"><div class="sc_team_item sc_team_item_1 odd first">
				<div class="sc_team_item_avatar"><img width="370" height="415" src="<?php if(!empty($cfcmsList['image'])): ?><?php echo $cfcmsList['image']; else: ?>https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg<?php endif; ?>" alt="<?php echo $cfcmsList['name'] ?>" class="wp-post-image">					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo site_url() ?>/cfcms?id=<?php echo $cfcmsList['id'] ?>"><?php echo $cfcmsList['name'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo $cfcmsList['specialty'] ?></div>
                            <div class="sc_team_item_position"><?php echo $cfcmsList['practice_name'] ?></div>
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div>
	<?php endif; ?>  
<?php endif; ?>        

<script>

    jQuery( document ).ready(function() {
        changeFacilitySelectbox();
        //alert('<?php echo $cfcms_info['facility_type'] ?>');
        jQuery("#facility_type").val('<?php echo $cfcms_info['facility_type'] ?>');
    });

    function formvalidation() {
        var checkBoxes = document.getElementsByClassName( 'myCheckBox' );
        var isChecked = false;
        for (var i = 0; i < checkBoxes.length; i++) {
            if ( checkBoxes[i].checked ) {
                isChecked = true;
            };
        };
        if ( isChecked == false ) {
            alert( 'At least one checkbox of "accepts" should be checked!' );
            return false;
        }
    }

    function changeFacilitySelectbox() {
        var facility_type_val = jQuery("#class_of_trade").val();
        if(facility_type_val == 'Ambulatory Care') {
            jQuery("#facility_type").html('<option value="Alt Site">Alt Site</option><option value="Clinic">Clinic</option><option value="Dialysis-Free Standing">Dialysis-Free Standing</option><option value="Imaging Center">Imaging Center</option><option value="Surgery Center">Surgery Center</option><option value="Urgent Care">Urgent Care</option><option value="Oncology Center">Oncology Center</option>');
        }
        else if(facility_type_val == 'Home Care') {
            jQuery("#facility_type").html('<option value="Home Care">Home Care</option><option value="Home Infusion (Closed Door)">Home Infusion (Closed Door)</option><option value="Hospice Home Care (Closed Door)">Hospice Home Care (Closed Door)</option>');
        }
        else if(facility_type_val == 'Long Term Care') {
            jQuery("#facility_type").html('<option value="Assisted Living">Assisted Living</option><option value="Hospice">Hospice</option><option value="LT Acute Care">LT Acute Care</option><option value="LTC Pharmacy">LTC Pharmacy</option><option value="Nursing Home w/o Pharmacy">Nursing Home w/o Pharmacy</option><option value="Nursing Home w/ Pharmacy">Nursing Home w/ Pharmacy</option><option value="Retire Community">Retire Community</option><option value="Skilled Nursing Facility (“SNF”)">Skilled Nursing Facility (“SNF”)</option>');
        }
        else if(facility_type_val == 'Retail') {
            jQuery("#facility_type").html('<option value="DME">DME</option><option value="Hospital-Based Retail OP Pharmacy">Hospital-Based Retail OP Pharmacy</option><option value="Free Stand Retail – OP Pharmacy (Retail)">Free Stand Retail – OP Pharmacy (Retail)</option><option value="Clinic Pharmacy (Retail)">Clinic Pharmacy (Retail)</option>');
        }
        else if(facility_type_val == 'Other') {
            jQuery("#facility_type").html('<option value="Adult Day Care">Adult Day Care</option><option value="Corp/Admin">Corp/Admin</option><option value="Medical Office Bldg">Medical Office Bldg</option><option value="Other Facility">Other Facility</option>');
        }
        else {
            jQuery("#facility_type").html('<option value="">-- Select an option --</option>');
        }
    }
    </script>

<?php get_footer(); ?>
