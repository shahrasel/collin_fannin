<?php

/**
 * Template Name: Single CFCMS
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
$frontpage_id = get_option('page_on_front');
$self_id = get_the_ID();
global $within_section;
$within_section = 'y';
get_header();
if(!empty($_GET['id'])) {
	$cfcms_info = $wpdb->get_row("select * from ".$wpdb->prefix."cfcms_directory where id =".$_GET['id'],'ARRAY_A');
	//print_r($cfcms_info);
}
?>
<link rel='stylesheet' id='js_composer_front-css'  href='http://gracechurch.ancorathemes.com/wp-content/plugins/js_composer/assets/css/js_composer.css?ver=4.7.4' type='text/css' media='all' />
<article class="itemscope post_item post_item_single_team post_featured_center post_format_standard post-69 team type-team status-publish has-post-thumbnail hentry team_group-group-1 team_group-group-3" itemscope="" itemtype="http://schema.org/Article">
        <section class="post_content" itemprop="articleBody">
          <div class="vc_row wpb_row vc_row-fluid">
            <div class="wpb_column vc_column_container vc_col-sm-4 vc_custom_1442222777601">
              <div class="wpb_wrapper">
                <div class="figure sc_image  sc_image_shape_square"><img src="<?php if(!empty($cfcms_info['image'])): ?><?php echo $cfcms_info['image']; else: ?>https://collinfannincms.com/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg<?php endif; ?>" alt="" style="width:200px"></div>
              </div>
            </div>
            <div class="wpb_column vc_column_container vc_col-sm-8 vc_custom_1442222637897">
              <div class="wpb_wrapper">
                <h4 class="sc_title sc_title_regular sc_align_left" style="text-align:left;font-size:2.667rem;margin-top:0px;"><?php echo $cfcms_info['name'] ?></h4>
                <div class="wpb_text_column wpb_content_element ">
                  <div class="wpb_wrapper">
                    <p><span class="theme_color"><?php echo $cfcms_info['specialty'] ?></span></p>
                  </div>
                </div>
                <h5 class="sc_title sc_title_regular" style="font-size:1em;">Biography</h5>
                <div class="sc_section animated fadeInUp normal" data-animation="animated fadeInUp normal" style="line-height: 1.5em;">
                  <div class="sc_section_inner">
                    <div class="wpb_text_column wpb_content_element  vc_custom_1436451136033">
                      <div class="wpb_wrapper">
                        <p><?php echo $cfcms_info['biography'] ?></p>
                      </div>
                    </div>
                  </div>
                </div>
                <!--<div class="sc_socials sc_socials_type_icons sc_socials_shape_round sc_socials_size_tiny team team_single animated fadeInUp normal" style="margin-top:2em;" data-animation="animated fadeInUp normal">
                  <div class="sc_socials_item"><a href="#" target="_blank" class="social_icons social_facebook"><span class="icon-facebook"></span></a></div>
                  <div class="sc_socials_item"><a href="#" target="_blank" class="social_icons social_twitter"><span class="icon-twitter"></span></a></div>
                  <div class="sc_socials_item"><a href="#" target="_blank" class="social_icons social_instagramm"><span class="icon-instagramm"></span></a></div>
                  <div class="sc_socials_item"><a href="#" target="_blank" class="social_icons social_gplus"><span class="icon-gplus"></span></a></div>
                </div>-->
              </div>
            </div>
          </div>
          <div class="vc_row wpb_row vc_row-fluid">
            <div class="wpb_column vc_column_container vc_col-sm-4">
              <div class="wpb_wrapper">
                <h6 class="sc_title sc_title_divider sc_align_left" style="margin-top:4em;margin-bottom:3em;text-align:left;"><span class="sc_title_divider_before"></span>Office Info<span class="sc_title_divider_after"></span></h6>
                <div class="sc_section animated fadeInUp normal" data-animation="animated fadeInUp normal" style="margin-top:1.25em !important;margin-bottom:1.8em !important;">
                  <div class="sc_section_inner">
                    <b style="color:#000">Address 1&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_address1'] ?><br/>
                    <b style="color:#000">Address 2&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_address2'] ?><br/>
                    <b style="color:#000">City&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_city'] ?><br/>
                    <b style="color:#000">State&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_state'] ?><br/>
                    <b style="color:#000">Zip&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_zip'] ?><br/>
                    <b style="color:#000">Phone&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_phone'] ?><br/>
                    <b style="color:#000">Fax&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_fax'] ?><br/>
                    <b style="color:#000">Email&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['office_email'] ?><br/>
                    <b style="color:#000">Website&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['website'] ?><br/>
                    
                  </div>
                </div>
                <!--<div class="sc_section animated fadeInUp normal" data-animation="animated fadeInUp normal">
                  <div class="sc_section_inner">
                    <h4 class="sc_title sc_title_iconed" style="margin-top:0px;"><span class="sc_title_icon sc_title_icon_left  sc_title_icon_small"><img src="http://gracechurch.ancorathemes.com/wp-content/uploads/2015/08/icon_team_member2.png" alt=""></span>Volunteering</h4>
                    <div class="wpb_text_column wpb_content_element  vc_custom_1441970330469">
                      <div class="wpb_wrapper">
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy</p>
                      </div>
                    </div>
                  </div>
                </div>-->
              </div>
            </div>
            <div class="wpb_column vc_column_container vc_col-sm-4">
              <div class="wpb_wrapper">
                <h6 class="sc_title sc_title_divider sc_align_left" style="margin-top:4em;margin-bottom:3em;text-align:left;"><span class="sc_title_divider_before"></span>School Info<span class="sc_title_divider_after"></span></h6>
                <div id="sc_skills_diagram_1816818853" class="sc_skills sc_skills_bar sc_skills_horizontal animated fadeInUp normal" data-animation="animated fadeInUp normal" data-type="bar" data-caption="Skills" data-dir="horizontal">
                  <b style="color:#000">Medical School&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['medical_school'] ?><br/>
                  <b style="color:#000">Internship&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['internship'] ?><br/>
                  <b style="color:#000">Board Certification(s)&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['board_certification'] ?><br/>
                </div>
              </div>
            </div>
            <div class="wpb_column vc_column_container vc_col-sm-4">
              <div class="wpb_wrapper">
                <h6 class="sc_title sc_title_divider sc_align_left" style="margin-top:4em;margin-bottom:3em;text-align:left;"><span class="sc_title_divider_before"></span>Education<span class="sc_title_divider_after"></span></h6>
                
                <b style="color:#000">Accepts Medicare&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['accept_medicare'] ?><br/>
                <b style="color:#000">Hospital Affiliation(s)&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['hospital_affiliation'] ?><br/>
                <b style="color:#000">Residency&nbsp;:&nbsp;&nbsp;</b><?php echo $cfcms_info['residency'] ?><br/>
                
                
              </div>
            </div>
          </div>
        </section>
      </article>
<?php get_footer(); ?>
