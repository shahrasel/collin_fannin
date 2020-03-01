<?php

/**
 * Template Name: WPC FAQ Template
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

<div class="sc_columns columns_wrap" style="background-color:#83848e;padding:15px;color:#fff;font-size:37px;text-align:center;line-height:40px;">
	FREQUENTLY ASKED QUESTIONS
</div>


<?php get_footer(); ?>
