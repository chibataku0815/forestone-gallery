<?php
	get_header();
	$cb_blog_style = cb_get_blog_style();
?>

<div id="cb-content" class="wrap cb-wrap-pad clearfix">
    
    <div class="cb-main clearfix cb-module-block">
        
        <?php cb_breadcrumbs(); ?> 
        <div class="cb-module-header cb-category-header">
            <?php the_archive_title( '<h1 class="cb-module-title">', '</h1>' ); ?>
            <?php the_archive_description(); ?>
        </div>
        
        <?php include( locate_template( 'blog-style-' . $cb_blog_style . '.php') ); ?>

    </div> <!-- .cb-main -->

   <?php if ( cb_get_sidebar_check( $cb_blog_style ) == true ) { get_sidebar(); } ?>

</div> <!-- end /#cb-content -->

<?php get_footer(); ?>