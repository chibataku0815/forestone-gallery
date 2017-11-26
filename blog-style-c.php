<?php /* Blog Style C */

$cb_count = 1;
$cb_qry = cb_get_qry();

if ( $cb_qry->have_posts() ) : while ( $cb_qry->have_posts() ) : $cb_qry->the_post();

    $cb_post_id = $post->ID;
     if ( $cb_count == 4 ) { $cb_count = 1; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "cb-blog-style-b cb-bs-c cb-module-a cb-article cb-article-row-3 cb-article-row cb-img-above-meta clearfix cb-separated cb-no-$cb_count" ); ?>>

    <div class="cb-mask cb-img-fw" <?php cb_img_bg_color( $cb_post_id ); ?>>
        <?php cb_thumbnail( '360', '240' ); ?>
        <?php cb_review_ext_box( $cb_post_id ); ?>
    </div>

    <div class="cb-meta">

        <h2 class="cb-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <?php cb_post_meta( $cb_post_id ); ?>
        <div class="cb-button cb-black cb-big cb-center">
          <a href="<?php the_field('custom_url'); ?>" target="_blank" rel="nofollow" style="margin:10px;">Go To SITE</a>
        </div>

    </div>

</article>

<?php
    $cb_count++;
    endwhile;
    cb_page_navi( $cb_qry );
    endif;
    wp_reset_postdata();
?>
