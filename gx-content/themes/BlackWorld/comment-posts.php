           <table style="width:100%; border-spacing:0;">
            <tr><th style="background-color:gray;">名字</th><th style="background-color:gray;"><?php the_comment_name();?></th></tr>
            <tr><td>时间</td><td><?php the_comment_time();?></td></tr>
            <tr><td>QQ</td><td><?php the_comment_qq(); ?></td></tr>
            <tr><td>网址</td><td><?php the_comment_homepage();?></td></tr>
            <tr><td>内容</td><td><?php the_comment_content(); ?></td></tr>
          </table>