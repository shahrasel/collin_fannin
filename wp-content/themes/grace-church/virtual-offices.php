<?php

/**
 * Template Name: Virtual Office 1 Template
 * The template used for displaying page content in page.php
 *
 * @package xs
 */
$frontpage_id = get_option('page_on_front');
$self_id = get_the_ID();
global $within_section;
$within_section = 'y';
get_header();
?>
<script>
	function scrolltochart() {
		jQuery(window).scrollTop(jQuery('#vo_bundles').offset().top-100);	
	}
</script>
<link href="<?php echo get_template_directory_uri(); ?>/officevo.css" rel="stylesheet" type="text/css" />

<div class="container">
<h1 style="color: rgb(255, 255, 255);background-color: rgb(131, 132, 142); text-align: center;padding:15px;margin-top:0px;">Virtual Office 1</h1>
<div class="headerimage_five" style="background-color:#FFF;">
  <div class="content" style="padding-bottom: 0px;">
    <div class="two_col main_title">
      <h1 style="color: #000000;
    font-family: Effra,Helvetica,Arial,sans-serif;
    font-size: 42px;
    font-weight: bold;
    line-height: 44px;
    margin-bottom: 20px;
    padding-right: 50px;
    padding-top: 50px;">A professional company image without the cost of a physical office<img src="<?php echo get_template_directory_uri(); ?>/images_/full_stop_office_lp_short.png" width="18" height="16" /></h1>
      <a name="form"></a>
      <h2 class="mobileh2 unbold">Buy 12 months, Get 1 month free.</h2>
    </div>
    <div class="clearboth"></div>
  </div>
</div>
<div class="content" id="form-content-area" style="background-color:#FFF">
  <div class="two_col main_title_mobile">
    <h1>Ready-to-go office space, business centers, suites, and corporate offices<img src="<?php echo get_template_directory_uri(); ?>/images_/full_stop_office_lp_short.png"height="12" /></h1>
    <h2 class="mobileh2 unbold">3,000 locations across 120 countries.</h2>
  </div>
  <div class="double_col firstblock_full">
    <h2>Why use a Virtual Office from Work Place centers?</h2>
    <ul style="margin-bottom: 20px;">
      <li>Get a <strong>dedicated local telephone number</strong> – Our professional team will handle your calls.</li>
      <li>Get a <strong>mailing address/virtual address</strong> – We will receive and sign for mail and packages.</li>
      <li>Free Businessworld card – Exclusive discounts on day offices, meeting rooms and video conferencing.</li>
      <li>Includes <strong>access to meeting rooms, video conferencing and private offices</strong> – Make your first impression count.</li>
    </ul>
    <!--<a href="#vo_bundles"><img src="<?php echo get_template_directory_uri(); ?>/images_/bttn_compare.jpg" width="383" height="32" alt="Compare" /></a>--> 
    <a style="margin-top: 2.667rem;cursor:pointer" class="sc_button sc_button_square sc_button_style_filled sc_button_size_medium" onclick="scrolltochart()">COMPARE VIRTUAL OFFICE BUNDLES</a>
    </div>
  <div class="double_col firstblock_full">
    <div id="form1">
      <h2>Request a Tour</h2>
      <p style="font-size: 15px; line-height: 19px;">For pricing, availability and additional information, fill in the form below. We’ll be in touch shortly.</p>
      <form name="_ctl0" method="post" action="vo-generic1.aspx?keyword=Virtual%20Offices&amp;keyword2=Virtual%20Offices&amp;location=&amp;pivcode=SEM%20VO%20Virtual%20Offices&amp;se=Google&amp;gclid=CO-LwoG4hskCFQkyaQodtjcDqg&amp;siclientid=10507&amp;sessguid=ada89727-3b98-4fac-bedc-40fc368e999a&amp;userguid=ada89727-3b98-4fac-bedc-40fc368e999a&amp;permguid=ada89727-3b98-4fac-bedc-40fc368e999a" id="_ctl0">
        <input type="hidden" name="__VIEWSTATE" value="dDwtMzgyNDcxMzU1Ozs+7FbkbjCjsmibj/6vtviTa9FIldk=" />
        <span id="oCF">
        <div class="form-container" id="contactform"      >
          <div class="group-container ">
            <div class="group-title"></div>
            <div class="clearboth"><!-- --></div>
            <div class="both-cols ">
              <div class="field-label"><span></span> <span class="required">*</span> </div>
              <div class="general-input">
                <input name="oCF:FreeText0" type="text" value="Name*" id="oCF_FreeText0" onfocus="if (this.value == 'Name*') { this.value = ''; this.className = '' }" onblur="if (this.value == '') { this.value = 'Name*'; this.className = '' }" />
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            <!-- end input container -->
            <div class="clearboth"><!-- --></div>
            <div class="both-cols ">
              <div class="field-label"><span></span> <span class="required">*</span> </div>
              <div class="general-input">
                <input name="oCF:FreeText1" type="text" value="Email*" id="oCF_FreeText1" onfocus="if (this.value == 'Email*') { this.value = ''; this.className = '' }" onblur="if (this.value == '') { this.value = 'Email*'; this.className = '' }" />
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            <!-- end input container -->
            <div class="clearboth"><!-- --></div>
            <div class="both-cols ">
              <div class="field-label"><span></span> <span class="required">*</span> </div>
              <div class="general-input">
                <input name="oCF:FreeText2" type="text" value="Phone Number*" id="oCF_FreeText2" onfocus="if (this.value == 'Phone Number*') { this.value = ''; this.className = '' }" onblur="if (this.value == '') { this.value = 'Phone Number*'; this.className = '' }" />
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            <!-- end input container -->
            <div class="clearboth"><!-- --></div>
            <div class="both-cols ">
              <div class="field-label"><span></span> <span class="required">*</span> </div>
              <div class="general-input">
                <input name="oCF:FreeText3" type="text" value="Location of Interest*" id="oCF_FreeText3" onfocus="if (this.value == 'Location of Interest*') { this.value = ''; this.className = '' }" onblur="if (this.value == '') { this.value = 'Location of Interest*'; this.className = '' }" />
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            <!-- end input container -->
            <div class="clearboth"><!-- --></div>
            <div class="both-cols ">
              <div class="field-label"><span></span> </div>
              <div class="general-input">
                <textarea name="oCF:TextArea4" id="oCF_TextArea4" class="grey" onfocus="if (this.value == 'Tell us more. eg. I need a 3 person office...') { this.value = ''; this.className = '' }" onblur="if (this.value == '') { this.value = 'Tell us more. eg. I need a 3 person office...'; this.className = 'grey' }">Tell us more. eg. I need a 3 person office...</textarea>
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            <!-- end input container -->
            <div class="clearboth"><!-- --></div>
            <div class="both-cols UAID">
              <div class="field-label"><span>UAID</span> </div>
              <div class="general-input">
                <input name="oCF:FreeText11" type="text" id="oCF_FreeText11" />
              </div>
              <div class="clearboth"><!-- --></div>
            </div>
            
            <!-- end input container --></div>
          <div class="hint">*Required fields.<br />
            By clicking below you agree to our <br>
            <a target=_blank href="">terms and conditions</a></div>
          <div class="buttons">
            <div class="reset-button">
              <input type="reset" value="Reset" />
            </div>
            <div class="submit-button-border">
              <div class="submit-button">
                <input type="submit" name="submit" value="Submit" class="sc_button sc_button_square sc_button_style_filled sc_button_size_medium" style="background-color:#77756b" />
              </div>
            </div>
            <div class="clearboth"><!-- --></div>
          </div>
        </div>
        </span>
      </form>
    </div>
  </div>
  <div class="clearboth"></div>
