<div id="popup_login" class="popup_wrap popup_login bg_tint_light" style="width:30.5em">
	<a href="#" class="popup_close"></a>
    <p style="display: none;color: #ff0000" id="login_failed">Sorry for the inconvenience. You are currently not a member of the Collin-Fannin County Medical Society.<br/>To join: <a style="color: #0000ff;font-size: 15px;" href="https://collinfannincms.org/wp-content/themes/grace-church/CFCMS%20Membership%20Application%202018.pdf" target="_blank">Click here</a><br/>To renew: <a style="color: #0000ff;font-size: 15px;" href="https://www.texmed.org/Login.aspx?ReturnUrl=%2fDues%2fInvoice.aspx" target="_blank">Click here</a></p>
    <p style="display: none;color: #ff0000" id="password_failed">You have entered the wrong password. Please enter your correct password or reset your password by clicking <a style="color: #0000ff;font-size: 15px;" href="https://collinfannincms.org/forgot-password/" target="_blank">here</a></p>
	<div class="form_wrap">
		<div class="form_left" style="border:none;width:100%;padding-right:0px;">
			<!--<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="popup_form login_form">-->
            <form method="post" name="login_form" class="popup_form" id="login_form" action="">
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr(home_url('/')); ?>">
				<div class="popup_form_field login_field iconed_field icon-user"><input type="text" id="log" name="log" value="" placeholder="<?php esc_html_e('Email', 'grace-church'); ?>" required="required"></div>
				<div class="popup_form_field password_field iconed_field icon-lock"><input type="password" id="password" name="pwd" value="" placeholder="<?php esc_html_e('Password', 'grace-church'); ?>" required="required"></div>
				<div class="popup_form_field remember_field">
					<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgot_password"><?php esc_html_e('Forgot password?', 'grace-church'); ?></a>
					<!--<input type="checkbox" value="forever" id="rememberme" name="rememberme">
					<label for="rememberme"><?php esc_html_e('Remember me', 'grace-church'); ?></label>-->
				</div>
                <input type="hidden" name="is_loggedin" value="1" />
				<div class="popup_form_field submit_field">
                	<input type="submit" class="submit_button" id="submit_button" value="<?php esc_html_e('Login', 'grace-church'); ?>" style="margin-bottom:10px">
  					<a href="<?php echo site_url() ?>/forgot-password/" style="color:#000">Forgot Password</a>
                </div>
			</form>
		</div>
		<?php /*?><div class="form_right">
			<div class="login_socials_title"><?php esc_html_e('You can login using your social profile', 'grace-church'); ?></div>
			<div class="login_socials_list">
				<?php echo grace_church_sc_socials(array('size'=>"tiny", 'shape'=>"round", 'socials'=>"facebook=#|twitter=#|gplus=#")); ?>
			</div>
			<div class="login_socials_problem"><a href="#"><?php esc_html_e('Problem with login?', 'grace-church'); ?></a></div>
			<div class="result message_block"></div>
		</div><?php */?>
	</div>	<!-- /.login_wrap -->
</div>		<!-- /.popup_login -->
