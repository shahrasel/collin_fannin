<?php
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/**
 * Template Name: Search bestof Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
session_start();
global $wpdb;

/*$finder_db = "collin";
$finder_db_user = "root";
$finder_db_pass = "root";*/
$finder_db = "collinorg";
$finder_db_user = "collinorg_user";
$finder_db_pass = "^8faX99z";

$mydb = new wpdb($finder_db_user,$finder_db_pass,$finder_db,'localhost:8888');


if(!empty($_SESSION['ses_user'])):

    if(!empty($_POST)) {



    }

    get_header();
    ?>
    <form action="'.site_url().'/physicians-list/">
        <div class="sc_columns columns_wrap"  style="padding-right:0px;margin-top:0px;margin-right:0px;padding:5px 2px;background-color: #777777">
            <div class="column-1_3 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px;background-color: #fff;padding-right: 0px">
                <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>
                        <td width="98%">
                            <div class="btn-group bootstrap-select" style="text-align: center;">
                                <select class="tribe-bar-views-select tribe-no-param" name="speciality" style="width: 100%" required>
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
                    </tbody>
                </table>
            </div>
            <div class="column-2_3 column_padding_bottom" style="margin-top:0px;padding-bottom: 0px;padding-right: 0px;background-color:#fff">
                <table style="margin-bottom:0px;" width="100%" cellspacing="0" cellpadding="0">
                    <tbody><tr>

                        <td width="45%">
                            <div class="btn-group bootstrap-select">
                                <select name="accepts" id="accepts" style="width: 100%;padding: 0px">
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

                        <td width="24%" style="background-color: #fff">
                            <div>

                                <input type="text" class="tribe-bar-views-select tribe-no-param" placeholder="Zip Code" name="zip" style="width: 100% !important;padding: 0px" value="'.$_REQUEST['zip'].'">
                            </div>
                        </td>
                        <td width="29%" style="padding: 0px">
                            <div class="btn-group bootstrap-select">
                                <input type="submit" value="FIND" style="width: 100%">
                            </div>
                        </td>
                    </tbody>
                </table>
            </div>

        </div></form>

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

        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/my-profile"><button style="background-color: #ff9279">My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="sc_contact_form_wrap">
        <p id="vendor_added" style="color: #fff; background-color: #007f00; padding: 10px;display: none">Vendor added successfully!!!</p>
        <p id="vendor_exits" style="color: #fff; background-color: #ff0000; padding: 10px;display: none">User of this email already exists!!!</p>
      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">

            <div style="width: 100%; display: none;color: #ff0000;text-align: center;border: 1px solid #000;
  padding: 10px;
  box-shadow: 5px 10px 8px #888888;margin-bottom:30px;" id="error_message">

            </div>

            <div style="width: 100%; color: #ff0000;text-align: center;font-size: 25px;padding-bottom: 20px;">
                All fields with <span style="color: #ff0000">*</span> are required
            </div>

            <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
                <label for="username">First Name <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="First Name" name="fname" id="first_name" value="<?php echo $_SESSION['ses_user']['fname'] ?>">
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
                <label for="username">Last Name <span style="color: #ff0000">*</span></label>
                <input type="text" placeholder="Last Name" name="lname" id="last_name" value="<?php echo $_SESSION['ses_user']['lname'] ?>">
            </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Email <span style="color: #ff0000">*</span></label>
                    <input type="text" placeholder="Email" name="email" id="femail" value="<?php echo $_SESSION['ses_user']['email'] ?>" >
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Cell </label>
                    <input type="text" placeholder="Cell" name="cell" id="cell" value="<?php echo $_SESSION['ses_user']['cell'] ?>" >
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="username">Title </label>
                    <input type="text" placeholder="Title" name="title" id="title" value="<?php echo $_SESSION['ses_user']['title'] ?>">
                </div>
                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Photo</label>
                    <?php if(!empty($_SESSION['ses_user']['image'])): ?>
                        <br/><img src="<?php echo $_SESSION['ses_user']['image'] ?>" width="100" /><br/>
                    <?php else: ?>
                        <br/><img src="https://collinfannincms.org/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" width="100" /><br/>
                    <?php endif; ?>
                    <input type="file" name="image"  style="border:none;padding-left:0px;" />
                    <p>250 px X 250px size photo is recommended</p>
                </div>

              <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="pass">Password</label>
                    <input type="password" placeholder="Password" name="pass" id="pass" value="">
                </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="pass">Confirm Password</label>
                    <input type="password" placeholder="Confirm Password" name="cpass" id="cpass" value="">
                </div>
            </div>


            <div class="sc_contact_form_info">
            <h3>Office Info:</h3><p></p>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
                <label for="name">Background Pic</label>
                <?php if(!empty($_SESSION['ses_user']['bg_image'])): ?>
                    <br/><img src="<?php echo $_SESSION['ses_user']['bg_image'] ?>" width="100" /><br/>
                <?php else: ?>
                    <br/><img src="https://physicianfinder.collinfannincms.org/wp-content/uploads/2019/11/Office-Background.jpg?id=2543" width="200" /><br/>
                <?php endif; ?>
                <input type="file" name="bg_image" style="border:none;padding-left:0px;" />
                <p>1600px X 235px size photo is recommended</p>
            </div>

                <div class="clearfix"></div>


            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Address 1 <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Office Address 1" name="office_address1" id="office_address1" value="<?php echo $_SESSION['ses_user']['office_address1'] ?>" >
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Address 2</label>
              <input type="text" placeholder="Office Address 2" name="office_address2" id="office_address2" value="<?php echo $_SESSION['ses_user']['office_address2'] ?>">
            </div>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">City <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Office City" name="office_city" id="office_city" value="<?php echo $_SESSION['ses_user']['office_city'] ?>" >
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">State <span style="color: #ff0000">*</span></label>
              <select id="office_state" name="office_state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" >
                <option value="">Select State</option>
                <?php foreach($state_lists as $key=>$state_list): ?>
                    <option <?php if($_SESSION['ses_user']['office_state'] == $key): ?> selected="selected" <?php endif; ?> value="<?php echo $key ?>"><?php echo $state_list.' - '.$key ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Zip <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Office Zip Code" name="office_zip" id="office_zip" value="<?php echo $_SESSION['ses_user']['office_zip'] ?>" >
            </div>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Phone <span style="color: #ff0000">*</span> (Ex. (972) 555-5555)</label>
              <input type="text" placeholder="Office Phone" name="office_phone" id="office_phone" value="<?php echo $_SESSION['ses_user']['office_phone'] ?>" >
            </div>


            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="office_fax">Office Fax <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Office Fax" name="office_fax" id="office_fax" value="<?php echo $_SESSION['ses_user']['office_fax'] ?>" >
            </div>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Office Email <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Office Email" name="office_email" id="office_email" value="<?php echo $_SESSION['ses_user']['office_email'] ?>" >
            </div>

            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="name">Website <span style="color: #ff0000">*</span></label>
              <input type="text" placeholder="Website" name="website" id="website" value="<?php echo $_SESSION['ses_user']['website'] ?>" >
            </div>

                <div class="sc_contact_form_item sc_contact_form_field label_over">
                    <label for="name">Years in Business </label>
                    <input type="text" placeholder="Years in Business" name="year_in_business" id="year_in_business" value="<?php echo $_SESSION['ses_user']['year_in_business'] ?>" >
                </div>
                <div class="clearfix"></div>

            <div class="sc_contact_form_item sc_contact_form_message label_over" style="width:100%;margin-left: 0px">
                <label for="biography">About Company <span style="color: #ff0000">*</span></label>
                <textarea placeholder="Biography" name="biography" id="biography" style="height: 200px" ><?php echo $_SESSION['ses_user']['biography'] ?></textarea>
            </div>

                <div class="clearfix"></div>







            <h3>Category:  (Please check all that applies)</h3>
            <div>
                <div class="sc_contact_form_item sc_contact_form_field label_over" style="width: 100%">
                    <?php
                        $arr = json_decode($_SESSION['ses_user']['cat_list']);
                    ?>
                    <table width="100%">
                        <?php for($i=0; $i<count($catLists); $i+=3): ?>
                            <tr>
                                <td width="33%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input type="checkbox" class="myCheckBox" name="cat_list[]" value="<?php echo $catLists[$i]['title'] ?>" <?php if(in_array($catLists[$i]['title'],$arr)): ?> checked <?php endif; ?>></span><?php echo $catLists[$i]['title'] ?></label></td>
                                <td width="33%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input type="checkbox" class="myCheckBox" name="cat_list[]" value="<?php echo $catLists[$i+1]['title'] ?>" <?php if(in_array($catLists[$i+1]['title'],$arr)): ?> checked <?php endif; ?>></span><?php echo $catLists[$i+1]['title'] ?></label></td>
                                <td width="33%"><label><span style="display: inline-block;margin-right: 5px">&nbsp;&nbsp;<input type="checkbox" class="myCheckBox" name="cat_list[]" value="<?php echo $catLists[$i+2]['title'] ?>" <?php if(in_array($catLists[$i+2]['title'],$arr)): ?> checked <?php endif; ?>></span><?php echo $catLists[$i+2]['title'] ?></label></td>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>

                <div class="clearfix"></div>

          </div>

          <div class="clearfix"></div>



          <input type="hidden" name="formsub" value="1">

          <div style="width: 100%; color: #ff0000;text-align: center;font-size: 25px;padding-bottom: 20px;padding-top:20px;">
                All fields with <span style="color: #ff0000">*</span> are required
          </div>


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
    
    <?php if(!empty($cfcmsLists)): ?>
    <h2>RESULTS:</h2>
    
    <div class="sc_team_wrap" id="sc_team_659112401_wrap"><div data-slides-per-view="4" data-interval="7559" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_659112401"><div class="sc_columns columns_wrap">
    <?php foreach($cfcmsLists as $cfcmsList): ?><div class="column-1_4 column_padding_bottom"><div class="sc_team_item sc_team_item_1 odd first">
				<div class="sc_team_item_avatar"><img width="370" height="415" src="<?php if(!empty($cfcmsList['image'])): ?><?php echo $cfcmsList['image']; else: ?>https://collinfannincms.org/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg<?php endif; ?>" alt="<?php echo $cfcmsList['name'] ?>" class="wp-post-image">					<div class="sc_team_item_hover">
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
    });

    function formvalidation() {
        var flag = 0;
        fstr = "";
        fstr1 = "";

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
            jQuery("#last_name").css('border','2px solid #f4f4f4');
        }

        if(jQuery("#femail").val() =='') {
            jQuery("#femail").css('border','2px solid #FFA9A9');
            flag = 1;
            fstr += "Email, ";
        }
        else {
            jQuery("#femail").css('border','2px solid #f4f4f4');
        }

        if(jQuery("#pass").val() !='') {
            if(jQuery("#cpass").val() == '') {
                jQuery("#cpass").css('border', '2px solid #FFA9A9');
                flag = 1;
                fstr += "Confirm password, ";
            }
            else {
                if(jQuery("#pass").val() != jQuery("#cpass").val()) {
                    flag = 1;
                    fstr1 += "Password and confirm password are not same";
                }
            }
        }


        if(flag == 1) {

            var str11 = fstr.substring(0, fstr.length - 2);
            if(str11.length >0) {
                jQuery("#error_message").html("Oops! The following required field(s) are missing: " + str11);
            }
            if(fstr1.length >0) {
                if(str11.length >0) {
                    jQuery("#error_message").html("Oops! The following required field(s) are missing: " + str11+'<br/>' + fstr1);
                }
                else {
                    jQuery("#error_message").html(fstr1);
                }
            }
            jQuery("#error_message").css('display','block');

            window.scrollTo(0, 0);

            return false;
        }
        else {
            jQuery.get( "<?php echo get_site_url()  ?>/my-profile?email="+jQuery("#femail").val()+"&id=<?php echo $_SESSION['ses_user']['id'] ?>", function( data ) {
                if(data == 'User email exists') {
                    jQuery("#femail").css('border','2px solid #FFA9A9');

                    jQuery('#vendor_added').css('display','none');
                    jQuery('#vendor_exits').css('display','block');

                    jQuery("html, body").animate({ scrollTop: 0 }, "slow");

                }
                else {

                    jQuery("#myform").submit();
                }
            });

            //return true;
           /* var form = jQuery("#myform");
            var url = form.attr('action');

            jQuery.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(data)
                {
                    if(data == 'User email exists') {
                        jQuery("#femail").css('border','2px solid #FFA9A9');

                        jQuery('#vendor_added').css('display','none');
                        jQuery('#vendor_exits').css('display','block');

                        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                    else if(data == 'User added successfully') {
                        jQuery("#femail").css('border','2px solid #f4f4f4');

                        jQuery('#vendor_added').css('display','block');
                        jQuery('#vendor_exits').css('display','none');


                        jQuery("#myform").trigger("reset");

                        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                    }
                }
            });*/

            return false;
        }

    }

    </script>

<?php get_footer(); ?>