</div>
<div class="grey_bg_full" style="background-color:#FFF">
  <div class="content">
    <div class="align_middle trust_pilot_mobile"><img src="<?php echo get_template_directory_uri(); ?>/images_/trust_pilot_mobile.jpg" width="301" height="35" /></div>
    <div class="one_col">
      <h3>Customer review</h3>
    </div>
    <div class="clearboth"></div>
    <div class="two_col review_space">
      <p><strong>Michael A.</strong> – <strong>Simply great for business!</strong></p>
      <p><img src="<?php echo get_template_directory_uri(); ?>/images_/star.png" width="26" height="26" class="stars"/><img src="<?php echo get_template_directory_uri(); ?>/images_/star.png" width="26" height="26" class="stars"/><img src="<?php echo get_template_directory_uri(); ?>/images_/star.png" width="26" height="26" class="stars"/><img src="<?php echo get_template_directory_uri(); ?>/images_/star.png" width="26" height="26" class="stars"/><img src="<?php echo get_template_directory_uri(); ?>/images_/star.png" width="26" height="26" class="stars"/></p>
      <p>This service is excellent regardless of being close to home or traveling. And a nice-to-have when you have extra time between meetings on the road as there is usually a center close to everywhere. And the free drinks and snacks bonus isn't bad either.</p>
    </div>
    <div class="one_col align_middle trust_pilot"><img src="<?php echo get_template_directory_uri(); ?>/images_/trust_pilot.jpg" width="208" height="164" /></div>
    <div class="clearboth"></div>
  </div>
