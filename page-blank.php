<?php /* Template Name: 15Zine Blank Page*/ ?>
<div id="cb-content" class="wrap clearfix">
  
    <div class="cb-main cb-module-block cb-wrap-pad cb-about-page clearfix">
		<?php 	while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </div> <!-- end .cb-main -->

</div> <!-- end #cb-inner-content -->