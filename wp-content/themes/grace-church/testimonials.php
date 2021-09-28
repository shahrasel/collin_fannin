<?php
/**
 * Template Name: Testimonials Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
session_start();
get_header();

if($_REQUEST['task'] == 'delete' && !empty($_REQUEST[id])) {
    global $wpdb;
    $wpdb->query("delete from `wp_testimonials` where id=".$_REQUEST[id]);
}

$sql = "SELECT * FROM `wp_testimonials` where doctor_id='".$_SESSION['ses_user']['id']."' order by id desc";
$testimonialLists = $wpdb->get_results($sql,'ARRAY_A');

if(!empty($_SESSION['ses_user'])):
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


	<div class="sc_contact_form_wrap" style="margin-bottom:40px">

        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/appointment-requests"><button>Appointment Requests</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/testimonials"><button style="background-color: #ff9279">Testimonials</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="http://www.emconsultinginc.com/Digital_Publications/CollinFannin/md_2016/"><button>Electronic Directory</button></a>&nbsp;&nbsp;

        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button>My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner">
                <div class="wpb_wrapper">
                    <div class="sc_section">
                        <div class="sc_section_inner">
                            <div class="sc_table" style="width:100%;">
                                <p><a href="<?php echo site_url().'/add-testimonial/'; ?>">Add New Testimonial</a></p>
                                <table>
                                    <tbody>
                                    <tr>
                                        <th style="text-align: center;">Created</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Rating</th>
                                        <th style="text-align: center;">Comment</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>


                                    </tr>
                                    <?php foreach($testimonialLists as $testimonialList): ?>
                                        <tr align="center">
                                            <td class="theme_color_dark" style="line-height: 18px"><?php echo date('m-d-y h:i a',$testimonialList['created']) ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $testimonialList['name'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $testimonialList['rating'] ?></td>
                                            <td align="center" style="line-height: 18px"><?php echo $testimonialList['comment'] ?></td>
                                            <td align="center">
                                                <div class="sc_socials_item" style="padding: 0px 8px;background-color: #fd7711;width:12px">
                                                    <a href="<?php echo get_site_url() ?>/edit-testimonial/?id=<?php echo $testimonialList['id'] ?>" class="social_icons social_twitter">
                                                        <span class="icon-pencil" style="color: #fff"></span>
                                                    </a>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="sc_socials_item" style="padding: 0px 8px;background-color: #c60913;width:12px">
                                                    <a href="<?php echo get_site_url() ?>/testimonials/?id=<?php echo $testimonialList['id'] ?>&task=delete" class="social_icons social_twitter" onclick="return confirm('Are you sure you want to delete this testimonial?');">
                                                        <span class="icon-trash" style="color: #fff"></span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<?php endif; ?>        


<?php get_footer(); ?>
