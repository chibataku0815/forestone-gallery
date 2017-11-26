<?php /* Template Name: 15Zine Drag & Drop Builder */

get_header();
$cb_page_id = get_the_ID();
$cb_section_a = get_post_meta( $cb_page_id, 'cb_section_a', true );
$cb_section_b = get_post_meta( $cb_page_id, 'cb_section_b', true );
$cb_section_c = get_post_meta( $cb_page_id, 'cb_section_c', true );
$cb_section_f = get_post_meta( $cb_page_id, 'cb_section_f', true );
$cb_section_g = get_post_meta( $cb_page_id, 'cb_section_g', true );
$cb_pb_onoff = get_post_meta( $cb_page_id, 'cb_pb_onoff', true );
$cb_fis_padding = $cb_fis_check = NULL;
$cb_dragger_ops = get_post_meta( $cb_page_id, '_cb_hp_dragger_option', true );

while ( have_posts() ) {

    the_post();
    $cb_classes = implode( ' ', get_post_class( 'clearfix', $cb_page_id ) );
    $cb_featured_image_style = get_post_meta( $cb_page_id, 'cb_featured_image_style', true );
     if ( $cb_featured_image_style == NULL ) {
        $cb_featured_image_style = 'standard';
    }
    if ( $cb_featured_image_style == 'standard-uncrop' ) {
        $cb_featured_image_style = 'standard';
    }
    if ( has_post_thumbnail( $cb_page_id ) ) {
        if ( ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style != 'standard' ) ) { $cb_fis_check = true; do_shortcode ( cb_featured_image_style( $cb_featured_image_style, $post, 'page-overlay' ) ); };
    }

    if ( get_the_content() != NULL) {
        echo '<div id="cb-content" class="wrap cb-pb cb-wrap-pad clearfix"><div class="cb-full-width clearfix"><article id="post-' . $cb_page_id . '" class="' . $cb_classes . ' cb-entry-content">';
        the_content();
        echo '</article></div></div>';
    }
}

$cb_paged = get_query_var('page');

