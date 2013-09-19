<?php
/**
 * Theme Name: BlackWorld
 * Theme URL: http://www.cssmoban.com/
 * 
 * Rewrite By GenialX
 *
 * @since Alpha 0.1.0
 */
get_header();
?>   
	 <div id="site_content">

        <?php get_sidebar();?>
            <div id="content">
        <ul class="slideshow">
          <li class="show"><img width="706" height="270" src="<?php site_link(); ?>/gx-content/themes/blackworld/images/1.jpg" alt="image one" /></li>
          <li><img width="706" height="270" src="<?php site_link(); ?>/gx-content/themes/blackworld/images/2.jpg" alt="image two" /></li>
          <li><img width="706" height="270" src="<?php site_link(); ?>/gx-content/themes/blackworld/images/3.jpg" alt="image three" /></li>
        </ul>
      
        <div id="content_item">
    	  		<?php while( have_posts() ): the_post();?>
      
    	  			<?php get_template_part('content'); ?>
      	
   	   			<?php endwhile ?>
   	   			</div>
   	   			      </div>
      
	  </div>
       
<?php get_footer();?>