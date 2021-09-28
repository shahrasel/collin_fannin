<?php

/**
 * Template Name: WPC Select Executive Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
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
  <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
    <form action="" method="post" id="myform">
      <div class="sc_contact_form_info">
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Full Name *" name="username" id="sc_contact_form_username">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Email *" name="email" id="sc_contact_form_email">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Cell*" name="phone" id="sc_contact_form_phone">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <select name="quantity" id="quantity" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
          	<option value="">Select Quantity *</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
        </div>
        
        <h3>Mailing to:</h3><p></p>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Address *" name="address" id="sc_contact_form_address">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="City *" name="city" id="sc_contact_form_city">
        </div>
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <select name="state" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;">
          	<option value="">Select State</option>
            <?php foreach($state_lists as $key=>$state_list): ?>
            	<option value="<?php echo $key ?>"><?php echo $state_list.' - '.$key ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <div class="sc_contact_form_item sc_contact_form_field label_over">
          <input type="text" placeholder="Zip Code" name="zip" id="sc_contact_form_phone">
        </div>
        
        
      </div>
      <div class="sc_contact_form_item sc_contact_form_message label_over">
        <textarea placeholder="Message *" name="message" id="sc_contact_form_message"></textarea>
      </div>
      <input type="hidden" name="formsub" value="1">
      
      <div class="g-recaptcha" data-sitekey="6LfDt0saAAAAALIWCm2nqPRNSgjG6YUqWPZU_RPD"></div>
      
      <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
        <button onclick="return formvalidation()">SEND</button>
      </div>
    </form>
  </div>
</div>
<?php get_footer(); ?>
