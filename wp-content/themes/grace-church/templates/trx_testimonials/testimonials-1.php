<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'grace_church_template_testimonials_1_theme_setup' ) ) {
	add_action( 'grace_church_action_before_init_theme', 'grace_church_template_testimonials_1_theme_setup', 1 );
	function grace_church_template_testimonials_1_theme_setup() {
        grace_church_add_template(array(
            'layout' => 'testimonials-1',
            'template' => 'testimonials-1',
            'mode'   => 'testimonials',
            /*'container_classes' => 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom',*/
            'title'  => esc_html__('Testimonials /Style 1/', 'grace-church'),
            'thumb_title'  => esc_html__('Avatar (small)', 'grace-church'),
            'w'		 => 75,
            'h'		 => 75
        ));
	}
}

// Template output
if ( !function_exists( 'grace_church_template_testimonials_1_output' ) ) {
    function grace_church_template_testimonials_1_output($post_options, $post_data) {
        $show_title = true;
        $parts = explode('_', $post_options['layout']);
        $style = $parts[0];
        $columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));
        if (grace_church_param_is_on($post_options['slider'])) {
            ?><div class="swiper-slide" data-style="<?php echo esc_attr($post_options['tag_css_wh']); ?>" style="<?php echo esc_attr($post_options['tag_css_wh']); ?>"><?php
        } else if ($columns > 1) {
            ?><div class="column-1_<?php echo esc_attr($columns); ?> column_padding_bottom"><?php
        }

        ?>
        <div<?php echo ($post_options['tag_id'] ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''); ?> class="sc_testimonial_item<?php echo (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"<?php echo ($post_options['tag_css'] ? ' style="'.esc_attr($post_options['tag_css']).'"' : '');?>>
            <div class="columns_wrap sc_columns columns_nofluid sc_columns_count_4">
                <div class="column-3_4"  style="float:left;">
                    <div class="sc_testimonial_content"><?php echo trim($post_data['post_content']); ?></div>
                    <?php if ($post_options['author']) { ?>
                        <div class="sc_testimonial_author"><?php
                            echo ($post_options['link']
                                    ? '<a href="'.esc_url($post_options['link']).'" class="sc_testimonial_author_name">'.($post_options['author']).'</a>'
                                    : '<span class="sc_testimonial_author_name">'.($post_options['author']).'</span>')
                                . ($post_options['position']
                                    ? '<span class="sc_testimonial_author_position">'.($post_options['position']).'</span>'
                                    : ''); ?>
                        </div>
                    <?php } ?>
                    <?php if ($post_options['photo']) { ?>
                        <div class="sc_testimonial_avatar"><?php echo trim($post_options['photo']); ?></div>
                    <?php } ?>

                    <?php if (get_field( "author" )) { ?>
                        <div class="columns_wrap sc_columns columns_nofluid sc_columns_count_3">
                            <div class="column-2_3" style="float:left;text-align: left;">
                                <?php
                                $post = get_post();
                                ?>
                                <div class="my-rating jq-stars" id="rating_<?php echo $post->ID ?>"></div>
                            </div>
                            <div class="column-1_3" style="float:left;">
                                <div class="sc_testimonial_author">
                                    <?php echo '- '.get_field( "author" ); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="column-1_4" style="float:left;">
                    <?php
                    //echo get_field( "select_doctor" );
                    global $wpdb;
                    //echo "select * from ".$wpdb->prefix."cfcms_directory where id='".get_field( "select_doctor" )."'";

                    $project_lists = $wpdb->get_results("select * from ".$wpdb->prefix."cfcms_directory where id='".get_field( "select_doctor" )."' limit 1",'ARRAY_A');

                    //print_r($project_lists);
                    ?>
                    <img src="<?php echo $project_lists[0][image]; ?>" style="border-radius:50%;max-width: 150px">
                    <h5 style="margin-top: 0.3em;font-size: 1.366rem"><?php echo $project_lists[0][name] ?></h5>
                    <p style="margin-bottom: 0px;"><i><?php echo $project_lists[0][specialty] ?></i></p>
                    <p><?php echo $project_lists[0][office_city ].($project_lists[0][office_state ]?', '.$project_lists[0][office_state ]:'') ?></p>
                </div>
            </div>
        </div>
        <?php
        if (grace_church_param_is_on($post_options['slider']) || $columns > 1) {
            ?></div><?php
        }
    }
}
?>