if ( $cb_paged == NULL ) {

    for ( $cb_section_count = 1; $cb_section_count < 7; $cb_section_count++ ) {

         if ( $cb_dragger_ops == NULL ) {
            if ( $cb_section_count == 1 ) { $cb_x = 'a'; }
            if ( $cb_section_count == 2 ) { $cb_x = 'f'; }
            if ( $cb_section_count == 3 ) { $cb_x = 'b'; }
            if ( $cb_section_count == 4 ) { $cb_x = 'c'; }
            if ( $cb_section_count == 5 ) { $cb_x = 'g'; }
            if ( $cb_section_count == 6 ) { $cb_x = 'lp'; }
        } else {
            $cb_x = $cb_dragger_ops[$cb_section_count];
            if ( $cb_x == 'a2' ) {
                $cb_x = 'f';
            } elseif ( $cb_x == 'a3' ) {
                $cb_x = 'g';
            } elseif ( $cb_x == 'latest posts' ) {
                $cb_x = 'lp';
            }

        }
        

        if ( $cb_x == 'lp' ) {
            cb_hp_latest_posts( $cb_page_id );
        } elseif ( ${'cb_section_' . $cb_x} != NULL ) {

            if ( ( $cb_x == 'a' ) ) {
                $cb_section = 'a';
                $g = $j = $x = 0;
                echo '<section id="cb-section-a" class="cb-site-padding wrap cb-hp-section clearfix">';
            } elseif ( $cb_x == 'b' ) {
                $j = 0;
                $cb_section = NULL;
                echo '<section id="cb-section-b" class="cb-site-padding wrap cb-hp-section clearfix"><div class="cb-main">';
            } elseif ( $cb_x == 'c' ) {
                $cb_section = 'c';
                $j = 0;
                echo '<section id="cb-section-c" class="cb-site-padding wrap cb-hp-section clearfix">';
            } elseif ( $cb_x == 'f' ) {
                $cb_section = 'f';
                $j = 0;
                echo '<section id="cb-section-f" class="cb-section-fs clearfix">';
            } elseif ( $cb_x == 'g' ) {
                $cb_section = 'g';
                $j = 0;
                echo '<section id="cb-section-g" class="cb-section-fs clearfix">';
            }

            foreach ( ${'cb_section_' . $cb_x} as $cb_module ) {

                $cb_offset = $cb_order = $cb_orderby = $cb_filter = $cb_cat_id = $cb_tag_id = $cb_post_ids = $cb_tax_id = $cb_taxonomy = $cb_tax_qry = NULL;

                if ( isset($cb_module['cb_order']) ) {

                    if ( $cb_module['cb_order'] == 'cb_latest' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'date';
                    } elseif ( $cb_module['cb_order'] == 'cb_random' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'rand';
                    } elseif ( $cb_module['cb_order'] == 'cb_oldest' ) {
                        $cb_order = 'ASC';
                        $cb_orderby = 'date';
                    } elseif ( $cb_module['cb_order'] == 'cb_most_commented' ) {
                        $cb_order = 'DESC';
                        $cb_orderby = 'comment_count';
                    }

                }

                if ( isset($cb_module['cb_filter']) ) {

                    $cb_filter = $cb_module['cb_filter'];

                    if ( ( $cb_filter == 'cb_filter_category' ) && isset( $cb_module['cb_' . $cb_x . '_latest_posts'] ) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];

                        $cb_cat_id = implode(',', $cb_cat_id_selection);

                    } elseif ( ( $cb_filter == 'cb_filter_postid' ) && isset( $cb_module['ids_posts_cb'] ) ) {

                        $cb_post_names = array_filter( explode( '<cb>', $cb_module['ids_posts_cb'] ) );
                        $cb_post_ids = array();

                        foreach ( $cb_post_names as $cb_post_single ) {
                            $cb_post_single_term = get_page_by_title( $cb_post_single, OBJECT, 'post' );
                            if ( $cb_post_single_term != NULL ) {
                                $cb_post_ids[] = $cb_post_single_term->ID;
                            }

                        }

                    } elseif ( ( $cb_filter == 'cb_filter_tags' )  && isset( $cb_module['tags_cb'] ) ) {

                        $cb_tag_names = array_filter( explode( ',', $cb_module['tags_cb'] ) );
                        $cb_tag_id = array();
                        $cb_tag_names = array_filter(array_map('trim', $cb_tag_names));

                        foreach ( $cb_tag_names as $cb_tag ) {
                            $cb_tag_term = get_term_by( 'name', $cb_tag, 'post_tag' );
                            $cb_tag_id[] = $cb_tag_term->term_id;
                        }
                    }  elseif ( ( $cb_filter == 'cb_filter_ctax' ) && isset( $cb_module['cb_tax_list'] ) ) {
                        $cb_taxonomy = $cb_module['cb_tax_list'];
                        if ( isset($cb_module['ctax_cb']) ) {
                            $cb_tax_id =  $cb_module['ctax_cb'];
                        } else {
                            $cb_tax_terms = get_terms($cb_taxonomy);
                            $cb_tax_id = $cb_tax_terms[0]->term_id;
                        }
                        $cb_tax_qry = array(array('taxonomy' => $cb_taxonomy, 'field' => 'term_id', 'terms' => $cb_tax_id ) );

                    }

                } else {

                    if ( isset($cb_module['cb_' . $cb_x . '_latest_posts']) ) {
                        $cb_cat_id_selection = $cb_module['cb_' . $cb_x . '_latest_posts'];
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    } else {
                        $cb_cat_id_selection = get_terms( 'category', array('fields' => 'ids') );
                        $cb_cat_id = implode(',', $cb_cat_id_selection);
                        $cb_cat_name = get_category($cb_cat_id)->name;
                        $cb_cat_url = get_category_link($cb_cat_id);
                    }
                }

                if ( isset($cb_module['cb_offset']) ) {
                    $cb_offset = $cb_module['cb_offset'];
                }

                $cb_amount = $cb_module['cb_slider_' . $cb_x];

                $cb_title = $cb_module['title'];
                if ( ( $cb_section != 'f' ) && ( $cb_section != 'g' )) {
                    $cb_ad_code = $cb_module['cb_ad_code_' . $cb_x];
                     $cb_subtitle = $cb_module['cb_subtitle_' . $cb_x];

                    if ( $cb_subtitle != NULL ) {
                        $cb_subtitle = '<p>' . $cb_subtitle . '</p>';
                    }
                }

                $cb_custom = $cb_module['cb_custom_' . $cb_x];
                $cb_slider_ltr_rtl =  is_rtl() ? ' style="direction:ltr;"' : NULL;
                $cb_module_type = substr_replace( $cb_module['cb_' . $cb_x . '_module_style'] , '', -1 );

                if ( ( $cb_module_type == 'grid-2' ) || ( $cb_module_type == 'grid-3' ) || ( $cb_module_type == 'grid-4' ) || ( $cb_module_type == 'grid-5' ) || ( $cb_module_type == 'grid-6' ) ) {
                    $cb_ppp = substr( $cb_module_type, -1 );
                    $cb_module_type = 'grid-x';
                } else {
                    $cb_ppp = NULL;
                }

                if ( ( $cb_module_type == 'cl-1' ) || ( $cb_module_type == 'cl-2' ) || ( $cb_module_type == 'cl-3' ) ) {
                    $cb_size = substr( $cb_module_type, -1 );
                    $cb_module_type = 'cl-1';
                } else {
                    $cb_size = NULL;
                }

                if ( ( function_exists( 'get_term_meta' ) ) && ( $cb_cat_id != NULL ) ) {
                    $cb_category_color = get_term_meta( $cb_cat_id, 'cb_color_field_id', true );
                } else {
                    $cb_category_color = NULL;
                }

                include( locate_template('library/modules/cb-' . $cb_module_type . '.php') );

                if ( $cb_x == 'a' ) {

                    $j++;
                    $g++;
                    $x++;

                } elseif ( $cb_x == 'c' ) {

                    $j++;
                }
            }

            if ( $cb_x == 'b' ) {

                echo '</div>';

                $cb_sidebar_select =  get_post_meta( $cb_page_id, 'cb_sidebar_select', true );
                if ( $cb_sidebar_select == NULL ) {


                    if ( is_active_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id ) ) {
                        if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                            echo '<div class="cb-sticky-sidebar">';
                        }
                        echo '<aside id="cb-sidebar-' . $cb_x . '" class="cb-sidebar clearfix">';
                        dynamic_sidebar( 'sidebar-hp-' . $cb_x . '-' . $cb_page_id );
                        echo '</aside>';
                        if ( ot_get_option('cb_sticky_hp_sb', 'on') == 'on' ) {
                            echo '</div>';
                        }
                    }
                } else {

                    $cb_sidebar_id = $cb_sidebar_select;
                    if ( is_active_sidebar( $cb_sidebar_id ) == true ) {
                        if ( ( $cb_pb_onoff != 'on' ) && ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) ) {
                            echo '<div class="cb-sticky-sidebar">';
                        }
                        echo '<aside class="cb-sidebar clearfix">';
                        dynamic_sidebar( $cb_sidebar_id );
                        echo '</aside>';
                        if ( ( $cb_pb_onoff != 'on' ) && ( ot_get_option('cb_sticky_sb', 'on') == 'on' ) ) {
                            echo '</div>';
                        }
                    }
                }

            }

            echo '</section>';

        }

    }
} else {
    cb_hp_latest_posts( $cb_page_id );
}

get_footer();