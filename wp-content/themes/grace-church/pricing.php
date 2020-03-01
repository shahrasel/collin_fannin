<?php

/**
 * Template Name: WPC Pricing Template
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
<style>
	.container {
		margin-right: auto;
		margin-left: auto;
		padding-left: 15px;
		padding-right: 15px
	}
	@media (min-width:768px) {
	.container {
		width: 750px
	}
	}
	@media (min-width:992px) {
	.container {
		width: 970px
	}
	}
	@media (min-width:1200px) {
	.container {
		width: 1170px
	}
	}
	.container-fluid {
		margin-right: auto;
		margin-left: auto;
		padding-left: 15px;
		padding-right: 15px
	}
	.container>.navbar-header, .container-fluid>.navbar-header, .container>.navbar-collapse, .container-fluid>.navbar-collapse {
		margin-right: -15px;
		margin-left: -15px
	}
	@media (min-width:768px) {
	.container>.navbar-header, .container-fluid>.navbar-header, .container>.navbar-collapse, .container-fluid>.navbar-collapse {
		margin-right: 0;
		margin-left: 0
	}
	}
	@media (min-width:768px) {
	.navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
		margin-left: -15px
	}
	}
	.container .jumbotron {
	border-radius: 6px
}
.jumbotron .container {
	max-width: 100%
}
@media screen and (min-width:768px) {
.jumbotron {
	padding-top: 48px;
	padding-bottom: 48px
}
.container .jumbotron {
	padding-left: 60px;
	padding-right: 60px
}
.jumbotron h1, .jumbotron .h1 {
	font-size: 63px
}
}
.clearfix:before, .clearfix:after, .dl-horizontal dd:before, .dl-horizontal dd:after, .container:before, .container:after, .container-fluid:before, .container-fluid:after, .row:before, .row:after, .form-horizontal .form-group:before, .form-horizontal .form-group:after, .btn-toolbar:before, .btn-toolbar:after, .btn-group-vertical>.btn-group:before, .btn-group-vertical>.btn-group:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after, .pager:before, .pager:after, .panel-body:before, .panel-body:after, .modal-footer:before, .modal-footer:after {
	content: " ";
	display: table
}
div.section, #home {
    border-top: 5px solid #ff6d40;
}
.section {
    background: #fff none repeat scroll 0 0;
    box-shadow: 0 4px 1px 0 rgba(0, 0, 0, 0.05);
    display: block;
    padding: 2em;
}
.page-head {
    background: #fbfbfb none repeat scroll 0 0;
    display: block;
    margin: -2em -2em 2em;
    padding: 1.5em 2em;
}
h2 {
    font-size: 1.714em;
    font-weight: 500;
}
h1, h2, h3, h4, h5, h6 {
    color: #3d3d3d;
    margin: 0;
}
h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    
    line-height: 1.1;
}
.text-muted {
    color: #b2b2b2;
    margin: 0;
}
.sec-contents {
    background: #fff none repeat scroll 0 0;
    display: block;
}
.xs-section {
    border-top: 0 none !important;
    margin-top: -2em;
    padding-top: 0;
}
.bottom-margin {
    margin-bottom: 2em;
}
.section {
    background: #fff none repeat scroll 0 0;
    box-shadow: 0 4px 1px 0 rgba(0, 0, 0, 0.05);
    display: block;
    padding: 2em;
}

.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
html, body, div, p, table, tr, td, th, tbody, tfoot, ul, li, ol, dl, dd, dt, fieldset, blockquote, cite, input, select, textarea, button, a, section, article, aside, header, footer, nav {
    font-size: 13px;
}
.priceBox {
    background-color: rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(0, 0, 0, 0.05);
    margin: 1.5em 0;
    overflow: hidden;
    padding: 1em 1.5em 1.5em;
    transition: all 0.3s ease-in-out 0s;
}

.priceBox:hover {
	-webkit-box-shadow: 0 0 0 10px rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0 0 10px rgba(0, 0, 0, 0.08);
	box-shadow: 0 0 0 10px rgba(0, 0, 0, 0.08);
	background-color: rgba(0, 0, 0, 0.015);
}

.priceBox .heading {
    background-color: rgba(0, 0, 0, 0.5);
    margin: -1.3em -1.8em 0;
    padding: 1.25em 1.5em;
    transition: all 0.3s ease-in-out 0s;
}
.priceBox .heading h2 {
    color: #fff;
    font-weight: 500;
    text-shadow: 0 2px 1px rgba(0, 0, 0, 0.1);
    text-transform: capitalize;
}
.price {
    background-color: #fff;
    display: block;
    height: auto;
    margin: 0 -1.5em;
    padding: 1em;
    position: relative;
}
.text-center {
    text-align: center;
}
.price strong {
    display: block;
    font-size: 3em;
    font-weight: 700;
    line-height: 1.5em;
    margin-left: auto;
    margin-right: auto;
}
.price strong small {
    color: rgba(0, 0, 0, 0.5);
    font-size: 0.5em;
    font-weight: 200;
    margin-right: 0.3em;
}
.priceBox ul {
    list-style-type: none;
    margin: 0 -1.5em 1.5em;
    padding: 0;
}
.priceBox ul li {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 0.9em 0;
}
.priceBox .btn {
    margin: 0 1.5em;
}
.navbar-header, .btn, .schedule-box h6.section-head span, header.colored, .panel-heading a, .navigation nav ul li, .dateBox span, .hoverImg, .single-post-heading, .tags a:hover, .tagcloud a:hover, .add-comment, .comment-reply-link:hover, .admin-comment, .format-link .post-content > a, .format-link .post-content > p > a, .widget_search .search-form input[type="submit"], .widget_search input[type="submit"] {
    background-color: #ff6d40;
}

.btn {
    padding: 0.8em 1.5em 0.6em;
}
.btn {
    border: 1px solid rgba(0, 0, 0, 0.25);
    border-radius: 0;
    box-shadow: 0 1px 0 0 rgba(255, 255, 255, 0.2) inset;
    color: #fff;
    font-weight: 600;
    padding: 0.8em 1.5em;
    text-align: center;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
}
.btn {
    -moz-user-select: none;
    background-image: none;
    
    cursor: pointer;
    display: inline-block;
    font-size: 14px;
   
    line-height: 1.42857;
    
    vertical-align: middle;
    white-space: nowrap;
}
.scheme_original a{
	color: #fff;
}
.scheme_original a:hover{
	color: #fff;
}
</style>
<script>
	function scrolltochart() {
		jQuery(window).scrollTop(jQuery('#vo_bundles').offset().top-100);	
	}
</script>

<div class="section clearfix" style="padding-bottom:0px">
    <header style="margin-bottom:0px" class="page-head  clearfix">
        <h2>Pricing</h2>
        <p class="text-muted">Visit us before your buy.</p>
    </header> 
</div>
<br/>
<div class="sc_columns columns_wrap">
	<div class="column-1_3 column_padding_bottom">
		<div class="sc_team_item sc_team_item_1 odd first">
			<div class="priceBox">
                    <div class="heading">
                        <h2 style="font-size:1.514em">Private Office</h2>
                    </div>
                    <div class="price text-center"> Starting <strong>$695<small>/month</small> <span data-xsjson="{ &quot;price&quot;: &quot;$695&quot;, &quot;name&quot;: &quot;Private Office&quot;, &quot;cur&quot;: &quot;Starting&quot; }" class="hidden price-data-json"></span></strong> </div>
                    <ul class="text-center"><li>High Speed Internet</li><li>24/7 Keyless Entry Access</li><li>Conference Room Access</li><li>Reception Area</li><li>Free Parking</li></ul>
                    <a title="Request a Tour" href="#reqformdiv" class="btn">Request a Tour</a> 
                </div>
			</div>
		</div><div class="column-1_3 column_padding_bottom">
		<div class="sc_team_item sc_team_item_2 even">
			<div class="priceBox">
                    <div class="heading">
                        <h2 style="font-size:1.514em">Virtual Office &amp; Co-Working</h2>
                    </div>
                    <div class="price text-center"> Starting <strong>$50<small>/month</small> <span data-xsjson="{ &quot;price&quot;: &quot;$50&quot;, &quot;name&quot;: &quot;Virtual Office &amp; Co-Working&quot;, &quot;cur&quot;: &quot;Starting&quot; }" class="hidden price-data-json"></span></strong> </div>
                    <ul class="text-center"><li>Professional Business Address</li><li>Mail &amp; Package Handling</li><li>High Speed Internet</li><li>Reception Area</li><li>Free Parking</li></ul>
                    <a title="Request a Tour" href="#reqformdiv" class="btn">Request a Tour</a> 
                </div>
			</div>
		</div><div class="column-1_3 column_padding_bottom">
		<div class="sc_team_item sc_team_item_3 odd">
			<div class="priceBox">
                    <div class="heading">
                        <h2 style="font-size:1.514em">Conference Rooms</h2>
                    </div>
                    <div class="price text-center"> Starting <strong>$30<small>/hour</small> <span data-xsjson="{ &quot;price&quot;: &quot;$30&quot;, &quot;name&quot;: &quot;Meeting Rooms&quot;, &quot;cur&quot;: &quot;Starting&quot; }" class="hidden price-data-json"></span></strong> </div>
                    <ul class="text-center"><li>Seats 8-12 Comfortably</li><li>Presentation TV (HDMI)</li><li>Rolling White Board</li><li>Free Coffee</li><li>Free Parking</li></ul>
                    <a title="Request a Tour" href="#reqformdiv" class="btn">Request a Tour</a> 
                </div>
			</div>
		</div>
	</div>   
    
<div id="reqformdiv">
	<?php echo do_shortcode('[trx_contact_form title="REQUEST A TOUR" style="1" custom="no"][/trx_contact_form]'); ?>    
</div>

<?php get_footer(); ?>
