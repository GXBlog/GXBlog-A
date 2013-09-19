<?php
get_header('list');
?>   
	<div class="inner_copyright">Collect from <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a></div>

    
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
       
<?php get_footer('sub');?>