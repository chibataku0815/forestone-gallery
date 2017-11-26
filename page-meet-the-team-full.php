<?php /* Template Name: 15Zine Meet The Team Full-Width No Sidebar */

        get_header(); 
        $cb_page_id = get_the_ID();
        $cb_page_base_color = get_post_meta($cb_page_id , 'cb_overall_color_post', true );
        if ( ( $cb_page_base_color == '#' ) || ( $cb_page_base_color == NULL ) ) {
            $cb_page_base_color = ot_get_option('cb_base_color', '#eb9812'); 
        }  

        $cb_featured_image_style = get_post_meta( $cb_page_id, 'cb_featured_image_style', true );
         if ( ( $cb_featured_image_style == NULL ) || ( $cb_featured_image_style == 'standard-uncrop' ) ) {
            $cb_featured_image_style = 'standard';
        }
        if ( ( $cb_featured_image_style != 'off' ) && ( $cb_featured_image_style != 'standard' ) ) {cb_featured_image_style( $cb_featured_image_style, $post, 'page-overlay' ); };
?>       

	<div id="cb-content" class="wrap cb-wrap-pad clearfix">
  
	    <div class="cb-main cb-module-block cb-about-page clearfix">

            <?php cb_breadcrumbs(); ?> 

            <?php if ( ( ( $cb_featured_image_style == 'off' ) || ( $cb_featured_image_style == 'standard' ) ) ) { ?>

                 <div class="cb-module-header cb-category-header">
                       <h1 class="cb-module-title"><?php the_title(); ?></h1>
                </div>
                <?php cb_featured_image_style( $cb_featured_image_style, $post, 'page' );  ?>
            <?php } ?>
            <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    		<?php echo cb_author_list( true ); ?>

	    </div> <!-- end .cb-main -->
	    
	</div> <!-- end #cb-inner-content -->
            
<?php get_footer(); ?>