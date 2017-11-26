<?php 
    get_header();
    $cb_blog_style = cb_get_blog_style();
?>
<div id="cb-content" class="wrap cb-search-page cb-wrap-pad clearfix">
    
    <div class="cb-main clearfix cb-module-block cb-blog-style-roll">
       	
       	<div class="cb-module-header cb-category-header">
       		<p class="cb-mini-title"><?php _e('Search Results for', 'cubell'); ?></p>
		    <h1 class="cb-module-title"><?php echo get_search_query(); ?></h1>
		</div>

		<?php 

		if ( have_posts() ) { 

			include( locate_template( 'blog-style-' . $cb_blog_style . '.php') );

		} else {

		?>
		    
		<article id="post-not-found" class="cb-404-page clearfix">
	    
		    <section class="cb-entry-content cb-404-header">
		    	<h2><?php _e('Sorry, nothing found.', 'cubell'); ?></h2>
		        <p><?php _e('Please try searching again, but with different keywords.', 'cubell'); ?></p>
		    </section>
		    <footer class="widget_search cb-search">
		        <p><?php get_search_form(); ?></p>
		    </footer>
		</article>
    
        <?php } ?>
        
    </div> <!-- end .cb-main -->

    <?php if ( cb_get_sidebar_check( $cb_blog_style ) == true ) { get_sidebar(); } ?>
    
</div> <!-- end #cb-inner-content -->
                
<?php get_footer(); ?>