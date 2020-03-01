<?php
session_start();
if(empty($_SESSION['ses_user'])) {
    $_SESSION['adminuser'] = '';
    header('Location:'.site_url());
    exit;
}
//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
if(!empty($_POST)) {
    global $wpdb;
    if (!empty($_POST['username']) && !empty($_POST['comment'])) {
        $wpdb->query("INSERT INTO `wp_testimonials` (`id`, `doctor_id`, `name`, `rating`, `comment`, `created`) VALUES (NULL, '" . $_SESSION['ses_user']['id'] . "', '" . $_POST['username'] . "', '" . $_POST['rating'] . "', '" . $_POST['comment'] . "', '" . time() . "')");
        wp_redirect(get_site_url().'/testimonials');
        exit();
    }
}
get_header();

/**
 * Template Name: Testimonial Add Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */


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
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="https://physicianfinder.collinfannincms.com/wp-content/uploads/2020/01/CollinFannin2019Dir_web.pdf" target="_blank"><button>Electronic Directory</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'/videos'; ?>"><button>Videos</button></a>&nbsp;&nbsp;
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url() ?>/cfcms-directory"><button>My Profile</button></a>
        <a style="color:#fff;margin: 10px 0px;display: inline-block" href="<?php echo site_url().'?logout=true'; ?>"><button>Logout</button></a>
    </div>

    <div class="sc_contact_form_wrap">

      <div class="sc_contact_form1 sc_contact_form_standard sc_contact_form_style_1">
        <form action="" method="post" id="myform" enctype="multipart/form-data">
          <div class="sc_contact_form_info">
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="username">Name</label>
              <input type="text" placeholder="Full Name" name="username" id="username" value="" required>
            </div>
            <div class="sc_contact_form_item sc_contact_form_field label_over">
              <label for="rating">Rating</label>
              <select name="rating" style="border: 2px solid #f4f4f4; padding: 0.8em 1.9em; width: 100%;" required>
                <option value="">Select Rating</option>
                  <option value="0.5">0.5</option>
                  <option value="1">1</option>
                  <option value="1.5">1.5</option>
                  <option value="2">2</option>
                  <option value="2.5">2.5</option>
                  <option value="3">3</option>
                  <option value="3.5">3.5</option>
                  <option value="4">4</option>
                  <option value="4.5">4.5</option>
                  <option value="5">5</option>
              </select>
              
              
            </div>

            <div class="sc_contact_form_item sc_contact_form_message label_over" style="width:100%">
                <label for="comment">Comment</label>
                <textarea placeholder="Comment" name="comment" id="comment" required></textarea>
              </div>
          </div>
            
          <input type="hidden" name="formsub" value="1">
          
          <div class="sc_contact_form_item sc_contact_form_button" style="margin-top:10px;">
            <button>ADD</button>
          </div>
          
        </form>
      </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>
