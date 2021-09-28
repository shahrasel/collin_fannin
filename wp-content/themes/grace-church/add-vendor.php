<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/**
 * Template Name: ADD Vendor Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
session_start();
get_header();
global $wpdb;


$cat_arr = array();
//echo "select id,title from ".$wpdb->prefix."bestof_categories order by title asc";
$cat_lists = $wpdb->get_results("select id,title from ".$wpdb->prefix."bestof_categories order by title asc",'ARRAY_A');

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

           if($_POST['accepts_gpo'] == 'Yes') {
               $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '" . $_POST['username'] . "', `username` = '" . $_POST['fusername'] . "', " . $pass_str . " `specialty` = '" . $_POST['specialty'] . "', `practice_name` = '" . $_POST['practice_name'] . "', `image` = '" . $image_name . "', " . $bg_imge_sql_str . "  `manager_name` = '" . $_POST['manager_name'] . "',  `office_address1` = '" . $_POST['office_address1'] . "', `office_address2` = '" . $_POST['office_address2'] . "', `office_city` = '" . $_POST['office_city'] . "', `office_state` = '" . $_POST['office_state'] . "', `office_zip` = '" . $_POST['office_zip'] . "', `office_phone` = '" . $_POST['office_phone'] . "', `office_text` = '" . $_POST['office_text'] . "', `office_fax` = '" . $_POST['office_fax'] . "', `office_email` = '" . $_POST['office_email'] . "', `website` = '" . $_POST['website'] . "', `nurse_name` = '" . $_POST['nurse_name'] . "', `nurse_phone` = '" . $_POST['nurse_phone'] . "', `nurse_email` = '" . $_POST['nurse_email'] . "', `accept_medicare` = '" . implode(',', $_POST['accept_medicare']) . "', `hospital_affiliation` = '" . $_POST['hospital_affiliation'] . "', `medical_school` = '" . $_POST['medical_school'] . "', `residency` = '" . $_POST['residency'] . "', `internship` = '" . $_POST['internship'] . "', `board_certification` = '" . $_POST['board_certification'] . "', `biography` = '" . $_POST['biography'] . "', `organization_legal_name` = '" . $_POST['organization_legal_name'] . "', `doing_business_as_name` = '" . $_POST['doing_business_as_name'] . "', `main_phone_number` = '" . $_POST['main_phone_number'] . "', `purchasing_contact_name` = '" . $_POST['purchasing_contact_name'] . "', `purchasing_contact_phone_number` = '" . $_POST['purchasing_contact_phone_number'] . "', `purchasing_contact_fax` = '" . $_POST['purchasing_contact_fax'] . "', `purchasing_contact_email` = '" . $_POST['purchasing_contact_email'] . "', `shipping_address_with_suite` = '" . $_POST['shipping_address_with_suite'] . "', `city` = '" . $_POST['city'] . "', `state` = '" . $_POST['state'] . "', `zip` = '" . $_POST['zip'] . "', `class_of_trade` = '" . $_POST['class_of_trade'] . "', `facility_type` = '" . $_POST['facility_type'] . "', `tax_status` = '" . $_POST['tax_status'] . "', `primary_provider_name` = '" . $_POST['primary_provider_name'] . "', `federal_dea_certificate_number` = '" . $_POST['federal_dea_certificate_number'] . "', `access_ethicon_suture_agreement` = '" . $_POST['access_ethicon_suture_agreement'] . "', `name_of_corporate_owner` = '" . $_POST['name_of_corporate_owner'] . "', `coid_number` = '" . $_POST['coid_number'] . "', `executive_contact_name` = '" . $_POST['executive_contact_name'] . "', `executive_contact_email` = '" . $_POST['executive_contact_email'] . "',
                `accepts_gpo` = '" . $_POST['accepts_gpo'] . "',
                `authorize_gpo` = '" . $_POST['authorize_gpo'] . "',
                `updated` = '" . time() . "' WHERE `id` = " . $_SESSION['ses_user']['id']);
           }
           else {
               $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '" . $_POST['username'] . "', `username` = '" . $_POST['fusername'] . "', " . $pass_str . " `specialty` = '" . $_POST['specialty'] . "', `practice_name` = '" . $_POST['practice_name'] . "', `image` = '" . $image_name . "', " . $bg_imge_sql_str . "  `manager_name` = '" . $_POST['manager_name'] . "',  `office_address1` = '" . $_POST['office_address1'] . "', `office_address2` = '" . $_POST['office_address2'] . "', `office_city` = '" . $_POST['office_city'] . "', `office_state` = '" . $_POST['office_state'] . "', `office_zip` = '" . $_POST['office_zip'] . "', `office_phone` = '" . $_POST['office_phone'] . "', `office_text` = '" . $_POST['office_text'] . "', `office_fax` = '" . $_POST['office_fax'] . "', `office_email` = '" . $_POST['office_email'] . "', `website` = '" . $_POST['website'] . "', `nurse_name` = '" . $_POST['nurse_name'] . "', `nurse_phone` = '" . $_POST['nurse_phone'] . "', `nurse_email` = '" . $_POST['nurse_email'] . "', `accept_medicare` = '" . implode(',', $_POST['accept_medicare']) . "', `hospital_affiliation` = '" . $_POST['hospital_affiliation'] . "', `medical_school` = '" . $_POST['medical_school'] . "', `residency` = '" . $_POST['residency'] . "', `internship` = '" . $_POST['internship'] . "', `board_certification` = '" . $_POST['board_certification'] . "', `biography` = '" . $_POST['biography'] . "', `organization_legal_name` = '', `doing_business_as_name` = '', `main_phone_number` = '', `purchasing_contact_name` = '', `purchasing_contact_phone_number` = '', `purchasing_contact_fax` = '', `purchasing_contact_email` = '', `shipping_address_with_suite` = '', `city` = '', `state` = '', `zip` = '', `class_of_trade` = '', `facility_type` = '', `tax_status` = '', `primary_provider_name` = '', `federal_dea_certificate_number` = '', `access_ethicon_suture_agreement` = '', `name_of_corporate_owner` = '', `coid_number` = '', `executive_contact_name` = '', `executive_contact_email` = '',
                `accepts_gpo` = '" . $_POST['accepts_gpo'] . "',
                `authorize_gpo` = '',
                `updated` = '" . time() . "' WHERE `id` = " . $_SESSION['ses_user']['id']);
           }
        }
        else {
            if($_POST['accepts_gpo'] == 'Yes') {
                $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '".$_POST['username']."',`username` = '".$_POST['fusername']."', ".$pass_str." `specialty` = '".$_POST['specialty']."', `practice_name` = '".$_POST['practice_name']."', ".$bg_imge_sql_str."  `manager_name` = '".$_POST['manager_name']."',   `office_address1` = '".$_POST['office_address1']."', `office_address2` = '".$_POST['office_address2']."', `office_city` = '".$_POST['office_city']."', `office_state` = '".$_POST['office_state']."', `office_zip` = '".$_POST['office_zip']."', `office_phone` = '".$_POST['office_phone']."', `office_text` = '".$_POST['office_text']."', `office_fax` = '".$_POST['office_fax']."',  `office_email` = '".$_POST['office_email']."', `website` = '".$_POST['website']."', `nurse_name` = '".$_POST['nurse_name']."', `nurse_phone` = '".$_POST['nurse_phone']."', `nurse_email` = '".$_POST['nurse_email']."', `accept_medicare` = '".implode(',',$_POST['accept_medicare'])."', `hospital_affiliation` = '".$_POST['hospital_affiliation']."', `medical_school` = '".$_POST['medical_school']."', `residency` = '".$_POST['residency']."', `internship` = '".$_POST['internship']."', `board_certification` = '".$_POST['board_certification']."', `biography` = '".$_POST['biography']."', `organization_legal_name` = '".$_POST['organization_legal_name']."', `doing_business_as_name` = '".$_POST['doing_business_as_name']."', `main_phone_number` = '".$_POST['main_phone_number']."', `purchasing_contact_name` = '".$_POST['purchasing_contact_name']."', `purchasing_contact_phone_number` = '".$_POST['purchasing_contact_phone_number']."', `purchasing_contact_fax` = '".$_POST['purchasing_contact_fax']."', `purchasing_contact_email` = '".$_POST['purchasing_contact_email']."', `shipping_address_with_suite` = '".$_POST['shipping_address_with_suite']."', `city` = '".$_POST['city']."', `state` = '".$_POST['state']."', `zip` = '".$_POST['zip']."', `class_of_trade` = '".$_POST['class_of_trade']."', `facility_type` = '".$_POST['facility_type']."', `tax_status` = '".$_POST['tax_status']."', `primary_provider_name` = '".$_POST['primary_provider_name']."', `federal_dea_certificate_number` = '".$_POST['federal_dea_certificate_number']."', `access_ethicon_suture_agreement` = '".$_POST['access_ethicon_suture_agreement']."', `name_of_corporate_owner` = '".$_POST['name_of_corporate_owner']."', `coid_number` = '".$_POST['coid_number']."', `executive_contact_name` = '".$_POST['executive_contact_name']."', `executive_contact_email` = '".$_POST['executive_contact_email']."', 
              `accepts_gpo` = '".$_POST['accepts_gpo']."',
              `authorize_gpo` = '".$_POST['authorize_gpo']."',  
              `updated` = '".time()."' WHERE `id` = ".$_SESSION['ses_user']['id']);
            }
            else {
                $wpdb->query("UPDATE `wp_cfcms_directory` SET `name` = '" . $_POST['username'] . "',`username` = '" . $_POST['fusername'] . "', " . $pass_str . " `specialty` = '" . $_POST['specialty'] . "', `practice_name` = '" . $_POST['practice_name'] . "', " . $bg_imge_sql_str . "  `manager_name` = '" . $_POST['manager_name'] . "',   `office_address1` = '" . $_POST['office_address1'] . "', `office_address2` = '" . $_POST['office_address2'] . "', `office_city` = '" . $_POST['office_city'] . "', `office_state` = '" . $_POST['office_state'] . "', `office_zip` = '" . $_POST['office_zip'] . "', `office_phone` = '" . $_POST['office_phone'] . "', `office_text` = '" . $_POST['office_text'] . "', `office_fax` = '" . $_POST['office_fax'] . "',  `office_email` = '" . $_POST['office_email'] . "', `website` = '" . $_POST['website'] . "', `nurse_name` = '" . $_POST['nurse_name'] . "', `nurse_phone` = '" . $_POST['nurse_phone'] . "', `nurse_email` = '" . $_POST['nurse_email'] . "', `accept_medicare` = '" . implode(',', $_POST['accept_medicare']) . "', `hospital_affiliation` = '" . $_POST['hospital_affiliation'] . "', `medical_school` = '" . $_POST['medical_school'] . "', `residency` = '" . $_POST['residency'] . "', `internship` = '" . $_POST['internship'] . "', `board_certification` = '" . $_POST['board_certification'] . "', `biography` = '" . $_POST['biography'] . "', `organization_legal_name` = '', `doing_business_as_name` = '', `main_phone_number` = '', `purchasing_contact_name` = '', `purchasing_contact_phone_number` = '', `purchasing_contact_fax` = '', `purchasing_contact_email` = '', `shipping_address_with_suite` = '', `city` = '', `state` = '', `zip` = '', `class_of_trade` = '', `facility_type` = '', `tax_status` = '', `primary_provider_name` = '', `federal_dea_certificate_number` = '', `access_ethicon_suture_agreement` = '', `name_of_corporate_owner` = '', `coid_number` = '', `executive_contact_name` = '', `executive_contact_email` = '', 
              `accepts_gpo` = '" . $_POST['accepts_gpo'] . "',
              `authorize_gpo` = '',  
              `updated` = '" . time() . "' WHERE `id` = " . $_SESSION['ses_user']['id']);
            }
        }
    };
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

    td, th {
        border: none !important;
    }
	</style>


	<div class="sc_contact_form_wrap" style="margin-bottom:40px">
        
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button >Appointment Requests</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/testimonials"><button>Testimonials</button></a>

        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/add-vendor"><button style="background-color: #ff9279">Add Vendor</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/add-vendor-review"><button>Add Vendor Review</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/vendor-appointments"><button>Vendor Appointments</button></a>

        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="https://physicianfinder.collinfannincms.org/wp-content/uploads/2020/01/CollinFannin2019Dir_web.pdf" target="_blank"><button>Electronic Directory</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button>My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="sc_contact_form_wrap">
      <?php if($flag == 1): ?>
        <p style="color: #fff; background-color: #007f00; padding: 10px;">Vendor added successfully!!!</p>
      <?php endif; ?>
      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">

            <div style="width: 100%; display: none;color: #ff0000;text-align: center;border: 1px solid #000;
  padding: 10px;
  box-shadow: 5px 10px 8px #888888;margin-bottom:30px;" id="error_message">

            </div>

            <!--<div style="width: 100%; color: #ff0000;text-align: center;font-size: 25px;padding-bottom: 20px;">
                All fields with <span style="color: #ff0000">*</span> are required
            </div>-->

            <div class="sc_contact_form_info">
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="username">Company Name</label>
                    <input type="text" placeholder="Company Name" name="company" id="company" value="<?php echo $_REQUEST['company'] ?>">
                </div>
                <div class="clearfix"></div>
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="username">First Name <span style="color: #ff0000">*</span></label>
                    <input type="text" placeholder="First Name" name="first_name" id="first_name" value="<?php echo $_REQUEST['first_name'] ?>">
                </div>
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="username">Last Name <span style="color: #ff0000">*</span></label>
                    <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="<?php echo $_REQUEST['last_name'] ?>">
                </div>

              <div class="sc_contact_form_item sc_contact_form_field label_over">
                  <label for="name">Email </label>
                  <input type="text" placeholder="Email" name="femail" id="femail" value="<?php echo $_REQUEST['email'] ?>" >
              </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Phone Number </label>
                    <input type="text" placeholder="Phone Number" name="phone_number" id="phone_number" value="<?php echo $_REQUEST['phone_number'] ?>" >
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Category </label>
                    <select name="category" id="category" style="border:2px solid #F4F4F4 !important;width: 100%;height: 46px;">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($cat_lists as $cat_list): ?>
                            <option value="<?php echo $cat_list['title'] ?>"><?php echo $cat_list['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

                <input type="hidden" name="formsub" value="1">

                <div style="width: 100%; color: #ff0000;text-align: center;font-size: 25px;padding-bottom: 20px;padding-top:20px;">
                    All fields with <span style="color: #ff0000">*</span> are required
                </div>


                <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
              <input type="submit" class="scheme_original" value="ADD VENDOR"  onclick="return formvalidation()">
          </div>
          
        </form>
      </div>
    </div>
<?php endif; ?>

<script>

    jQuery( document ).ready(function() {

    });

    function formvalidation() {
        var flag = 0;
        var fstr = "";
        var fstr1 = "";

        if(jQuery("#first_name").val() =='') {
            jQuery("#first_name").css('border','2px solid #FFA9A9');
            flag = 1;
            fstr += "First name, ";
        }
        else {
            jQuery("#first_name").css('border','2px solid #f4f4f4');
        }
        if(jQuery("#last_name").val() =='') {
            jQuery("#last_name").css('border','2px solid #FFA9A9');
            flag = 1;
            fstr += "Last name, ";
        }
        else {
            jQuery("#fusername").css('border','2px solid #f4f4f4');
        }

        if(jQuery("#femail").val() =='') {
            jQuery("#femail").css('border','2px solid #FFA9A9');
            flag = 1;
            fstr += "Email, ";
        }
        else {
            jQuery("#femail").css('border','2px solid #f4f4f4');
        }

        if(flag == 1) {

            var str11 = fstr.substring(0, fstr.length - 2);
            if(str11.length >0) {
                jQuery("#error_message").html("Oops! The following required field(s) are missing: " + str11);
            }
            jQuery("#error_message").css('display','block');

            window.scrollTo(0, 0);

            return false;
        }
        else {
            return true;
        }

    }
</script>

<?php get_footer(); ?>
