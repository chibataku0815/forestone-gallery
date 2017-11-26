 <?php /* Grids */

$i = 1;
if ( !isset( $cb_taxonomy ) ) {
    $cb_taxonomy = NULL;
}

$cb_cpt_output = cb_get_custom_post_types( $cb_taxonomy );
$cb_title_header = NULL;
$cb_no_sidebar = ' cb-block-no-sb';
$cb_cover_bg = false;

if ( is_home() == true ) {
    $cb_title = NULL;
    $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'cat' => $cb_cat_id, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

} elseif ( is_category() ) {

    $cb_title = NULL;
    $current_cat_id = get_query_var('cat');
    $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'cat' => $current_cat_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

} elseif ( is_tag() == true ) {

    $cb_title = NULL;
    $cb_qry = new WP_Query(array( 'posts_per_page' => $cb_ppp, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'tag_id' => $cb_tag_id, 'post_status' => 'publish', 'ignore_sticky_posts' => true )  );

} else {
    $cb_qry = NULL;
    $cb_no_sidebar = NULL;
    $cb_qry = new WP_Query( array( 'posts_per_page' => $cb_ppp, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby, 'tax_query' => $cb_tax_qry ) );
}

if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

    $cb_post_id = $post->ID;

    if ( ( $cb_title != NULL ) && ( $cb_section != 'f' ) && ( $cb_section != 'g' ) ) {
        $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
    }

    $cb_feature_width = '378';
    $cb_feature_height = '300';
    $cb_feature_tile_size = 'cb-s';
    
    switch ( $cb_ppp ) {
        case 2:
            $cb_feature_tile_size = 'cb-l';
            $cb_feature_width = '950';
            $cb_feature_height = '700';
            $cb_cover_bg = true;
            break;
        case 3:
            if ( $i == 1 )  {
                $cb_feature_width = '759';
                $cb_feature_height = '300';
                $cb_feature_tile_size = 'cb-m';
            }
            $cb_ppp .= ' cb-grid-3-static';
            $cb_no_sidebar = NULL;

            if ( ( $cb_section == 'f' ) || ( $cb_section == 'g' ) ) {
                $cb_cover_bg = true;
                if ( $i == 1 )  { 
                    $cb_feature_tile_size = 'cb-l';
                    $cb_feature_width = '950';
                    $cb_feature_height = '700';
                } else {
                    $cb_feature_tile_size = 'cb-m';
                    $cb_feature_width = '950';
                    $cb_feature_height = '400';
                }
                
            }
            break;
        case 4: 
            if ( ( $i == 1 ) || ( $i == 4 ) )  {

                $cb_feature_width = '759';
                $cb_feature_height = '300';
                $cb_feature_tile_size = 'cb-m';
            }
            break;
        case 5:
            if ( $i == 1 )  {
            
                $cb_feature_width = '759';
                $cb_feature_height = '300';
                $cb_feature_tile_size = 'cb-m';
            }

            if ( ( $cb_section == 'f' ) || ( $cb_section == 'g' ) ) {
                $cb_cover_bg = true;
                if ( $i == 1 )  { 
                    $cb_feature_tile_size = 'cb-l';
                    $cb_feature_width = '950';
                    $cb_feature_height = '700';
                } else {
                    $cb_feature_tile_size = 'cb-s';
                    $cb_feature_width = '480';
                    $cb_feature_height = '350';
                }
            }
            break;
    }




    if ( $i  == 1 ) {
        echo '<div class="cb-grid-block cb-module-block' . $cb_no_sidebar . ' clearfix">' . $cb_title_header . '<div class="cb-grid-x cb-grid-' . $cb_ppp . ' clearfix">';
    }
?>
    <div <?php post_class('cb-grid-feature cb-feature-' . esc_attr( $i ) . ' ' . esc_attr( $cb_feature_tile_size ) . ' ' . ot_get_option( 'cb_grid_tile_design', 'cb-meta-style-4') . ' clearfix'); ?>>
        
        <?php if ( $cb_cover_bg == false ) { ?>
            <div class="cb-grid-img">
                <?php cb_thumbnail( $cb_feature_width, $cb_feature_height ); ?>
            </div>
        <?php } else { ?>
            <?php cb_thumbnail_cover( $cb_feature_width, $cb_feature_height, $cb_post_id ); ?>
        <?php } ?>

        <div class="cb-article-meta">
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php cb_byline( $cb_post_id ); ?>
       </div>

       <a href="<?php the_permalink(); ?>" class="cb-link"></a>

    </div>

<?php

    $i++;
    endwhile;
    endif;
    echo '</div></div>';
    wp_reset_postdata();