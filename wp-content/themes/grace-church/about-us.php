<?php
/**
 * Template Name: About Us
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
<br/><br/>
<?php while ( have_posts() ) : the_post(); ?>
	 <?php the_content(); ?>
<?php endwhile; ?>

<?php 
	$executive_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='EXECUTIVE BOARD')) order by ID asc",'ARRAY_A');
	
	$censors_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='BOARD OF CENSORS')) order by ID asc",'ARRAY_A');
	
	$house_delegates_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='HOUSE OF DELEGATES')) order by ID asc",'ARRAY_A');
	
	$house_delegates_alt_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='HOUSE OF DELEGATES (ALTERNATES)')) order by ID asc",'ARRAY_A');
	
	$legistation_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON LEGISLATION')) order by ID asc",'ARRAY_A');
	
	$prmedia_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON PR/MEDIA')) order by ID asc",'ARRAY_A');
	
	$public_grievance_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON PUBLIC GRIEVANCE/PHYSICIAN HEALTH & REHAB/WELLNESS')) order by ID asc",'ARRAY_A');
	
	$constitution_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON CONSTITUTION & BYLAWS')) order by ID asc",'ARRAY_A');
	
	$programs_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON PROGRAMS')) order by ID asc",'ARRAY_A');
	
	$nominations_lists = $wpdb->get_results("select ID,post_title from ".$wpdb->prefix."posts where post_type = 'committees' and post_status ='publish' and ID in (select post_id from ".$wpdb->prefix."postmeta where meta_key = 'category' and (meta_value ='COMMITTEE ON NOMINATIONS/TELLER')) order by ID asc",'ARRAY_A');
	
?>

<div class="wpb_column vc_column_container vc_col-sm-12">
<h6 class="sc_title sc_title_divider sc_align_left" style="margin-bottom:5%;margin-top:5%;text-align:left;"><span class="sc_title_divider_before"></span>History<span class="sc_title_divider_after"></span></h6><p>Care for the health of Texans</p>
</div>

<?php if(!empty($executive_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="margin-bottom:5%;text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>EXECUTIVE BOARD<span class="sc_title_divider_after"></span></h6><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($executive_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div><?php endif; ?>
        
        

<?php if(!empty($censors_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="margin-bottom:5%;text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>BOARD OF CENSORS<span class="sc_title_divider_after"></span></h6><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($censors_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div><?php endif; ?>
        
        
<?php if(!empty($house_delegates_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="margin-bottom:5%;text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>HOUSE OF DELEGATES<span class="sc_title_divider_after"></span></h6><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($house_delegates_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div>  <?php endif; ?>
        
        
        
<?php if(!empty($house_delegates_alt_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="margin-bottom:5%;text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>HOUSE OF DELEGATES (ALTERNATES)<span class="sc_title_divider_after"></span></h6><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($house_delegates_alt_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div><?php endif; ?> 
        
        
        
<?php if(!empty($legistation_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON LEGISLATION<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($legistation_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div>   <?php endif; ?>
        
        
        
<?php if(!empty($prmedia_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON PR/MEDIA<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($prmedia_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div>  <?php endif; ?>
        
        
        
<?php if(!empty($public_grievance_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON PUBLIC GRIEVANCE/PHYSICIAN HEALTH & REHAB/WELLNESS<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($public_grievance_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div>  <?php endif; ?> 
        
<?php if(!empty($constitution_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON CONSTITUTION & BYLAWS<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($constitution_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div> <?php endif; ?>
        
        
<?php if(!empty($programs_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON PROGRAMS<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($programs_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div> <?php endif; ?>
        
        
<?php if(!empty($nominations_lists)): ?>
<div class="wpb_column vc_column_container vc_col-sm-12"><div class="wpb_wrapper"><h6 style="text-align:left;" class="sc_title sc_title_divider sc_align_left"><span class="sc_title_divider_before"></span>COMMITTEE ON NOMINATIONS/TELLER<span class="sc_title_divider_after"></span></h6><p style="margin-bottom:5%;">INCLUDES EXECUTIVE BOARD MEMBERS, BOARD OF CENSORS & HOUSE OF DELEGATES</p><div class="sc_team_wrap" id="sc_team_952619503_wrap"><div data-slides-per-view="4" data-interval="7690" style="width:100%;" class="sc_team sc_team_style_team-4  sc_slider_nopagination sc_slider_nocontrols" id="sc_team_952619503"><div class="sc_columns columns_wrap"><?php foreach($nominations_lists as $executive_list): $image = wp_get_attachment_image( get_post_thumbnail_id($executive_list['ID']),'committee-image' ); ?><div class="column-1_4 column_padding_bottom">			<div class="sc_team_item sc_team_item_1 odd first" id="sc_team_952619503_1">
				<div class="sc_team_item_avatar"><?php if(!empty($image)): echo $image; else: echo '<img src="'.site_url().'/wp-content/uploads/2015/08/CFCMS_defaultpic-740x830.jpg" >'; endif; ?>					<div class="sc_team_item_hover">
						<div class="sc_team_item_info">
							<h5 class="sc_team_item_title"><a href="<?php echo get_post_meta($executive_list['ID'],'Link URL',true) ?>"><?php echo $executive_list['post_title'] ?></a></h5>
							<div class="sc_team_item_position"><?php echo get_post_meta($executive_list['ID'],'Title',true) ?></div>						
						</div>
					</div>
				</div>
			</div>
		</div><?php endforeach; ?></div></div><!-- /.sc_team --></div><!-- /.sc_team_wrap --></div></div>  <?php endif; ?>           
        
        
<?php get_footer(); ?>
