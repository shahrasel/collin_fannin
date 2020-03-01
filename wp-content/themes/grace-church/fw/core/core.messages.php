<?php
/**
 * Grace-Church Framework: messages subsystem
 *
 * @package	grace_church
 * @since	grace_church 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('grace_church_messages_theme_setup')) {
	add_action( 'grace_church_action_before_init_theme', 'grace_church_messages_theme_setup' );
	function grace_church_messages_theme_setup() {
		// Core messages strings
		add_action('grace_church_action_add_scripts_inline', 'grace_church_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('grace_church_get_error_msg')) {
	function grace_church_get_error_msg() {
		global $GRACE_CHURCH_GLOBALS;
		return !empty($GRACE_CHURCH_GLOBALS['error_msg']) ? $GRACE_CHURCH_GLOBALS['error_msg'] : '';
	}
}

if (!function_exists('grace_church_set_error_msg')) {
	function grace_church_set_error_msg($msg) {
		global $GRACE_CHURCH_GLOBALS;
		$msg2 = grace_church_get_error_msg();
		$GRACE_CHURCH_GLOBALS['error_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('grace_church_get_success_msg')) {
	function grace_church_get_success_msg() {
		global $GRACE_CHURCH_GLOBALS;
		return !empty($GRACE_CHURCH_GLOBALS['success_msg']) ? $GRACE_CHURCH_GLOBALS['success_msg'] : '';
	}
}

if (!function_exists('grace_church_set_success_msg')) {
	function grace_church_set_success_msg($msg) {
		global $GRACE_CHURCH_GLOBALS;
		$msg2 = grace_church_get_success_msg();
		$GRACE_CHURCH_GLOBALS['success_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('grace_church_get_notice_msg')) {
	function grace_church_get_notice_msg() {
		global $GRACE_CHURCH_GLOBALS;
		return !empty($GRACE_CHURCH_GLOBALS['notice_msg']) ? $GRACE_CHURCH_GLOBALS['notice_msg'] : '';
	}
}

if (!function_exists('grace_church_set_notice_msg')) {
	function grace_church_set_notice_msg($msg) {
		global $GRACE_CHURCH_GLOBALS;
		$msg2 = grace_church_get_notice_msg();
		$GRACE_CHURCH_GLOBALS['notice_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('grace_church_set_system_message')) {
	function grace_church_set_system_message($msg, $status='info', $hdr='') {
		update_option('grace_church_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('grace_church_get_system_message')) {
	function grace_church_get_system_message($del=false) {
		$msg = get_option('grace_church_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			grace_church_del_system_message();
		return $msg;
	}
}

if (!function_exists('grace_church_del_system_message')) {
	function grace_church_del_system_message() {
		delete_option('grace_church_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('grace_church_messages_add_scripts_inline')) {
	function grace_church_messages_add_scripts_inline() {
		global $GRACE_CHURCH_GLOBALS;
		echo '<script type="text/javascript">'
			. 'jQuery(document).ready(function() {'
			// Strings for translation
			. 'GRACE_CHURCH_GLOBALS["strings"] = {'
				. 'bookmark_add: 		"' . addslashes( esc_html__('Add the bookmark', 'grace-church')) . '",'
				. 'bookmark_added:		"' . addslashes( esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'grace-church')) . '",'
				. 'bookmark_del: 		"' . addslashes( esc_html__('Delete this bookmark', 'grace-church')) . '",'
				. 'bookmark_title:		"' . addslashes( esc_html__('Enter bookmark title', 'grace-church')) . '",'
				. 'bookmark_exists:		"' . addslashes( esc_html__('Current page already exists in the bookmarks list', 'grace-church')) . '",'
				. 'search_error:		"' . addslashes( esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'grace-church')) . '",'
				. 'email_confirm:		"' . addslashes( esc_html__( 'On the e-mail address %s we sent a confirmation email. Please, open it and click on the link.', 'grace-church')) . '",'
				. 'reviews_vote:		"' . addslashes( esc_html__('Thanks for your vote! New average rating is:', 'grace-church')) . '",'
				. 'reviews_error:		"' . addslashes( esc_html__('Error saving your vote! Please, try again later.', 'grace-church')) . '",'
				. 'error_like:			"' . addslashes( esc_html__('Error saving your like! Please, try again later.', 'grace-church')) . '",'
				. 'error_global:		"' . addslashes( esc_html__('Global error text', 'grace-church')) . '",'
				. 'name_empty:			"' . addslashes( esc_html__('The name can\'t be empty', 'grace-church')) . '",'
				. 'name_long:			"' . addslashes( esc_html__('Too long name', 'grace-church')) . '",'
				. 'email_empty:			"' . addslashes( esc_html__('Too short (or empty) email address', 'grace-church')) . '",'
				. 'email_long:			"' . addslashes( esc_html__('Too long email address', 'grace-church')) . '",'
				. 'email_not_valid:		"' . addslashes( esc_html__('Invalid email address', 'grace-church')) . '",'
				. 'subject_empty:		"' . addslashes( esc_html__('The subject can\'t be empty', 'grace-church')) . '",'
				. 'subject_long:		"' . addslashes( esc_html__('Too long subject', 'grace-church')) . '",'
				. 'text_empty:			"' . addslashes( esc_html__('The message text can\'t be empty', 'grace-church')) . '",'
				. 'text_long:			"' . addslashes( esc_html__('Too long message text', 'grace-church')) . '",'
				. 'send_complete:		"' . addslashes( esc_html__("Send message complete!", 'grace-church')) . '",'
				. 'send_error:			"' . addslashes( esc_html__('Transmit failed!', 'grace-church')) . '",'
				. 'login_empty:			"' . addslashes( esc_html__('The Login field can\'t be empty', 'grace-church')) . '",'
				. 'login_long:			"' . addslashes( esc_html__('Too long login field', 'grace-church')) . '",'
				. 'login_success:		"' . addslashes( esc_html__('Login success! The page will be reloaded in 3 sec.', 'grace-church')) . '",'
				. 'login_failed:		"' . addslashes( esc_html__('Login failed!', 'grace-church')) . '",'
				. 'password_empty:		"' . addslashes( esc_html__('The password can\'t be empty and shorter then 4 characters', 'grace-church')) . '",'
				. 'password_long:		"' . addslashes( esc_html__('Too long password', 'grace-church')) . '",'
				. 'password_not_equal:	"' . addslashes( esc_html__('The passwords in both fields are not equal', 'grace-church')) . '",'
				. 'registration_success:"' . addslashes( esc_html__('Registration success! Please log in!', 'grace-church')) . '",'
				. 'registration_failed:	"' . addslashes( esc_html__('Registration failed!', 'grace-church')) . '",'
				. 'geocode_error:		"' . addslashes( esc_html__('Geocode was not successful for the following reason:', 'grace-church')) . '",'
				. 'googlemap_not_avail:	"' . addslashes( esc_html__('Google map API not available!', 'grace-church')) . '",'
				. 'editor_save_success:	"' . addslashes( esc_html__("Post content saved!", 'grace-church')) . '",'
				. 'editor_save_error:	"' . addslashes( esc_html__("Error saving post data!", 'grace-church')) . '",'
				. 'editor_delete_post:	"' . addslashes( esc_html__("You really want to delete the current post?", 'grace-church')) . '",'
				. 'editor_delete_post_header:"' . addslashes( esc_html__("Delete post", 'grace-church')) . '",'
				. 'editor_delete_success:	"' . addslashes( esc_html__("Post deleted!", 'grace-church')) . '",'
				. 'editor_delete_error:		"' . addslashes( esc_html__("Error deleting post!", 'grace-church')) . '",'
				. 'editor_caption_cancel:	"' . addslashes( esc_html__('Cancel', 'grace-church')) . '",'
				. 'editor_caption_close:	"' . addslashes( esc_html__('Close', 'grace-church')) . '"'
				. '};'
			. '});'
			. '</script>';
	}
}
?>