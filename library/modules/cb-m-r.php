<?php /* Module: Reviews Half-Width */

 $cb_cpt_output = cb_get_custom_post_types( $cb_taxonomy );
$i = 1 ;
$cb_title_header = NULL;
$cb_qry = new WP_Query( array( 'posts_per_page' => $cb_amount + 5, 'cat' => $cb_cat_id, 'tag__in' => $cb_tag_id, 'post__in' => $cb_post_ids, 'no_found_rows' => true, 'post_type' => $cb_cpt_output, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'offset' => $cb_offset, 'order' => $cb_order, 'orderby' => $cb_orderby, 'tax_query' => $cb_tax_qry, 'meta_query' => array('relation' => 'OR', array('key'     => 'cb_final_score', ), array('key' => '_lets_review_final_score_100', ), ) ) );

if ( $cb_qry->have_posts() ) {

    while ($cb_qry->have_posts()) : $cb_qry->the_post();
        $cb_post_id = $post->ID;
        $cb_review_checkbox = get_post_meta( $cb_post_id, 'cb_review_checkbox', true );

        if ( ( $cb_review_checkbox != 'on' ) && ( $cb_review_checkbox != 1 ) ) {
            if ( class_exists( 'Lets_Review_API' ) ) {
                $lets_review_api = new Lets_Review_API();
                if (  $lets_review_api->lets_review_get_onoff( $cb_post_id ) == false ) { continue; }
            } else {
                continue;
            }
        }

        if ($cb_title != NULL) {
            $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
        }

        if ( $i == 1 ) {
            echo '<div class="cb-module-r cb-module-block cb-module-half clearfix">' . $cb_title_header;
        }
?>
            <article class="cb-article-small cb-article-small-review cb-separated clearfix">

                <div class="cb-meta">

                    <h2 class="cb-post-title"><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
                    <?php cb_review_byline( $cb_post_id ); ?>  

                </div>

            </article>

            <?php 

        if ( $i ==  $cb_amount ) { break; }
        $i++; 
        endwhile;

        echo '</div>';

}

wp_reset_postdata();
?>