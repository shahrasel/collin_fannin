<?php

/**
 * Template Name: WPC Sponsors Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
$frontpage_id = get_option('page_on_front');
$self_id = get_the_ID();
global $within_section;
$within_section = 'y';
get_header();

$strategic_sponsor_lists = getStrategicPartner();
$platinum_sponsor_lists = getPlatinumSponsors();
$gold_sponsor_lists = getGoldSponsors();
$silver_sponsor_lists = getSilverSponsors();
/*print_r($gold_sponsor_lists);
exit;*/
?>

<div class="sc_columns columns_wrap" style="background-color:#83848e;padding:15px;color:#fff;font-size:37px;text-align:center;line-height:40px;">
	CIRCLE OF FRIENDS
</div>

<?php if(!empty($strategic_sponsor_lists)): ?>
<h2 style="text-align:center;border-bottom:2px solid #f4f4f4;padding-bottom:10px;margin-bottom:25px">PLATINUM</h2>




	<?php foreach($strategic_sponsor_lists as $sponsor_list): ?>
    	<?php 
			$pdf_file_id =  get_post_meta($sponsor_list['id'], 'Photo', false);
			$top_image = wp_get_attachment_image($pdf_file_id[0], 'strategic-partner-image'); 
		?>
        <div class="sc_columns columns_wrap" style="background-color:#f8f8f8;padding:10px;">
            <div class="column-1_4 column_padding_bottom">
                <?php echo $top_image ?>
            </div>
            
            <div class="column-5_7 column_padding_bottom">
                <?php echo wp_get_attachment_image( get_post_thumbnail_id($sponsor_list['id']),'strategic-partner-company-image' ); ?>
            </div>
            
            
            <div class="column-2_3 column_padding_bottom" style="background-color:#fff;padding:10px;margin-right:10px;">
                <h5 class="post_title"><?php echo $sponsor_list['title'] ?></h5>
                <p><?php echo $sponsor_list['meta']['Title'][0] ?></p>
                <h6>About</h6>
                <p><?php echo $sponsor_list['posttext'] ?></p>
            </div>
            <div class="column-2_7 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                
                    <?php if(!empty($sponsor_list['meta']['Phone'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" >
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;padding-top:4px">
                            <?php echo $sponsor_list['meta']['Phone'][0] ?>
                        </div>
                    <?php endif; ?>
                	
                    
                    <?php if(!empty($sponsor_list['meta']['Email'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;padding-top:4px">
                            <a href="mailto:<?php echo $sponsor_list['meta']['Email'][0] ?>"><?php echo $sponsor_list['meta']['Email'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    
                    <?php if(!empty($sponsor_list['meta']['Website'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;padding-top:4px">
                            <a href="<?php echo $sponsor_list['meta']['Website'][0] ?>" target="_blank"><?php echo $sponsor_list['meta']['Website'][0] ?></a>
                        </div>
                    <?php endif; ?>
                
                	<?php if(!empty($sponsor_list['meta']['Address'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;padding-top:4px">
                            <a href="http://maps.google.com/?q=<?php echo $sponsor_list['meta']['Address'][0] ?>" target="_blank"><?php echo $sponsor_list['meta']['Address'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    
                    <div class="column-3_4 column_padding_bottom" style="display: table; padding: 10px; margin-top: 20px;">
                    
                    
                    	
                        
                        <div data-animation="animated fadeInUp normal" style="margin-top:2em;" class="sc_socials sc_socials_type_icons sc_socials_shape_round sc_socials_size_tiny team team_single animated fadeInUp normal">
                          <?php if(!empty($sponsor_list['meta']['Facebook'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_facebook" target="_blank" href="<?php echo $sponsor_list['meta']['Facebook'][0] ?>"><span class="icon-facebook"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Twitter'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_twitter" target="_blank" href="<?php echo $sponsor_list['meta']['Twitter'][0] ?>"><span class="icon-twitter"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Instagram'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_instagramm" target="_blank" href="<?php echo $sponsor_list['meta']['Instagram'][0] ?>"><span class="icon-instagramm"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Googleplus'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_gplus" target="_blank" href="<?php echo $sponsor_list['meta']['Googleplus'][0] ?>"><span class="icon-gplus"></span></a></div>
                          <?php endif; ?>
                        </div>
                        
                        
                    
                    
                    
                    
                        
                        <?php /*?><?php if(!empty($sponsor_list['meta']['Facebook'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Facebook'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_facebook.png"></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($sponsor_list['meta']['Twitter'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Twitter'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_twitter.png"></a>
                            </div>
                        <?php endif; ?>
                        
                        
                        <?php if(!empty($sponsor_list['meta']['Instagram'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Instagram'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_instagram.png"></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($sponsor_list['meta']['Googleplus'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Googleplus'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_googleplus.png"></a>
                            </div>
                        <?php endif; ?><?php */?>
                    </div>
                
            </div>	
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(!empty($platinum_sponsor_lists)): ?>
<h2 style="text-align:center;border-bottom:2px solid #f4f4f4;padding-bottom:10px;margin-bottom:15px;margin-bottom:25px">GOLD</h2>
	<?php foreach($platinum_sponsor_lists as $sponsor_list): ?>
    	<div class="sc_columns columns_wrap" style="background-color:#f8f8f8;padding:10px;">
            <div class="column-6_12 column_padding_bottom">
                <?php echo wp_get_attachment_image( get_post_thumbnail_id($sponsor_list['id']),'platinum-partner-company-image' ); ?>
            </div>
            
            <div class="column-5_12 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                
                	<?php if(!empty($sponsor_list['meta']['Name'][0])): ?>
                        <div class="column-1 column_padding_bottom" style="padding-bottom: 10px;font-weight: bold;font-size: 16px;">
                            <?php echo $sponsor_list['meta']['Name'][0] ?>
                        </div>
                    <?php endif; ?>
                    
					<?php if(!empty($sponsor_list['meta']['Phone'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" >
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <?php echo $sponsor_list['meta']['Phone'][0] ?>
                        </div>
                    <?php endif; ?>
                	
                    
                    <?php if(!empty($sponsor_list['meta']['Email'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="mailto:<?php echo $sponsor_list['meta']['Email'][0] ?>"><?php echo $sponsor_list['meta']['Email'][0] ?></a>
                        </div>
                    <?php endif; ?>
                	
                    
                    <?php if(!empty($sponsor_list['meta']['Website'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="<?php echo $sponsor_list['meta']['Website'][0] ?>" target="_blank"><?php echo $sponsor_list['meta']['Website'][0] ?></a>
                        </div>
                    <?php endif; ?>
                	
                    
                    <?php if(!empty($sponsor_list['meta']['Address'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;">
                            <a href="http://maps.google.com/?q=<?php echo $sponsor_list['meta']['Address'][0] ?>" target="_blank"><?php echo $sponsor_list['meta']['Address'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="column-3_4 column_padding_bottom" style="display: table; padding: 10px; margin-top: 20px;">
                        <div data-animation="animated fadeInUp normal" style="margin-top:2em;" class="sc_socials sc_socials_type_icons sc_socials_shape_round sc_socials_size_tiny team team_single animated fadeInUp normal">
                          <?php if(!empty($sponsor_list['meta']['Facebook'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_facebook" target="_blank" href="<?php echo $sponsor_list['meta']['Facebook'][0] ?>"><span class="icon-facebook"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Twitter'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_twitter" target="_blank" href="<?php echo $sponsor_list['meta']['Twitter'][0] ?>"><span class="icon-twitter"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Instagram'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_instagramm" target="_blank" href="<?php echo $sponsor_list['meta']['Instagram'][0] ?>"><span class="icon-instagramm"></span></a></div>
                          <?php endif; ?>
                          
                          <?php if(!empty($sponsor_list['meta']['Googleplus'][0])): ?>
                          	<div class="sc_socials_item"><a class="social_icons social_gplus" target="_blank" href="<?php echo $sponsor_list['meta']['Googleplus'][0] ?>"><span class="icon-gplus"></span></a></div>
                          <?php endif; ?>
                        </div>
						
						<?php /*?><?php if(!empty($sponsor_list['meta']['Facebook'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Facebook'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_facebook.png"></a>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($sponsor_list['meta']['Twitter'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Twitter'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_twitter.png"></a>
                            </div>
                        <?php endif; ?>
                        
                        
                        <?php if(!empty($sponsor_list['meta']['Instagram'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Instagram'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_instagram.png"></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($sponsor_list['meta']['Googleplus'][0])): ?>
                            <div class="column-1_4" style="float:left;padding-bottom:10px;">
                                <a target="_blank" href="<?php echo $sponsor_list['meta']['Googleplus'][0] ?>"><img src="<?php echo site_url() ?>/wp-content/uploads/images/btn_googleplus.png"></a>
                            </div>
                        <?php endif; ?><?php */?>
                    </div>
                
            </div>	
        </div>
	<?php endforeach; ?>
<?php endif; ?>


<?php if(!empty($gold_sponsor_lists)): $i=0; ?>
<h2 style="text-align:center;border-bottom:2px solid #f4f4f4;padding-bottom:10px;margin-bottom:15px;margin-bottom:25px">SILVER</h2>
	<?php for($i=0; $i<=count($gold_sponsor_lists); $i+=2): ?>
    	<?php if($i%2==0): ?>
        	<div class="sc_columns columns_wrap" style="background-color:#f8f8f8;padding:10px;">
        <?php endif; ?>
		<?php if(!empty($gold_sponsor_lists[$i])): ?>
            <div class="column-5_12 column_padding_bottom">
                <p>
                    <?php echo wp_get_attachment_image( get_post_thumbnail_id($gold_sponsor_lists[$i]['id']),'silgold-partner-company-image' ); ?>
                </p>
                <div class="column-12_12 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                    <?php if(!empty($gold_sponsor_lists[$i]['meta']['Name'][0])): ?>
                        <div class="column-1 column_padding_bottom"  style="padding-bottom: 10px;font-weight: bold;font-size: 16px;">
                            <?php echo $gold_sponsor_lists[$i]['meta']['Name'][0] ?>
                        </div>
                    <?php endif; ?>
                    
					<?php if(!empty($gold_sponsor_lists[$i]['meta']['Phone'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" >
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <?php echo $gold_sponsor_lists[$i]['meta']['Phone'][0] ?>
                        </div>
                    <?php endif; ?>
                
                    <?php if(!empty($gold_sponsor_lists[$i]['meta']['Email'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="mailto:<?php echo $gold_sponsor_lists[$i]['meta']['Email'][0] ?>"><?php echo $gold_sponsor_lists[$i]['meta']['Email'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($gold_sponsor_lists[$i]['meta']['Website'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="<?php echo $gold_sponsor_lists[$i]['meta']['Website'][0] ?>" target="_blank"><?php echo $gold_sponsor_lists[$i]['meta']['Website'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($gold_sponsor_lists[$i]['meta']['Address'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;">
                            <a href="http://maps.google.com/?q=<?php echo $gold_sponsor_lists[$i]['meta']['Address'][0] ?>" target="_blank"><?php echo $gold_sponsor_lists[$i]['meta']['Address'][0] ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
            
		<?php if(!empty($gold_sponsor_lists[$i+1])): ?>
            <div class="column-5_12 column_padding_bottom" style="float:right">
                    <p>
                        <?php echo wp_get_attachment_image( get_post_thumbnail_id($gold_sponsor_lists[$i+1]['id']),'silgold-partner-company-image' ); ?>
                    </p>
                    <div class="column-12_12 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                        
                        <?php if(!empty($gold_sponsor_lists[$i+1]['meta']['Name'][0])): ?>
                            <div class="column-1 column_padding_bottom"  style="padding-bottom: 10px;font-weight: bold;font-size: 16px;">
                                <?php echo $gold_sponsor_lists[$i+1]['meta']['Name'][0] ?>
                            </div>
                        <?php endif; ?>
                        
						<?php if(!empty($gold_sponsor_lists[$i+1]['meta']['Phone'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" >
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <?php echo $gold_sponsor_lists[$i+1]['meta']['Phone'][0] ?>
                            </div>
                        <?php endif; ?>
                    
                        <?php if(!empty($gold_sponsor_lists[$i+1]['meta']['Email'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <a href="mailto:<?php echo $gold_sponsor_lists[$i+1]['meta']['Email'][0] ?>"><?php echo $gold_sponsor_lists[$i+1]['meta']['Email'][0] ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($gold_sponsor_lists[$i+1]['meta']['Website'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <a href="<?php echo $gold_sponsor_lists[$i+1]['meta']['Website'][0] ?>" target="_blank"><?php echo $gold_sponsor_lists[$i+1]['meta']['Website'][0] ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($gold_sponsor_lists[$i+1]['meta']['Address'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;">
                                <a href="http://maps.google.com/?q=<?php echo $gold_sponsor_lists[$i+1]['meta']['Address'][0] ?>" target="_blank"><?php echo $gold_sponsor_lists[$i+1]['meta']['Address'][0] ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php if(($i+1)%2==1): ?>    
        	</div>    
        <?php endif; ?>
	<?php endfor; ?>
<?php endif; ?>






<?php if(!empty($silver_sponsor_lists)): $i=0; ?>
<h2 style="text-align:center;border-bottom:2px solid #f4f4f4;padding-bottom:10px;margin-bottom:15px;margin-bottom:25px">BRONZE</h2>
	<?php for($i=0; $i<=count($silver_sponsor_lists); $i+=2): ?>
    	<?php if($i%2==0): ?>
        	<div class="sc_columns columns_wrap" style="background-color:#f8f8f8;padding:10px;">
        <?php endif; ?>
		<?php if(!empty($silver_sponsor_lists[$i])): ?>
            <div class="column-5_12 column_padding_bottom">
                <p>
                    <?php echo wp_get_attachment_image( get_post_thumbnail_id($silver_sponsor_lists[$i]['id']),'silgold-partner-company-image' ); ?>
                </p>
                <div class="column-12_12 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                    
                    <?php if(!empty($silver_sponsor_lists[$i]['meta']['Name'][0])): ?>
                        <div class="column-1 column_padding_bottom"  style="padding-bottom: 10px;font-weight: bold;font-size: 16px;">
                            <?php echo $silver_sponsor_lists[$i]['meta']['Name'][0] ?>
                        </div>
                    <?php endif; ?>
                    
					<?php if(!empty($silver_sponsor_lists[$i]['meta']['Phone'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" >
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <?php echo $silver_sponsor_lists[$i]['meta']['Phone'][0] ?>
                        </div>
                    <?php endif; ?>
                
                    <?php if(!empty($silver_sponsor_lists[$i]['meta']['Email'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="mailto:<?php echo $silver_sponsor_lists[$i]['meta']['Email'][0] ?>"><?php echo $silver_sponsor_lists[$i]['meta']['Email'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($silver_sponsor_lists[$i]['meta']['Website'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                            <a href="<?php echo $silver_sponsor_lists[$i]['meta']['Website'][0] ?>" target="_blank"><?php echo $silver_sponsor_lists[$i]['meta']['Website'][0] ?></a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($silver_sponsor_lists[$i]['meta']['Address'][0])): ?>
                        <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                            <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                        </div>
                        
                        <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;">
                            <a href="http://maps.google.com/?q=<?php echo $silver_sponsor_lists[$i]['meta']['Address'][0] ?>" target="_blank"><?php echo $silver_sponsor_lists[$i]['meta']['Address'][0] ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
            
		<?php if(!empty($silver_sponsor_lists[$i+1])): ?>
            <div class="column-5_12 column_padding_bottom" style="float:right">
                    <p>
                        <?php echo wp_get_attachment_image( get_post_thumbnail_id($silver_sponsor_lists[$i+1]['id']),'silgold-partner-company-image' ); ?>
                    </p>
                    <div class="column-12_12 column_padding_bottom" style="margin-left:10px;padding-right:0px">
                        
                        <?php if(!empty($silver_sponsor_lists[$i+1]['meta']['Name'][0])): ?>
                            <div class="column-1 column_padding_bottom"  style="padding-bottom: 10px;font-weight: bold;font-size: 16px;">
                                <?php echo $silver_sponsor_lists[$i+1]['meta']['Name'][0] ?>
                            </div>
                        <?php endif; ?>
                        
						<?php if(!empty($silver_sponsor_lists[$i+1]['meta']['Phone'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" >
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_call.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <?php echo $silver_sponsor_lists[$i+1]['meta']['Phone'][0] ?>
                            </div>
                        <?php endif; ?>
                    
                        <?php if(!empty($silver_sponsor_lists[$i+1]['meta']['Email'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_email.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <a href="mailto:<?php echo $silver_sponsor_lists[$i+1]['meta']['Email'][0] ?>"><?php echo $silver_sponsor_lists[$i+1]['meta']['Email'][0] ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($silver_sponsor_lists[$i+1]['meta']['Website'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:10px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_web.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:10px;">
                                <a href="<?php echo $silver_sponsor_lists[$i+1]['meta']['Website'][0] ?>" target="_blank"><?php echo $silver_sponsor_lists[$i+1]['meta']['Website'][0] ?></a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($silver_sponsor_lists[$i+1]['meta']['Address'][0])): ?>
                            <div class="column-1_4 column_padding_bottom" style="padding-bottom:40px;">
                                <span style="padding-bottom:10px;width: 39px; background: transparent url('<?php echo site_url() ?>/wp-content/uploads/images/btn_location.png') no-repeat scroll 0px 0px; height: 39px; display: block; float: left; padding-right: 20px;"></span>
                            </div>
                            
                            <div class="column-3_4 column_padding_bottom" style="float:left;padding-bottom:40px;">
                                <a href="http://maps.google.com/?q=<?php echo $silver_sponsor_lists[$i+1]['meta']['Address'][0] ?>" target="_blank"><?php echo $silver_sponsor_lists[$i+1]['meta']['Address'][0] ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php if(($i+1)%2==1): ?>    
        	</div>    
        <?php endif; ?>
	<?php endfor; ?>
<?php endif; ?>
<?php get_footer(); ?>
