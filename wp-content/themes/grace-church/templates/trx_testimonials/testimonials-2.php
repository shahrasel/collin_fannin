<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'grace_church_template_testimonials_2_theme_setup' ) ) {
	add_action( 'grace_church_action_before_init_theme', 'grace_church_template_testimonials_2_theme_setup', 1 );
	function grace_church_template_testimonials_2_theme_setup() {
		grace_church_add_template(array(
			'layout' => 'testimonials-2',
			'template' => 'testimonials-2',
			'mode'   => 'testimonials',
			/*'container_classes' => 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols',*/
			'title'  => esc_html__('Testimonials /Style 2/', 'grace-church')
		));
	}
}

// Template output
if ( !function_exists( 'grace_church_template_testimonials_2_output' ) ) {
    function grace_church_template_testimonials_2_output($post_options, $post_data) {
        global $wpdb;
        //$show_title = true;
        //$parts = explode('_', $post_options['layout']);
        //$style = $parts[0];
        //$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
        $mydb = new wpdb('admin_coll','^8faX99z','admin_collin','localhost:8888');
        $testimonial_lists1 = $mydb->get_results("select * from ".$wpdb->prefix."testimonials where doctor_id = '".$_GET['id']."' order by ID desc",'ARRAY_A');
        //$columns = max(1, min(12, empty($parts[1]) ? (!empty(count($testimonial_lists1)) ? count($testimonial_lists1) : 1) : (int) $parts[1]));
        ?>

<?php
        if(!empty($testimonial_lists1)) {
            foreach ($testimonial_lists1 as $testimonial_list) { ?>
                <div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>">
                    <div class="columns_wrap sc_columns columns_nofluid sc_columns_count_4">
                        <div class="sc_testimonial_content" style="padding-left: 0px"><?php echo trim($testimonial_list['comment']); ?></div>

                        <div class="columns_wrap sc_columns columns_nofluid sc_columns_count_3">
                            <div class="column-2_3" style="float:left;text-align: left;">
                                <div class="my-rating jq-stars"  id="rating_<?php echo $testimonial_list['id'] ?>"></div>
                            </div>
                            <div class="column-1_3" style="float:left;">
                                <div class="sc_testimonial_author">
                                    <?php echo '- '.$testimonial_list['name']; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

<?php
             }
        } ?>


<?php

    }
}
?>