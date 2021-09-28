<?php
/**
 * The template for displaying the footer.
 */

global $GRACE_CHURCH_GLOBALS;

				grace_church_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (grace_church_get_custom_option('body_style')!='fullscreen') grace_church_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
            
            
			
			<?php
			// Footer Testimonials stream
			if (grace_church_get_custom_option('show_testimonials_in_footer')=='yes') {
				$count = max(1, grace_church_get_custom_option('testimonials_count'));
				$data = grace_church_sc_testimonials(array('count'=>$count));
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(grace_church_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}

            // Call to action
            $call_to_action  = grace_church_get_custom_option('show_call_to_action');
            $call_to_action_link = grace_church_get_custom_option('call_to_action_link');
            $call_to_action_title   = grace_church_get_custom_option('call_to_action_title');
            $call_to_action_picture   = grace_church_get_custom_option('call_to_action_picture');
            $call_to_action_description  = grace_church_get_custom_option('call_to_action_description');
            $call_to_action_link_caption   = grace_church_get_custom_option('call_to_action_link_caption');
            if ( $call_to_action == 'yes' ) {
                ?>
                <footer class="footer_wrap call_to_action scheme_<?php echo esc_attr(grace_church_get_custom_option('call_to_action_scheme')); ?> <?php echo ($call_to_action_picture ? ' width_image'  : ''); ?>">
                    <div class="call_to_action_inner content_wrap">
                            <?php /*?><?php
                            echo ($call_to_action_picture ? '<div class="block_image"><img src="'.esc_url($call_to_action_picture).'" alt="" class="call_to_action_image"></div>' : '');
                            echo do_shortcode('[trx_call_to_action style="2" align="left" accent="yes" title="' . esc_attr($call_to_action_title) . '" description="' . esc_attr($call_to_action_description) . '" link="' . esc_attr($call_to_action_link) . '" link_caption="' . esc_attr($call_to_action_link_caption) . '"][/trx_call_to_action]');
                            ?><?php */?>
                            
                            <ul class="menu_main_nav" style="padding-bottom:15px;padding-top:20px;display:table;margin:auto">
                            	<!--<li style="list-style:none"><a href="<?php echo site_url() ?>">Home</a></li>
								<li style="list-style:none"><a href="<?php echo site_url() ?>/grid-gallery/">EVENT PICS</a></li>
                                <li style="list-style:none"><a href="<?php echo site_url() ?>/category/standard-without-sidebar/">BLOG</a></li>
                                <li style="list-style:none"><a href="#">PRICING</a></li>
                                <li style="list-style:none"><a href="<?php echo site_url() ?>/events/category/meetings/">CALENDAR</a></li>
                                <li style="list-style:none"><a href="<?php echo site_url() ?>/contacts/">CONTACT</a></li>
                                <li style="list-style:none"><a href="#">SPONSORS</a></li>
                                <li style="list-style:none"><a href="#">FAQ</a></li>-->
                                <li style="list-style:none"><a href="<?php echo site_url() ?>">News</a></li>
                                <!--<li style="list-style:none"><a href="<?php echo site_url() ?>">Donate to CFMS Educational Foundation</a></li>
                                <li style="list-style:none"><a href="<?php echo site_url() ?>">Donate to Community Health Programs</a></li>-->
                                
                                <li style="list-style:none"><a href="http://www.pacollincounty.org" target="_blank">Project Access</a></li>
                                <li style="list-style:none"><a href="http://www.collincountytx.gov/healthcare_services/Pages/default.aspx" target="_blank">Collin County Healthcare Services </a></li>
                                <li style="list-style:none"><a href="<?php echo site_url() ?>/alerts">Alerts</a></li>
							</ul>
                    </div>	<!-- /.footer_wrap_inner -->
                </footer>	<!-- /.footer_wrap -->
            <?php
            }

			// Footer sidebar
			$footer_show  = grace_church_get_custom_option('show_sidebar_footer');
			$sidebar_name = grace_church_get_custom_option('sidebar_footer');
			if (!grace_church_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) {
				$GRACE_CHURCH_GLOBALS['current_sidebar'] = 'footer';
				/*?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(grace_church_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
							if ( !dynamic_sidebar($sidebar_name) ) {
								// Put here html if user no set widgets in sidebar
							}
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
							?></div>
						</div>
					</div>
				</footer>
			<?php
			*/}


			// Footer Twitter stream
			if (grace_church_get_custom_option('show_twitter_in_footer')=='yes') {
				$count = max(1, grace_church_get_custom_option('twitter_count'));
				$data = grace_church_sc_twitter(array('count'=>$count));
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(grace_church_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}


			// Google map
			if ( grace_church_get_custom_option('show_googlemap')=='yes' ) {
				$map_address = grace_church_get_custom_option('googlemap_address');
				$map_latlng  = grace_church_get_custom_option('googlemap_latlng');
				$map_zoom    = grace_church_get_custom_option('googlemap_zoom');
				$map_style   = grace_church_get_custom_option('googlemap_style');
				$map_height  = grace_church_get_custom_option('googlemap_height');
				if (!empty($map_address) || !empty($map_latlng)) {
					$args = array();
					if (!empty($map_style))		$args['style'] = esc_attr($map_style);
					if (!empty($map_zoom))		$args['zoom'] = esc_attr($map_zoom);
					if (!empty($map_height))	$args['height'] = esc_attr($map_height);
					echo grace_church_sc_googlemap($args);
				}
			}


			// Footer contacts
			if (grace_church_get_custom_option('show_contacts_in_footer')=='yes') {
                $fax = grace_church_get_theme_option('contact_fax');
                $phone = grace_church_get_theme_option('contact_phone');
                $address_1 = grace_church_get_theme_option('contact_address_1');
                $contact_open_hours = grace_church_get_theme_option('contact_open_hours');
				$contact_open_hours_2 = grace_church_get_theme_option('contact_open_hours_2');
				$logo_footer = grace_church_get_custom_option('logo_footer');
				if (!empty($address_1) || !empty($phone) || !empty($fax) || !empty($logo_footer)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(grace_church_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
							<div class="content_wrap">
                                <?php if ($logo_footer) {?>
                                    <div class="logo_in_footer"><?php echo ('<img src="'.esc_url($logo_footer).'" alt="" >') ; ?></div>
                                <?php } ?>
								<div class="contacts_address">
                                    <div class="address address_left">
                                        <?php if (!empty($address_1)) echo ('<span class="icon-location"></span>') . '  ' .($address_1); ?>
                                    </div>
									<div class="address address_center">
										<?php if (!empty($phone)) echo ('<span class="icon-phone"></span>') . '  <a style="color: #fff" href="tel: '.$phone.' ">' . ($phone).'</a>' ; ?>
										<?php if (!empty($fax)) echo ('<br/><span class="icon-print"></span>') . '  <a style="color: #fff">' . ($fax).'</a>' ; ?>
									</div>
                                    <div class="address address_right">
                                        <span><?php if (!empty($contact_open_hours)) echo ($contact_open_hours) ; ?></span>
                                        <span><?php if (!empty($contact_open_hours_2)) echo ($contact_open_hours_2) ; ?></span>
                                    </div>
                                </div>
							</div>	<!-- /.content_wrap -->
                        </div>	<!-- /.contacts_wrap_inner -->

                        <?php // Footer contacts form
                        if ( grace_church_get_custom_option('show_footer_contacts_form')=='yes' ) { ?>
                            <div class="content_wrap content_contacts_form">
                                <?php echo do_shortcode('[trx_contact_form style="1" custom="no"][/trx_contact_form]'); ?>
                            </div>
                        <?php } ?>

					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}


			// Copyright area
			$copyright_style = grace_church_get_custom_option('show_copyright_in_footer');
			if (!grace_church_param_is_off($copyright_style)) {
			?>
                <footer class="footer_wrap call_to_action scheme_original " style="background-color: #effdff;">
                    <div class="call_to_action_inner content_wrap">
                        <ul class="menu_main_nav" style="padding-bottom:15px;padding-top:20px;display:table;margin:auto">
                            <li style="list-style:none"><a style="color:#6e6a6b" href="https://collinfannincms.org">HOME</a></li>
                            <li style="list-style:none"><a style="color:#6e6a6b" href="http://www.pacollincounty.org" target="_blank">SEARCH BEST OF</a></li>
                            <li style="list-style:none"><a  style="color:#6e6a6b" href="http://www.collincountytx.gov/healthcare_services/Pages/default.aspx" target="_blank">WHY JOIN BEST OF?</a></li>
                        </ul>
                    </div>	<!-- /.footer_wrap_inner -->
                </footer>
                <div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(grace_church_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner" style="background-color: #003D89">
						<div class="content_wrap" style="text-align: center">
							<?php
							if ($copyright_style == 'menu') {
								if (empty($GRACE_CHURCH_GLOBALS['menu_footer']))	$GRACE_CHURCH_GLOBALS['menu_footer'] = grace_church_get_nav_menu('menu_footer');
								if (!empty($GRACE_CHURCH_GLOBALS['menu_footer']))	echo ($GRACE_CHURCH_GLOBALS['menu_footer']);
							} else if ($copyright_style == 'socials') {
								echo grace_church_sc_socials(array('size'=>"tiny"));
							}
							?>
							<div class="copyright_text"><?php echo force_balance_tags(grace_church_get_theme_option('footer_copyright')); ?></div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->
	
	<?php if ( !grace_church_param_is_off(grace_church_get_custom_option('show_sidebar_outer')) ) { ?>
	</div>	<!-- /.outer_wrap -->
	<?php } ?>

<?php
if (grace_church_get_custom_option('show_theme_customizer')=='yes') {
	require_once( grace_church_get_file_dir('core/core.customizer/front.customizer.php') );
}
?>

<a href="#" class="scroll_to_top icon-up" title="<?php esc_html_e('Scroll to top', 'grace-church'); ?>"></a>

<div class="custom_html_section">
<?php echo force_balance_tags(grace_church_get_custom_option('custom_code')); ?>
</div>

<?php echo force_balance_tags(grace_church_get_custom_option('gtm_code2')); ?>





<?php
$tablet_browser = 0;
$mobile_browser = 0;
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}

$deviceType = '';
 
if ($tablet_browser > 0) {
   // do something for tablet devices
   $deviceType = 'tablet';
}
else if ($mobile_browser > 0) {
   // do something for mobile devices
   $deviceType = 'phone';
}
else {
   // do something for everything else
   $deviceType = 'computer';
}   
//$deviceType = 'tablet';
?>

<?php if($deviceType == 'phone'): ?>
    <div id="calltextdiv" style="position: fixed; width: 100%; height: 60px; color: rgb(255, 255, 255); bottom: 0px; text-align: center; background-color: #ff684f;display:none;z-index:100000000">
        <div style="background-position:right center; background-repeat:no-repeat;width:48%;float:left;height:54px;line-height:50px;background-position:98%;font-size:20px;border-right:1px solid #fff;padding-top:5px;">
            <a href="tel: (469) 291-1954" style="color:#FFF">Call Us</a>
        </div>
        
        <div style="background-position:right center;background-repeat:no-repeat;width:48%;float:right;height:54px;line-height:50px;padding-right:10px;background-position:98%;font-size:20px;padding-top:5px;">
            <a href="mailto:scb@collinfannincms.org" style="color:#FFF">Email Us</a>
        </div>
    </div>
<?php endif; ?>




<?php wp_footer(); ?>

<?php if($deviceType == 'phone'): ?>
	<script type="text/javascript">
        jQuery(window).scroll(function (event) {
            var scroll = jQuery(window).scrollTop();
            //console.log( scroll );
            if(scroll > 500) {
                jQuery("#calltextdiv").css('display','block');	
            }
            else {
                jQuery("#calltextdiv").css('display','none');	
            }
        });
    </script>
<?php endif; ?>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52b60d00762dc32f" async="async"></script>

</body>
</html>