<?php
/**
 * Template Name: Prescription Newsletter Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
session_start();
get_header();

$sql = "SELECT * from ".$wpdb->prefix."posts where post_type = 'prescription' and post_status ='publish' order by post_date desc";
$prescriptionLists = $wpdb->get_results($sql,'ARRAY_A');

?>

<style>
	.sc_contact_form1.sc_contact_form_style_1 .sc_contact_form_info .sc_contact_form_item {
		width: 47.45%;
	}
	label {
		color: #000;
	}
</style>

<?php if(!empty($_SESSION['ses_user'])): ?>
    <div class="sc_contact_form_wrap" style="margin-bottom:40px">
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button>My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button >Appointment Requests</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/testimonials"><button>Testimonials</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="https://physicianfinder.collinfannincms.com/wp-content/uploads/2020/01/CollinFannin2019Dir_web.pdf" target="_blank"><button>Electronic Directory</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/prescription-newsletter"><button style="background-color: #ff9279">preSCRIPTion Newsletter</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>
<?php endif; ?>

    <?php if(!empty($prescriptionLists)): ?>
    <h2>Prescription Newsletter:</h2><br/><br/>
    
    <div class="sc_team_wrap" id="sc_team_659112401_wrap">
      <div data-slides-per-view="4" data-interval="7559" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_659112401">
        <div class="sc_columns columns_wrap">
          
          <?php foreach($prescriptionLists as $prescriptionList): ?>
          	  <?php $fileid = get_post_meta($prescriptionList['ID'], 'File Upload', true); ?>
                
              <div class="column-1_4 column_padding_bottom">
                <div class="sc_team_item sc_team_item_1 odd first">
                  <div class="sc_team_item_avatar">
                  	<a target="_blank" href="<?php echo wp_get_attachment_url( $fileid ); ?>">
                    	<img src="<?php echo get_template_directory_uri(); ?>/images/pdf_img.png" alt="" class="wp-post-image">
                    </a>
                    <br/>
					<p style="text-align:center"><?php echo $prescriptionList['post_title'] ?></p>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
