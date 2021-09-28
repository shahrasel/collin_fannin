<?php

/**
 * Template Name: Purchase Directory Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
$flag = 0;

if(!empty($_POST)) {
	
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$privatekey = '6LfDt0saAAAAABvWWkoOskO4qpZk2IbSjgU7E5K5';
	$response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
	$data = json_decode($response);
	
	if(!empty($data->success) && ($data->success == true)) {
	
		global $wpdb;
		$wpdb->query("INSERT INTO `wp_purchase_directory` (`id`, `name`, `email`, `cell`, `quantity`, `address`, `city`, `state`, `zip`, `message`, `created`) VALUES (NULL, '".$_POST['username']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['quantity']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['zip']."', '".$_POST['message']."', '".time()."')");
		
		
		$message = 'New purchase directory message:<br/><br/>';
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
		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		$flag = 1;
		$_POST = array();
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
?>
<script>
	
	function IsEmail(email) {
	  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	
	function formvalidation() {
		var flag = 0;
		
		if(jQuery("#sc_contact_form_username").val() =='') {
			jQuery("#sc_contact_form_username").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_username").css('border-color','#f4f4f4');
		}
		
		
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
		
		
		if(jQuery("#sc_contact_form_phone").val() =='') {
			jQuery("#sc_contact_form_phone").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_phone").css('border-color','#f4f4f4');
		}
		
		if(jQuery("#quantity").val() =='') {
			jQuery("#quantity").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#quantity").css('border-color','#f4f4f4');
		}
		
		if(jQuery("#sc_contact_form_address").val() =='') {
			jQuery("#sc_contact_form_address").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_address").css('border-color','#f4f4f4');
		}
		
		if(jQuery("#sc_contact_form_city").val() =='') {
			jQuery("#sc_contact_form_city").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_city").css('border-color','#f4f4f4');
		}
		
		if(jQuery("#sc_contact_form_message").val() =='') {
			jQuery("#sc_contact_form_message").css('border-color','#ff0000');
			flag = 1;
		}
		else {
			jQuery("#sc_contact_form_message").css('border-color','#f4f4f4');
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
	width: 47.45%;
}
</style>




<div class="sc_contact_form_wrap">
  <?php if($flag == 1): ?>
  	<p style="color: #fff; background-color: #007f00; padding: 10px;">Purchase request sent successfully!!!</p>
  <?php endif; ?>
  <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
  <h2>PURCHASE A DIRECTORY</h2>	
    <form action="" method="post" id="myform">
      <div class="sc_contact_form_info">
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Full Name *" name="username" id="sc_contact_form_username" value="<?php echo $_POST['username'] ?>">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Email *" name="email" id="sc_contact_form_email" value="<?php echo $_POST['email'] ?>">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Cell*" name="phone" id="sc_contact_form_phone" value="<?php echo $_POST['phone'] ?>">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <select name="quantity" id="quantity" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
          	<option value="">Select Quantity *</option>
            <option value="1" <?php if($_POST['quantity'] == '1'): ?> selected="selected" <?php endif; ?>>1</option>
            <option value="2" <?php if($_POST['quantity'] == '2'): ?> selected="selected" <?php endif; ?>>2</option>
            <option value="3" <?php if($_POST['quantity'] == '3'): ?> selected="selected" <?php endif; ?>>3</option>
            <option value="4" <?php if($_POST['quantity'] == '4'): ?> selected="selected" <?php endif; ?>>4</option>
            <option value="5" <?php if($_POST['quantity'] == '5'): ?> selected="selected" <?php endif; ?>>5</option>
            <option value="6" <?php if($_POST['quantity'] == '6'): ?> selected="selected" <?php endif; ?>>6</option>
            <option value="7" <?php if($_POST['quantity'] == '7'): ?> selected="selected" <?php endif; ?>>7</option>
            <option value="8" <?php if($_POST['quantity'] == '8'): ?> selected="selected" <?php endif; ?>>8</option>
            <option value="9" <?php if($_POST['quantity'] == '9'): ?> selected="selected" <?php endif; ?>>9</option>
            <option value="10" <?php if($_POST['quantity'] == '10'): ?> selected="selected" <?php endif; ?>>10</option>
          </select>
        </div>
        
        <h3>Mailing to:</h3><p></p>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Address *" name="address" id="sc_contact_form_address" value="<?php echo $_POST['address'] ?>">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="City *" name="city" id="sc_contact_form_city" value="<?php echo $_POST['city'] ?>">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <select name="state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
          	<option value="">Select State</option>
            <?php foreach($state_lists as $key=>$state_list): ?>
            	<option <?php if($_POST['state'] == $key): ?> selected="selected" <?php endif; ?> value="<?php echo $key ?>"><?php echo $state_list.' - '.$key ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Zip Code" name="zip" id="sc_contact_form_phone" value="<?php echo $_POST['zip'] ?>">
        </div>
        
        
      </div>
      <div class="sc_contact_form_item sc_contact_form_message label_over">
        <textarea placeholder="Message *" name="message" id="sc_contact_form_message"><?php echo $_POST['message'] ?></textarea>
      </div>
      <input type="hidden" name="formsub" value="1">
      
      <div class="g-recaptcha" data-sitekey="6LfDt0saAAAAALIWCm2nqPRNSgjG6YUqWPZU_RPD"></div>
      
      <?php if($flag == 2): ?>
	      <p style="background-color:#ff0000;color:#fff;padding-left:10px">Failed! Please confirm that you are not a robot!</p>
      <?php endif; ?>
      
      <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
        <button onclick="return formvalidation()">SUBMIT</button>
      </div>
    </form>
  </div>
</div>
<?php get_footer(); ?>
