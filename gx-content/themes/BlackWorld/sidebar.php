      <div id="sidebar_container">
        <div class="sidebar">
          <h1>About Me</h1>
          </br>
          <a href="#" target="_blank" ><img width="190px" height="260px" src="<?php site_link();?>gx-content/themes/blackworld/images/me_1.jpg" title="" alt=""/></a>
          <p>
          <pre>
描述...
		  </pre>
		  </p>
        </div>
        
        <div class="sidebar">
        	  <h1>Tag Wall</h1>
        </br>
        <ul style="margin:0px; padding:0px;">
                <?php 
        $article_tags = get_article_tags();
         foreach($article_tags as $value){
         	?>
         	 <li style="float:left;	list-style:none; "><a href="<?php tag_link($value); ?>" target="_blank"><?php echo $value; ?></a></li>
         	<?php
         }
         ?>
        </ul>      
        </div>
        

        <div class="sidebar">
          <h1>Random Articles</h1>
          <?php 
          		$articles = get_random_articles(10);
          		foreach($articles as $article){
          			?>
          				<li style="list-style:none; margin-bottom:4px;"><a href="<?php article_link($article['id']);?>" target="_blank"><?php echo $article['title'];?></a></li>
          			<?php
          		}
          ?>
		</div>
        
        <div class="sidebar">
          <h1>New Comments</h1>
          	<?php 
          		$comments = get_comments(10);
          		foreach($comments as $comment){
          		?>
          			<li style="list-style:none; margin-bottom:4px;"><a href="<?php article_link($comment['article_id']); ?>" target="_blank">
          			<?php echo $comment['content']; ?>
          			</a></li>
          		<?php
          		}
          	?>
        </div>
        

      </div>