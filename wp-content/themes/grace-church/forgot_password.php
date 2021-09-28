<?php

/**
 * Template Name: Forgot Password Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
$flag = 0;
/*function set_html_content_type() {
	return 'text/html';
}*/
if(!empty($_POST)) {
	
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$privatekey = '6LfDt0saAAAAABvWWkoOskO4qpZk2IbSjgU7E5K5';
	$response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
	$data = json_decode($response);
	
	
	
	if(!empty($data->success) && ($data->success == true)) {
		
		global $wpdb;
		$cfcms_info = $wpdb->get_row("select password from ".$wpdb->prefix."cfcms_directory where `office_email` = '".$_POST['email']."'",'ARRAY_A');		
		
		if(!empty($cfcms_info)) {
            $message = 'Your password is:<br/>';
            $message .= '<b>' . $cfcms_info['password'] . '</b>';


            $email = get_option('admin_email');
            $headers = 'From: Collin Fannin <' . $_POST['email'] . '>' . "\r\n";

            add_filter('wp_mail_content_type', 'set_html_content_type');
            wp_mail($_POST['email'], 'Forgot Password Email', $message, $headers);
            remove_filter('wp_mail_content_type', 'set_html_content_type');
            $flag = 1;
            $_POST = array();
        }
		else {
		    $flag = 3;
        }
	}
	else {
		$flag = 2;
	}
}

$frontpage_id = get_option('page_on_front');
$self_id = get_the_ID();
global $within_section;
$within_section = 'y';
get_header();

?>
<script>
	
	function IsEmail(email) {
	  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	
	function formvalidation() {
		var flag = 0;
		
		if(jQuery("#sc_contact_form_email").val() =='') {
			jQuery("#sc_contact_form_email").css('border-color','#ff0000');
			flag = 1;
		}
		else if(!IsEmail(jQuery("#sc_contact_form_email").val())) {
			jQuery("#sc_contact_form_email").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_email").css('border-color','#f4f4f4');
		}
			
		if(flag == 1) {
			
			jQuery("html, body").animate({ scrollTop: 0 }, "slow"); 
			
			return false;	
		}
		else {
			jQuery("form#myform").submit();
		}
	}
	
	
  
</script>
<style>
.sc_contact_form1.sc_contact_form_style_1 .sc_contact_form_info .sc_contact_form_item {
	width: 100%;
}
</style>




<div class="sc_contact_form_wrap">
  <?php if($flag == 1): ?>
  	<p style="color: #fff; background-color: #007f00; padding: 10px;">Password sent to your email successfully!!!</p>
  <?php endif; ?>
  <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
  <h2>FORGOT PASSWORD</h2>	
    <form action="" method="post" id="myform">
      <div class="sc_contact_form_info">
        <div class="sc_contact_form_item sc_contact_form_field label_over" style="margin-bottom:20px;">
          <input type="text" placeholder="Email *" name="email" id="sc_contact_form_email" value="<?php echo $_POST['email'] ?>">
        </div>
      
      <input type="hidden" name="formsub" value="1">
      
      <div class="g-recaptcha" data-sitekey="6LfDt0saAAAAALIWCm2nqPRNSgjG6YUqWPZU_RPD"></div>
      
      <?php if($flag == 2): ?>
	      <p style="background-color:#ff0000;color:#fff;padding-left:10px">Failed! Please confirm that you are not a robot!</p>
      <?php endif; ?>

      <?php if($flag == 3): ?>
          <p style="background-color:#ff0000;color:#fff;padding-left:10px">Please confirm that you are a valid user.</p>
      <?php endif; ?>
      
      <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:20px;margin-left:0px;">
        <button onclick="return formvalidation()">SUBMIT</button>
      </div>
    </form>
  </div>
</div>
<?php get_footer(); ?>
