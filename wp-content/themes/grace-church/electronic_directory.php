<?php
/**
 * Template Name: Electronic Directory Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
if(!empty($_POST)) {
	global $wpdb;
	
	if($_POST['pass'] == 'cfcms2016!') {
		//wp_redirect('http://emconsultinginc.com/Digital_Publications/Collin_Fannin/Membership_Directory/2015/');
		wp_redirect('http://www.emconsultinginc.com/Digital_Publications/CollinFannin/md_2016/');
		exit();	
	}
}
get_header();
	
?>

<style>
	.sc_contact_form1.sc_contact_form_style_1 .sc_contact_form_info .sc_contact_form_item {
		width: 47.45%;
	}
	label{
		color:#000;	
	}
</style>

<div class="sc_contact_form_wrap">
  <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
	<h2>ELECTRONIC DIRECTORY:</h2><p></p>
	<form action="" method="post" id="myform" enctype="multipart/form-data">
	  <div class="sc_contact_form_info">
		<div class="sc_contact_form_item sc_contact_form_field label_over">
		  <label for="pass">Password</label>
		  <input type="password" placeholder="Password" name="pass" id="pass">
		</div>
        <?php if(!empty($_POST['pass']) && ($_POST['pass'] != 'cfcms2016!')) { ?>
	        <p style="color:#F00">Incorrect Password!!</p>
        <?php } ?>
	  </div>
	  <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
		<button>SUBMIT</button>
	  </div>
	</form> 
  </div> 
</div> 
	  


<?php get_footer(); ?>
