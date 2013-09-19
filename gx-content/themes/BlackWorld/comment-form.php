<form action="#" method="post">
   <div class="form_settings">
   <p><span>名字</span><input type="text" id="comment_name" name="comment_name" value="" /></p>
   <p><span>QQ</span><input type="text" id="comment_qq" name="comment_qq" value="" /></p>
   <p><span>网址</span><input type="text" id="comment_homepage" name="comment_homepage" value="" /></p>
   <p><span>内容</span><textarea rows="8" cols="50" id="comment_content" name="comment_content"></textarea></p>
   <!-- 
    <p><span>Checkbox example</span><input class="checkbox" type="checkbox" name="name" value="" /></p>
    <p><span>Dropdown list example</span><select id="id" name="name"><option value="1">Example 1</option><option value="2">Example 2</option></select></p>

   -->
   <p style="padding-top: 15px"><span>&nbsp;</span><input class="submit" type="button" name="comment_button" id="comment_button" value="提交" onmousedown="comment()"/></p>
   <input type="hidden" name="article_id" id="article_id" value="<?php echo $_GET['p']; ?>"/>
   <input type="hidden" name="comment_action" id="comment_action" value="insert"/>
   </div>
</form>