</div>
<!--<div>
  <div class="content" style="padding-top: 35px;background-color:#FFF">
    <div class="three_col">
      <h2 class="unbold"><strong>Compare Virtual Office bundles</strong></h2>
    </div>
    <div class="double_col">
      <div class="one_col_icon_alt_two"><img src="<?php echo get_template_directory_uri(); ?>/images_/VOplus.jpg" width="100%" class="image_width" /></div>
      <div class="two_col_icon_alt_two">
        <h2>Virtual Office plus</h2>
        <ul class="standard_bullets">
          <li class="bullet_alt">5 days private office usage + internet</li>
          <li class="bullet_alt">Free access to 3,000 business lounges &amp; cafes</li>
          <li class="bullet_alt">Business address</li>
          <li class="bullet_alt">Telephone answering</li>
          <li class="bullet_alt">Mailbox Plus</li>
        </ul>
      </div>
      <div class="clearboth"></div>
    </div>
    <div class="double_col">
      <div class="one_col_icon_alt_two"><img src="<?php echo get_template_directory_uri(); ?>/images_/VO.jpg" width="100%" class="image_width" /></div>
      <div class="two_col_icon_alt_two">
        <h2>Virtual Office</h2>
        <ul class="standard_bullets">
          <li class="bullet_alt">Pick the address you always wanted</li>
          <li class="bullet_alt">Free access to 3,000 business lounges &amp; cafes</li>
          <li class="bullet_alt">Telephone answering</li>
          <li class="bullet_alt">Mail handling services</li>
        </ul>
      </div>
      <div class="clearboth"></div>
    </div>
    <div class="clearboth"></div>
    <div class="double_col">
      <div class="one_col_icon_alt_two"><img src="<?php echo get_template_directory_uri(); ?>/images_/TelephoneAnswering.jpg" width="100%" class="image_width" /></div>
      <div class="two_col_icon_alt_two">
        <h2>Telephone answering</h2>
        <ul class="standard_bullets">
          <li class="bullet_alt">Dedicated local business number</li>
          <li class="bullet_alt">Receptionist</li>
          <li class="bullet_alt">24hr voicemail access</li>
          <li class="bullet_alt">Discounts on day office, meeting rooms &amp; video conferencings</li>
        </ul>
      </div>
      <div class="clearboth"></div>
    </div>
    <div class="double_col" style="background-color:#FFF">
      <div class="one_col_icon_alt_two"><img src="<?php echo get_template_directory_uri(); ?>/images_/Mail.jpg" width="100%" class="image_width" /></div>
      <div class="two_col_icon_alt_two">
        <h2>Mailbox plus</h2>
        <ul class="standard_bullets">
          <li class="bullet_alt">Business address</li>
          <li class="bullet_alt">Mail and packages received and signed for</li>
          <li class="bullet_alt">Receptionist</li>
          <li class="bullet_alt">Discounts on day office, meeting rooms &amp; video conferencings</li>
        </ul>
      </div>
      <div class="clearboth"></div>
    </div>-->
    <div class="clearboth"></div>
    <div id="vo_bundles"></div>
    <br/><br/>
    <div class="three_col" style="background-color:#FFF">
      <table width="100%" class="vo_table">
        <tr>
          <td width="36%" align="left" valign="bottom" bgcolor="#FFFFFF"><h2>Virtual Office product benefits</h2></td>
          <td width="16%" bgcolor="#FFFFFF" align="center"><h2>$39</h2></td>
          <td width="16%" bgcolor="#FFFFFF" align="center"><h2>$79</h2></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>Professional DALLAS Address</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#F2F2F2"><p>Mail & Package Handling</p></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>Phone Line</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#F2F2F2"><p>Automated Answering Service</p></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2">&nbsp;</td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>Receptionist to Greet Clients</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#F2F2F2"><p>Coffee, Tea & Specialty Drinks</p></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>High Speed Internet</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#F2F2F2"><p>Office by the day</p></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2">1 Hour</td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>Dedicated Desk*</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#F2F2F2"><p>Enrichment & Networking</p></td>
          <td align="center" valign="middle" bgcolor="#F2F2F2">&nbsp;</td>
          <td align="center" valign="middle" bgcolor="#F2F2F2"><img src="<?php echo get_template_directory_uri(); ?>/images_/tick_green.png" width="20" height="16" /></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF"><p>Business Lounge Hours</p></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"></td>
          <td align="center" valign="middle" bgcolor="#FFFFFF"></td>
        </tr>
        <tr>
          <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          <td align="center" valign="middle" bgcolor="#FFFFFF">
          	<a href="#form-content-area">
            	<!--<img src="<?php echo get_template_directory_uri(); ?>/images_/table_quote.png" />-->
                <div class="sc_contact_form_item sc_contact_form_button"><button>REQUEST A TOUR</button></div>
            </a>
          </td>
          <td align="center" valign="middle" bgcolor="#FFFFFF">
          	<a href="#form-content-area">
            	<!--<img src="<?php echo get_template_directory_uri(); ?>/images_/table_quote.png" />-->
                <div class="sc_contact_form_item sc_contact_form_button"><button>REQUEST A TOUR</button></div>
            </a>
          </td>
        </tr>
      </table>
    </div>
    <div class="clearboth"></div>
  </div>
</div>
</div>
<?php get_footer(); ?>
